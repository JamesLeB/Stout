<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

	#private $model;
	private $filePath = 'files/EDIbatches/';

	function __construct(){
		parent::__construct();
		#$this->load->model('Character_model');
		#$this->model = $this->Character_model;
	}
	public function test(){
		$ms = 'Starting test<br/>';
		#$dbtest = $this->model->test();
		$file = 'test.txt';
		$ms .= "Saving file<br/>";
		file_put_contents($this->filePath.$file,"ready to move file and open it lunch time");
		$ms .= "Done Test<br/>";
		echo $ms;
	}
	public function read277(){
		header('status: Reading 277');
		$x12 = file_get_contents('files/edi/277/a.x12');
		$segments = preg_split('/~/',$x12);
		$m = array();
		try{
			throw new exception("Fuck");
			$m[] = "ok yes";
		}catch(exception $e){
			$error = $e->getMessage();
			$m[] = "Error: $error";
		}
		$e='';foreach($m as $mm){$e .= "$mm<br/>";}echo $e;
	}
	public function create837D(){

		header('status: Creating 837D');

		require('lib/classes/EDI837.php');
		require('lib/classes/EDI837D.php');
		require('lib/classes/dentalClaim.php');
		require('lib/classes/billingProvider.php');
		require('lib/classes/service.php');
		require('lib/classes/patient.php');

		$m = array();
		$m[] = "Messages...";
		$batchCount  = 0;
		$batchAmount = 0;
		$batchNumber;

		try{
			# LOAD HEADER
			$serial = file_get_contents('files/a.ser');
			$obj = unserialize($serial);
			$ediObj = $obj{'ediObj'};
			$edi = $ediObj->getStuff();
			$date6 = $edi{'date'};
			$date8 = "20$date6";
			$time = $edi{'time'};
			$batch = $edi{'batch'};
			$batch = preg_replace('/^0/','1',$batch);
			$batchNumber = $batch;
			$x12 = array();
			$x12[] = "ISA*00*          *00*          *ZZ*F00            *ZZ*EMEDNYBAT      *$date6*$time*U*00501*$batch*0*P*:";
			$x12[] = "GS*HC*F00*EMEDNYBAT*$date8*$time*$batch*X*005010X223A2";
			$x12[] = "ST*837*0001*005010X223A2";
			$x12[] = "BHT*0019*00*$batch*$date8*$time*CH";
			$x12[] = "NM1*41*2*NEW YORK UNIV DENTAL CTR*****46*F00";
			$x12[] = "PER*IC*TYKIEYEN MOORE*TE*2129989879";
			$x12[] = "NM1*40*2*NYSDOH*****46*141797357";
			$x12[] = "HL*1**20*1";
			$x12[] = "NM1*85*2*NEW YORK UNIV DENTAL CTR*****XX*1164555124";
			$x12[] = "N3*345 E 24TH ST 213S";
			$x12[] = "N4*NEW YORK*NY*100104020";
			$x12[] = "REF*EI*135562308";
		
			# LOAD SUBSCRIBER
			$HL = 1;
			$providers = $edi{'providers'};

			foreach($providers as $provider){
				$claims = $provider->getClaims();
				foreach($claims as $claim){

					# Check for Claims that have no valid ADA codes
					$checkForValidAda = 0;
					$services = $claim->getServices();
					foreach($services as $service){
						$serviceData = $service->getStuff();
						$adaCode = $serviceData{'adacode'};
						$adaCode = preg_split('/:/',$adaCode);
						$adaCode  = $adaCode[1];
						if($adaCode != 1428){$checkForValidAda = 1;}
					}

					if($checkForValidAda){
	
						$claimData = $claim->getStuff();
			
						$last             = $claimData{'last'};
						$first            = $claimData{'first'};
						$subscriberId     = $claimData{'id'};
						$birthdate        = $claimData{'birth'};
						$sex              = $claimData{'sex'};
						$claimId          = $claimData{'claimid'};
						$claimServiceDate = $claimData{'date'};
						$claimAmount      = $claimData{'amount'};
	
						$batchCount++;
						$batchAmount += $claimAmount;
	
						$HL++;
						$x12[] = "HL*$HL*1*22*0";
						$x12[] = "SBR*P*18*******MC";
						$x12[] = "NM1*IL*1*$last*$first****MI*$subscriberId";
						$x12[] = "DMG*D8*$birthdate*$sex";
						$x12[] = "NM1*PR*2*NYSDOH*****PI*141797357";
						$x12[] = "CLM*$claimId*$claimAmount***79:A:1**A*Y*Y";
						$x12[] = "DTP*434*RD8*$claimServiceDate-$claimServiceDate";
						$x12[] = "CL1*1*7*30";
						$x12[] = "HI*BK:52100";
						$x12[] = "HI*BE:24:::1428";
						$x12[] = "NM1*71*1*DESTENO*COSMO****XX*1518920727";
	
						$services = $claim->getServices();
	
						$serviceIndex = 0;
						$serviceTotal = 0;
						foreach($services as $service){
							$serviceData = $service->getStuff();
							$adaCode         = $serviceData{'adacode'};
							$lineAmount      = $serviceData{'amount'};
							$lineServiceDate = $serviceData{'date'};
	
							$adaCode = preg_split('/:/',$adaCode);
							$adaCode  = $adaCode[1];
	
							if($lineServiceDate != $claimServiceDate){
								# disabled
								#throw new exception("Date miss match $claimId");
							}
							if($adaCode != '1428'){
								$serviceIndex++;
								$serviceTotal += $lineAmount ;
								$x12[] = "LX*$serviceIndex";
								$x12[] = "SV2*0512*HC:$adaCode*$lineAmount*UN*1";
								$x12[] = "DTP*472*RD8*$lineServiceDate-$lineServiceDate";
							}
						}# end services loop
						if(round($claimAmount,2) != round($serviceTotal,2)){
							throw new exception("Claim Out of Balance
								$claimAmount:$serviceTotal - $claimId");
						}
					}else{
						$claimData = $claim->getStuff();
						$claimId = $claimData{'claimid'};
						$m[] = "Bad Claim $claimId";
					}# END IF
				}# end claims loop
			}# end providers loop
		
			# LOAD FOOTER
			$segmentCount = sizeof($x12)-1;
			$x12[] = "SE*$segmentCount*0001";
			$x12[] = "GE*1*$batch";
			$x12[] = "IEA*1*$batch";
		
			# SAVE FILE TO DISK
			$file = "B".substr($batchNumber,strlen($batchNumber)-4,4);
			$x12 = implode("~",$x12)."~";
			file_put_contents("files/edi/$file.x12",$x12);
			file_put_contents("files/edi/z.x12",$x12);

			#throw new exception("this is an error");
			$m[] = 'OK';
			$m[] = "Batch Number: $batchNumber";
			$m[] = "Batch Count: $batchCount";
			$m[] = "Batch Amount: $batchAmount";

		}catch(exception $e){
			$error = $e->getMessage();
			$m[] = $error;
		}

		$m = implode("<br/>",$m);
		echo $m;

	}
	public function convertEdi(){
		header('status: Converting Axium EDI');
		require('lib/classes/EDI837.php');
		require('lib/classes/EDI837D.php');
		require('lib/classes/dentalClaim.php');
		require('lib/classes/billingProvider.php');
		require('lib/classes/service.php');
		require('lib/classes/patient.php');
		$EDI = new EDI837();

		if(1){
			# LOAD and save EDI837D
			$obj = $EDI->loadEDI837D();
			$serial = serialize($obj);
			file_put_contents('files/a.ser',$serial);
		}

		$serial = file_get_contents('files/a.ser');
		$obj = unserialize($serial);
		$message = $obj{'message'};
		$ediObj =  $obj{'ediObj'};

		$m = array();
		$m[] = '-----------------';
		$m[] = 'EDI Object Output';
		$m[] = '-----------------';
		$m[] = 'Load 837D message...';
		$m[] = $message;
		$m[] = '-----------------';
		$e = ''; foreach($m as $mm){$e .= "$mm<br/>";}
		echo $e;

		# Create provider List
		$providers = $ediObj->getProviders();
		$l = array();
		foreach($providers as $p){

			# Create Provider Data
			$ll = array();
			$ll[] = array(
				'Heading' => 'Data',
				'Body'    => $p->toText()
			);
			# Create Claim List
			$claims = $p->getClaims();
			$claimL = array();
			foreach($claims as $claim){
				# Create Claim Body
				$claimB = array();
				$claimB[] = array(
					'Heading' => 'Data',
					'Body'    => $claim->toText()
				);
				# Create Procedure List
				$procedures = $claim->getServices();
				$procl = array();
				foreach($procedures as $proc){
					$procl[] = array(
						'Heading' => 'Service',
						'Body'    => $proc->toText()
					);
				}
				$p = array('myList'=>$procl);
				$procedureList = $this->load->view('myList',$p,true);
				$claimB[] = array(
					'Heading' => 'Services',
					'Body'    => $procedureList
				);
				$p = array('myList'=>$claimB);
				$claimBody = $this->load->view('myList',$p,true);
				$claimL[] = array(
					'Heading' => 'Claim',
					'Body'    => $claimBody
				);
			}
			$p = array('myList'=>$claimL);
			$claimList = $this->load->view('myList',$p,true);
			$ll[] = array(
				'Heading' => 'Claims',
				'Body'    => $claimList
			);
			$p = array('myList'=>$ll);
			$providerData = $this->load->view('myList',$p,true);

			$l[] = array(
				'Heading' => 'Provider',
				'Body'    => $providerData
			);
		}
		$p = array('myList'=>$l);
		$providerList = $this->load->view('myList',$p,true);
		# Create 837D body
		$l = array();
		$l[] = array(
			'Heading' => 'Data',
			'Body'    => $ediObj->toText()
		);
		$l[] = array(
			'Heading' => 'Providers',
			'Body'    => $providerList
		);
		$p = array('myList'=>$l);
		$body837D = $this->load->view('myList',$p,true);
		# Create Final List
		$myList = array();
		$myList[] = array(
			'Heading' => '837D',
			'Body'    => $body837D
		);
		$parm = array('myList'=>$myList);
		echo $this->load->view('myList',$parm,true);
		echo "
			<script>
				$('.myBody').hide();
				$('.myHeading button').click(function(){
					$(this).parent().next().toggle();
				});
			</script>
		";
/*
		foreach($a as $c){
			$provList = array();
			$provList[] = array(
				'Heading' => 'Data',
				'Body' => $c->toText()
			);
			$provList[] = array(
				'Heading' => 'Claims',
				'Body' => 'ClaimList'
			);
			$parm = array('myList'=>$provList);
			$body = $this->load->view('myList',$parm,true);
			
			$myList[] = array(
				'Heading' => $c->getBillingProviderName(),
				'Body' => $body
			);
		}
*/
	}# END function convertEdi
	private function removeInvalidCharacters($x12){
		#$file = 'a.txt';
		#$x12 = file_get_contents($this->filePath.$file);
		$x12 = preg_replace('/,/','',$x12);
		$x12 = preg_replace('/#/','',$x12);
		$x12 = preg_replace('/"/','',$x12);
		$x12 = preg_replace('/\t/','',$x12);
		$x12 = preg_replace('/`/','',$x12);
		$x12 = preg_replace('/\[/','',$x12);
		$x12 = preg_replace('/&/','',$x12);
		$x12 = preg_replace('/\//','',$x12);
		return $x12;
/*
		if(preg_match('//',$x12)){
			echo "Invalid<br/>";
		}else{
			echo "Everything Ok<br/>";
		}
		echo "Done";
*/
	}
	public function getTestFile(){
		$secret = '';
		if(isset($_REQUEST['secret'])){
			$secret = $_REQUEST['secret'];
		}
		$file = 'a.txt';
		$x12 = file_get_contents($this->filePath.$file);
		$x12 = $this->removeInvalidCharacters($x12);
		$nX12 = $this->processX12($x12);
		$file = 'b.x12';
		file_put_contents($this->filePath.$file,$nX12);
		if($secret == 'all'){echo $this->toTextX12($nX12);}
		if($secret == 'claims'){
			try{
				$edi = $this->loadEDI($nX12);
				$myList = array();
				# Add head to my List
				$ms = '';
				foreach($edi[0] as $a){
					$ms .= "$a<br/>";
				}
				$heading = 'Heading';
				$body    = $ms;
				$myList[] = array(
					'Heading' => $heading,
					'Body'    => $body
				);
				# Add Claims to my List
				$claimList = array();
				$sumClaimAmount = 0;
				$chartNumber = "";
				$serviceDate = "";
				foreach($edi[1] as $a){
					$sumProcedureAmount = 0;
					$claimInfo = '';
					$claimAmount = 0;
					foreach($a[1][0] as $b){
						if(preg_match('/^CLM\*/',$b)){
							$temp = preg_split('/\*/',$b);
							$claimAmount= $temp[2];
							$claimId = preg_split('/-/',$temp[1]);
							$chartNumber = $claimId[0];
							$sumClaimAmount += $claimAmount;
						}
						if(preg_match('/^DTP\*434\*/',$b)){
							$temp = preg_split('/\*/',$b);
							$dateRange = preg_split('/-/',$temp[3]);
							$serviceDate = $dateRange[0];
						}
						$claimInfo .= "$b<br/>";
					}
					$procedureList = array();
					foreach($a[1][1] as $b){
						$procedureBody = '';
						$procedureAmount = 0;
						foreach($b as $c){
							if(preg_match('/^SV2\*/',$c)){
								$temp = preg_split('/\*/',$c);
								$procedureAmount = $temp[3];
								$sumProcedureAmount += $procedureAmount;
							}
							$procedureBody .= "$c<br/>";
						
						}
						$procedureHead = "Procedure - $ $procedureAmount";
						$procedureList[] = array(
							'Heading' => $procedureHead,
							'Body'    => $procedureBody
						);
					}
					$procedures = $this->load->view('myList',array('myList'=>$procedureList),true);
					# Add Provider to my List
					$provider = '';
					foreach($a[0] as $b){
						$provider .= "$b<br/>";
					}
					$claim = array();
					$claim[] = array(
						'Heading' => "Claim Info # $chartNumber --- $serviceDate",
						'Body'    => $claimInfo 
					);
					$claim[] = array(
						'Heading' => 'Provider',
						'Body'    => $provider
					);
					$claim[] = array(
						'Heading' => "Procedures - $ $claimAmount",
						'Body'    => $procedures
					);
					$claimBody = $this->load->view('myList',array('myList'=>$claim),true);
					$claimHead = "Claim - $ $sumProcedureAmount";
					$claimList[] = array(
						'Heading' => $claimHead,
						'Body'    => $claimBody 
					);
				}
				$claims = $this->load->view('myList',array('myList'=>$claimList),true);
				$heading = "Claim List - $ $sumClaimAmount";
				$body    = $claims;
				$myList[] = array(
					'Heading' => $heading,
					'Body'    => $body
				);
				$parm = array('myList'=>$myList);
				echo $this->load->view('myList',$parm,true);
				# MUST LOAD JAVASCRIPT AFTER ALL myLists are added to the DOM
				# to prevent multiple listeners from attaching to each item
				echo "
					<script>
						$('.myBody').hide();
						$('.myHeading button').click(function(){
							$(this).parent().next().toggle();
						});
					</script>
				";
			} catch (Exception $e){
				echo $e->getMessage();
			}
		}
		#echo $this->toTextX12($x12);
	} # END getTEstFile function
	private function loadBillingProvider($seg,&$segments){
		#throw new Exception('not ready to load provider');
		$provider = array();
		$provider[] = $seg;
		# Load PRV 
		$seg = array_shift($segments);
		if(preg_match('/^PRV\*/',$seg)){$provider[] = $seg;}
		else{throw new Exception('error loading PRV');}
		# Load NM1 
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*85\*/',$seg)){$provider[] = $seg;}
		else{throw new Exception('error loading NM1');}
		# Load N3
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){$provider[] = $seg;}
		else{throw new Exception('error loading N3');}
		# Load N4
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){$provider[] = $seg;}
		else{throw new Exception('error loading N4');}
		# Load REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*/',$seg)){$provider[] = $seg;}
		else{throw new Exception('error loading REF');}
		return $provider;
	}
	private function loadProcedure($seg,&$segments){
		$procedure = array();
		$procedure[] = $seg;
		# Load SV2 
		$seg = array_shift($segments);
		if(preg_match('/^SV2\*/',$seg)){$procedure[] = $seg;}
		else{throw new Exception('error loading SV2');}
		# Load DTP 
		$seg = array_shift($segments);
		if(preg_match('/^DTP\*472\*D8\*/',$seg)){$procedure[] = $seg;}
		else{throw new Exception('error loading DTP');}
		# Load REF 
		$seg = array_shift($segments);
		if(preg_match('/^REF\*6R\*/',$seg)){$procedure[] = $seg;}
		else{throw new Exception('error loading REF');}
		return $procedure;
	}
	private function loadClaim($seg,&$segments){
		$info = array();
		$procedures = array();
		$info[] = $seg;
		# Load SBR 
		$seg = array_shift($segments);
		if(preg_match('/^SBR\*P\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading SBR');}
		# Load NM1 
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*IL\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading NM1');}
		# Load N3 
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading N3');}
		# Load N4 
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading N4');}
		# Load DMG
		$seg = array_shift($segments);
		if(preg_match('/^DMG\*D8\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading DMG');}
		# Load NM1 
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*PR\*2\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading NM1');}
		# Load N3 
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading N3');}
		# Load N4 
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading N4');}
		# Load REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*FY\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading REF');}
		# Load REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*G2\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading REF');}
		# Load CLM
		$seg = array_shift($segments);
		if(preg_match('/^CLM\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading CLM');}
		# Load DTP
		$seg = array_shift($segments);
		if(preg_match('/^DTP\*434\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading DTP');}
		# Load CL1
		$seg = array_shift($segments);
		if(preg_match('/^CL1\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading CL1');}
		# Load AMT
		if(preg_match('/^AMT\*F3\*/',$segments[0])){
			$seg = array_shift($segments);
			$info[] = $seg;
		}
		# Load REF
		if(preg_match('/^REF\*4N\*/',$segments[0])){
			$seg = array_shift($segments);
			$info[] = $seg;
		}
		# Load REF
		if(preg_match('/^REF\*D9\*/',$segments[0])){
			$seg = array_shift($segments);
			$info[] = $seg;
		}
		# Load HI
		$seg = array_shift($segments);
		if(preg_match('/^HI\*BK/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading BK'.$seg);}
		# Load HI
		$seg = array_shift($segments);
		if(preg_match('/^HI\*BE/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading BK');}
		# Load NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*71\*1\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading NM1');}
		# Load REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*0B\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading REF');}
		# Load NM1 
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*77\*2\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading NM1');}
		# Load N3 
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading N3');}
		# Load N4 
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading N4');}
		# Load REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*0B\*/',$seg)){$info[] = $seg;}
		else{throw new Exception('error loading REF');}
		# Load Procedures
		while(preg_match('/^LX\*\d+/',$segments[0])){
			$seg = array_shift($segments);
			$procedures[] = $this->loadProcedure($seg,$segments);
		}
		return array($info,$procedures);
	}
	private function loadEDI($x12){
		$EDI = array();
		$head = array();
		$claims = array();
		$segments = preg_split('/~/',$x12);
		# Load ISA
		$seg = array_shift($segments);
		if(preg_match('/^ISA\*/',$seg)){$head[] = $seg;}
		else{throw new Exception('error loading ISA');}
		# Load GS
		$seg = array_shift($segments);
		if(preg_match('/^GS\*/',$seg)){$head[] = $seg;}
		else{throw new Exception('error loading GS');}
		# Load ST
		$seg = array_shift($segments);
		if(preg_match('/^ST\*/',$seg)){$head[] = $seg;}
		else{throw new Exception('error loading ST');}
		# Load BHT
		$seg = array_shift($segments);
		if(preg_match('/^BHT\*/',$seg)){$head[] = $seg;}
		else{throw new Exception('error loading BHT');}
		# Load NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*/',$seg)){ $head[] = $seg;}
		else{throw new Exception('error loading NM1');}
		# Load PER
		$seg = array_shift($segments);
		if(preg_match('/^PER\*/',$seg)){ $head[] = $seg;}
		else{throw new Exception('error loading PER');}
		# Load NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*/',$seg)){ $head[] = $seg;}
		else{throw new Exception('error loading NM1');}
		# Load BillingProvider
		while(preg_match('/^HL\*\d+\*\*20\*/',$segments[0])){
			$seg = array_shift($segments);
			$billingProvider = $this->loadBillingProvider($seg,$segments);
			while(preg_match('/^HL\*\d+\*\d+\*22\*/',$segments[0])){
				$seg = array_shift($segments);
				$claims[] = array(
					$billingProvider,
					$this->loadClaim($seg,$segments)
				);
			}
		}
		return array($head,$claims);
	} # END LOAD EDI FILE
	private function toTextX12($x12){
		$segments = preg_split('/~/',$x12);
		$ms = '';
		foreach($segments as $seg){
				$ms .= "$seg<br/>";
		}
		return $ms;
	}
	###  THIS IS the function I am using to correct bad axuim data
	private function processX12($x12){
		$segments = preg_split('/~/',$x12);
		$fixed = array();
		foreach($segments as $seg){
			if(preg_match('/^ISA\*00/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp = preg_split('/\*/',$seg);
				$temp[6] = 'F00            ';
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^GS\*HC\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[2] = 'F00';
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*41\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NEW YORK UNIV DENTAL CTR';
				$temp[9] = 'F00';
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*40\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NYSDOH';
				$temp[9] = 141797357;
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*85\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NEW YORK UNIV DENTAL CTR';
				$temp[9] = 1164555124;
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*PR\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NYSDOH';
				$temp[9] = 141797357;
				$fixed[] = implode('*',$temp);
			}else{
				$fixed[] = $seg;
			}
		}
		return implode('~',$fixed);
	} # END processX12 function
}
?>
