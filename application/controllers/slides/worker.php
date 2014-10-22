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
	public function convertEdi(){
		header('status: Converting Axium EDI');
		include('lib/classes/EDI837.php');
		$EDI = new EDI837();
		$loadEdi = $EDI->loadEDI837D();
		$message = $loadEdi{'message'};
		$ediObj = $loadEdi{'ediObj'};

		$m = array();
		$m[] = '-----------------';
		$m[] = 'EDI Object Output';
		$a = $ediObj->getProviders();
		$b = sizeof($a);
		$m[] = "size of array $b";
		$myList = array();
		foreach($a as $c){
			$myList[] = array(
				'Heading' => 'Heading',
				'Body' => 'Body'
			);
		}
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

		#$e = ''; foreach($m as $mm){$e .= "$mm<br/>";}
		#echo $e;
	}
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
