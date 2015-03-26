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
	public function getNewList()
	{
		$list = ftp_nlist($this->conn,'3rdParty\New');
		echo json_encode($list);
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
