<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class John extends CI_Controller {

	private $conn;

	public function __construct()
	{
		$c = preg_split('/\s/',file_get_contents('files/config/juniorFTPpass'));
		$server = $c[0];
		$user   = $c[1];
		$pass   = $c[2];
		set_error_handler(function(){});
		$conn = ftp_connect($server);
		ftp_login($conn,$user,$pass);
		$this->conn = $conn;
	}
	public function addElly()
	{
		$file = $_POST['file'];
		$remoteFile = '3rdParty\New\\'.$file;
		$localFile = 'files/edi/temp/a';
		ftp_get($this->conn,$localFile,$remoteFile,FTP_BINARY);
		$a = file_get_contents($localFile);

		require('lib/classes/EDI837.php');
		$edi = new EDI837();
		$obj = $edi->loadEDI837D('temp/a');

		$m = [];

		$thing = $obj['ediObj']->getStuff();
		$m[] = 'Batch: '.$thing['batch'];

		$providers = $thing['providers'];
		foreach($providers as $p)
		{
			$claims = $p->getClaims();
			foreach($claims as $c)
			{
				$clm = $c->getStuff();
				$m[] = $clm['claimid'];
			}
		}

		echo implode('<br/>',$m);
	}
	public function getNewList()
	{
		$list = ftp_nlist($this->conn,'3rdParty\New');
		echo json_encode($list);
	}
	public function get271List()
	{
		$list = ftp_nlist($this->conn,'3rdParty\271Queue');
		echo json_encode($list);
	}
	public function process271()
	{
		$file = $_POST['file'];
		$remoteFile = '3rdParty\271Queue\\'.$file;
		$localFile = 'files/edi/temp/a';
		ftp_get($this->conn,$localFile,$remoteFile,FTP_BINARY);
		$a = file_get_contents($localFile);
		$segs = preg_split('/~/',$a);
		$seg  = '';

		$m = [];
		$elly = [];

		$m[] = 'Start reading file';
		
		try
		{
			$seg = array_shift($segs);
			if(preg_match('/^ISA\*/',$seg))    {}else{throw new exception('1');}
			
			$seg = array_shift($segs);
			if(preg_match('/^GS\*/',$seg))     {}else{throw new exception('2');}
			
			$seg = array_shift($segs);
			if(preg_match('/^ST\*271\*/',$seg)){}else{throw new exception('3');}
			
			$seg = array_shift($segs);
			if(preg_match('/^BHT\*0022\*/',$seg))
			{
				$t = preg_split('/\*/',$seg);
				$elly['batchId'] = $t[3];
			}
			else{throw new exception('4');}
			
			$seg = array_shift($segs);
			if(preg_match('/^HL\*/',$seg)) {}else{throw new exception('5');}

			$seg = array_shift($segs);
			if(preg_match('/^NM1\*/',$seg)){}else{throw new exception('6');}

			$seg = array_shift($segs);
			if(preg_match('/^PER\*/',$seg)){}else{throw new exception('7');}

			$seg = array_shift($segs);
			if(preg_match('/^HL\*/',$seg)) {}else{throw new exception('8');}

			$seg = array_shift($segs);
			if(preg_match('/^NM1\*/',$seg)) {}else{throw new exception('9');}

			# START CLAIM Loop
			$elly['claims'] = [];
			while(preg_match('/^HL\*[0-9]+\*2\*22/',$segs[0]))
			{
				$seg = array_shift($segs);

				$claim = [];
	
				$seg = array_shift($segs);
				if(preg_match('/^TRN\*/',$seg))
				{
					$t = preg_split('/\*/',$seg);
					$claim['id'] = $t[2];
				}
				else{throw new exception('11');}
	

				$seg = array_shift($segs);
				if(preg_match('/^NM1\*/',$seg)) {}else{throw new exception('12');}
	
				if(preg_match('/^AAA\*/',$segs[0])) { $seg = array_shift($segs); }
				if(preg_match('/^N3\*/',$segs[0])) { $seg = array_shift($segs); }
				if(preg_match('/^N4\*/',$segs[0])) { $seg = array_shift($segs); }
				if(preg_match('/^DMG\*/',$segs[0])) { $seg = array_shift($segs); }
				if(preg_match('/^DTP\*/',$segs[0])) { $seg = array_shift($segs); }
				if(preg_match('/^DTP\*/',$segs[0])) { $seg = array_shift($segs); }
				if(preg_match('/^DTP\*/',$segs[0])) { $seg = array_shift($segs); }
	
				$claim['insurance'] = [];
	
				if(preg_match('/^EB\*1\*IND\*30\*\*MA Eligible/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid';
				}

				if(preg_match('/^EB\*1\*IND\*30\*\*Community Coverage No LTC/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid No LTC';
				}
	
				if(preg_match('/^EB\*1\*IND\*30\*\*Community Coverage w\/CBLTC/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid CBLTC';
				}

				if(preg_match('/^EB\*1\*IND\*30\*\*Eligible Only Outpatient Care/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid Outpatient';
				}

				if(preg_match('/^EB\*1\*IND\*30\*\*Emergency Services Only/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid Emergency Only';
				}

				if(preg_match('/^EB\*1\*IND\*30\*\*Medicare Coinsurance Deductible Only/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid Medicare Deductible';
				}

				if(preg_match('/^EB\*6\*IND\*30\*\*No Coverage/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'NO: No';
				}
	
				if(preg_match('/^EB\*6\*IND\*30/',$segs[0])){$seg = array_shift($segs);}

				while(preg_match('/^MSG\*/',$segs[0])){$seg = array_shift($segs);}

				# Start MMC plan loop
				while(preg_match('/^EB\*U\*IND\*30\*\*ELIGIBLE PCP/',$segs[0]))
				{
					$seg = array_shift($segs);
					if(preg_match('/^MSG\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^MSG\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^LS\*2120/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^NM1\*Y2/',$segs[0]))
					{
						$seg = array_shift($segs);
						$t = preg_split('/\*/',$seg);
						$claim['insurance'][] = "MMC: ".$t[3];
					}
					if(preg_match('/^N3\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^N4\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^PER\*IC\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^LE\*2120/',$segs[0])){$seg = array_shift($segs);}
				}
				# End MMC plan loop
	
				if(preg_match('/^EB\*B\*IND\*30/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*4/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*5/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*48/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*50/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*86/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*88/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*91/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*B\*IND\*92/',$segs[0])){$seg = array_shift($segs);}

				$safty = 0;
				while(preg_match('/^EB\*/',$segs[0]))
				{
					if($safty++ > 1000){break;}
				if(preg_match('/^EB\*1\*IND\*1/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*4/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*5/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*33/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*35/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*47/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*48/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*50/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*86/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*88/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*98/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*AG/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*AL/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*MH/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*UC/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*1\*IND\*82/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*I\*IND\*48/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*I\*IND\*54/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*N\*IND\*35/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*N\*IND\*48/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*N\*IND\*50/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*N\*IND\*88/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*F\*IND\*98/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*F\*IND\*35/',$segs[0])){$seg = array_shift($segs);}

				if(preg_match('/^LS\*2120/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^NM1\*P3/',$segs[0]))
				{
					$seg = array_shift($segs);
					$t = preg_split('/\*/',$seg);
					$claim['insurance'][] = "OTHER1: ".$t[3];
				}
				if(preg_match('/^LE\*2120/',$segs[0])){$seg = array_shift($segs);}
	

				# Start other plan loop
				while(preg_match('/^EB\*R\*IND\*30/',$segs[0]))
				{
					$seg = array_shift($segs);
					if(preg_match('/^REF\*18\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^REF\*6P\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^LS\*2120/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^NM1\*P4/',$segs[0]))
					{
						$seg = array_shift($segs);
						$t = preg_split('/\*/',$seg);
						$claim['insurance'][] = "OTHER: ".$t[3];
					}
					if(preg_match('/^N3\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^N4\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^PER\*IC\*/',$segs[0])){$seg = array_shift($segs);}
					if(preg_match('/^LE\*2120/',$segs[0])){$seg = array_shift($segs);}
				}
				# End other plan loop
				}

				$elly['claims'][] = $claim;
				//$elly['saftey'] = $safty;


			}
			# End Claim loop
			$seg = array_shift($segs);
			if(preg_match('/^SE\*/',$seg)){}else{throw new exception('6');}
			$seg = array_shift($segs);
			if(preg_match('/^GE\*/',$seg)){}else{throw new exception('6');}
			$seg = array_shift($segs);
			if(preg_match('/^IEA\*/',$seg)){}else{throw new exception('6');}
			$m[] = 'All good :)';
		}
		catch(exception $e)
		{
			$error = $e->getMessage();
			$m[] = "ERROR!!! $error";
			$m[] = $seg;
		}

		#save elly
		$localFile = 'files/edi/temp/a';
		file_put_contents($localFile,json_encode($elly));
		$remoteFile = '3rdParty\271Queue\\'.$elly['batchId'].'.json';
		ftp_put($this->conn,$remoteFile,$localFile,FTP_BINARY);

		echo implode('<br/>',$m);
	}
	public function getNewFile()
	{
		$file = $_POST['file'];
		$remoteFile = '3rdParty\New\\'.$file;
		$localFile = 'files/edi/temp/a';
		ftp_get($this->conn,$localFile,$remoteFile,FTP_BINARY);
		$a = file_get_contents($localFile);
		$_SESSION['activeClaimFile'] = $a;


		# BUILD ELEGIBILITY FILE
		require('lib/classes/EDI837.php');
/*
		require('lib/classes/EDI837D.php');
		require('lib/classes/billingProvider.php');
		require('lib/classes/dentalClaim.php');
		require('lib/classes/patient.php');
		require('lib/classes/service.php');
*/
		$edi = new EDI837();
		$obj = $edi->loadEDI837D('temp/a');
		$m = $obj['message'];
		$thing = $obj['ediObj']->getStuff();

		$date6 = date('ymd');
		$date8 = date('Ymd');
		$time = date('Hi');
		//$gscontrol = $thing['batch'];
$gscontrol = '100100603';
$stcontrol = '1001';

		$x12 = [];

		$x12[] = "ISA*00*          *00*          *ZZ*F00            *ZZ*EMEDNYBAT      *$date6*$time*U*00501*$gscontrol*0*P*:~";
		$x12[] = "GS*HS*F00*EMEDNYBAT*$date8*$time*$gscontrol*X*005010X279A1~";
		$x12[] = "ST*270*$stcontrol*005010X279A1~";
		$x12[] = "BHT*0022*13*$gscontrol*$date8*$time~";
		$x12[] = "HL*1**20*1~";
		$x12[] = "NM1*PR*2*NYSDOH*****FI*141797357~";
		$x12[] = "HL*2*1*21*1~";
		$x12[] = "NM1*1P*2*NEW YORK UNIV DENTAL CTR*****XX*1164555124~";

$hlCount = 2;
		$providers = $thing['providers'];
		foreach($providers as $provider)
		{
			$claims = $provider->getClaims();
			foreach($claims as $claim)
			{
				$claim = $claim->getStuff();
				$claimId     = $claim['claimid'];
				$medicaid    = $claim['id'];
				$serviceDate = $claim['date'];

				$x12[] = "HL*".++$hlCount."*2*22*0~";
				$x12[] = "TRN*1*$claimId*1135562308~";
				$x12[] = "NM1*IL*1******MI*$medicaid~";
				$x12[] = "DTP*291*D8*$serviceDate~";
			}
		}
		$segCount = sizeof($x12)-1;
		$x12[] = "SE*$segCount*$stcontrol~";
		$x12[] = "GE*1*$gscontrol~";
		$x12[] = "IEA*1*$gscontrol~";

		# SAVE x12 file to disk
		$tfile = 'files/edi/temp/x12';
		file_put_contents($tfile,implode("",$x12));

		# Move file to server
		$f = explode('.',$file);
		$f = $f[0].'.x12';
		$remoteFile = '3rdParty\270Queue\\'.$f;
		$localFile = 'files/edi/temp/x12';
		ftp_put($this->conn,$remoteFile,$localFile,FTP_BINARY);

		echo '270 file created';

	}
}

?>
