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
	public function sandbox()
	{
		$a = file_get_contents('files/edi/a.x12');
		$a = preg_split('/(HL\*\d+\*2\*22\*0~)/',$a,0,PREG_SPLIT_DELIM_CAPTURE);
		$b = [];
		$b[] = ['Chart','Last','First','Birth','Sex','Medicaid','ServiceDate','Type','Coverage'];
		array_shift($a);
		while(sizeof($a) > 0)
		{
			$s = array_shift($a);
			//$b[] = $s;
			$s = array_shift($a);
			$u = $s;

			$s = preg_split('/(EB.+?~)/',$s,0,PREG_SPLIT_DELIM_CAPTURE);
			$t = array_shift($s);

			//$b[] = $t;
			$m = [];

			preg_match('/TRN\*2\*(.+?)\*/',$t,$m);
			$chart = $m[1];

			preg_match('/(NM1\*IL\*1\*.+?)~/',$t,$m);
			$patName = preg_split('/\*/',$m[1]);
			$last     = '';
			$first    = '';
			$medicaid = '';
			if(isset($patName[3])){ $last = $patName[3]; }
			if(isset($patName[4])){ $first = $patName[4]; }
			if(isset($patName[9])){ $medicaid = $patName[9]; }

			preg_match('/DMG\*D8\*(\d+?)\*(\w?)~/',$t,$m);
			$birth = $m[1];
			$sex   = $m[2];

			preg_match('/DTP\*472\*D8\*(\d+?)~/',$t,$m);
			$serviceDate = $m[1];

			//$b[] = json_encode($m);

			$coverage = [];
			while(sizeof($s) > 0)
			{
				$t = array_shift($s);
				#$b[] = $t;
				if(preg_match('/^EB\*U\*IND\*30\*\*ELIGIBLE PCP~/',$t))
				{
					$info = array_shift($s);
					$catch = [];
					preg_match('/NM1\*Y2\*2\*(.+?)\*+?PI\*(.+?)~/',$info,$catch);
					$coverage[] = "MMC::".$catch[1]."::".$catch[2];
					//$b[] = json_encode($catch);
				}
				else if(preg_match('/^EB\*1\*IND\*30\*\*MA Eligible/',$t))                    { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Presumptive Eli/',$t))                { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Community Coverage No LTC/',$t))      { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Community Coverage w\/CBLT/',$t))     { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Outpatient Coverage w\/ CBLTC/',$t))  { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Outpatient Coverage No LTC/',$t))     { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Eligiblie Only Outpatient Care/',$t)) { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Emergency Services Only/',$t))        { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*Medicare Coinsurance Deductibl/',$t)) { $coverage[] = "Medicaid::Medicaid"; }
				else if(preg_match('/^EB\*1\*IND\*30\*\*No Coverage/',$t))                    { $coverage[] = "No::No"; }
				else if(preg_match('/^EB\*R\*IND\*30/',$t))
				{
					$info = array_shift($s);
					$catch = [];
					preg_match('/(NM1\*P4\*2\*.+?)~/',$info,$catch);
					$temp = preg_split('/\*/',$catch[1]);
					$coverName = '';
					$coverNum  = '';
					if(isset($temp[3])){ $coverName = $temp[3]; }
					if(isset($temp[9])){ $coverNum  = $temp[9]; }
					$coverage[] = 'Other::'.$coverName.'::'.$coverNum;
					//$coverage[] = "Other::".$catch[1]."::".$catch[2];
					//$b[] = json_encode($catch);

					//$coverage[] = "Other::Other";
					//$coverage[] = $t;
					//$coverage[] = $info;
					//$coverage[] = $s[0];
				}

				# LOOK FOR VALID INSURANCE
			}

			$type = 'Unknown';
			$f1 = 0;
			$f2 = 0;
			$f3 = 0;
			$f4 = 0;
			foreach($coverage as $c)
			{
				if(preg_match('/^Medicaid::/',$c)){ $f1 = 1; }
				if(preg_match('/^Other::/',$c))
				{
					if(preg_match('/Other::MEDICARE/',$c))
					{
						$f2 = 1;
					}
					else
					{
						$f3 = 1;
					}
				}
				if(preg_match('/^MMC::/',$c)){ $f4 = 1; }
				//$f1 = "|".$c."|";
			}

			     if( $f1 == 1 && $f2 == 0 && $f3 == 0 && $f4 == 0 ){ $type = 'Medicaid'; }
			else if( $f1 == 1 && $f2 == 1 && $f3 == 0 && $f4 == 0 ){ $type = 'Medicare'; }
			else if( $f1 == 1 && $f2 == 1 && $f3 == 1 && $f4 == 0 ){ $type = 'Other'; }
			else if( $f4 == 1 ){ $type = 'MMC'; }

			$type = $type.'::'.$f1.$f2.$f3.$f4;
			
			$b[] = [$chart,$last,$first,$birth,$sex,$medicaid,$serviceDate,$type,$coverage];
			#$b[] = "LINE => Chart:$chart Last:$last First:$first Birth:$birth Sex:$sex Medicaid:$medicaid ServiceDate:$serviceDate Coverage:".sizeof($coverage);

			//foreach($coverage as $c) { $b[] = $c; }
			//$b[] = $u;
		}
/*
		$c = [];
		for($i=0;$i<1000;$i++)
		{
			$c[] = $b[$i];
		}
*/
		echo json_encode($b);
	}
	public function sandbox1()
	{

		$x12 = [];

		$date6 = date('ymd');
		$date8 = date('Ymd');
		$time = date('Hi');
		$gscontrol = '100100100';
		$stcontrol = '1001';

		$x12[] = "ISA*00*          *00*          *ZZ*F00            *ZZ*EMEDNYBAT      *$date6*$time*U*00501*$gscontrol*0*P*:~";
		$x12[] = "GS*HS*F00*EMEDNYBAT*$date8*$time*$gscontrol*X*005010X279A1~";
		$x12[] = "ST*270*$stcontrol*005010X279A1~";
		$x12[] = "BHT*0022*13*$gscontrol*$date8*$time~";
		$x12[] = "HL*1**20*1~";
		$x12[] = "NM1*PR*2*NYSDOH*****FI*141797357~";
		$x12[] = "HL*2*1*21*1~";
		$x12[] = "NM1*1P*2*NEW YORK UNIV DENTAL CTR*****XX*1164555124~";

		$hlCount = 2;

		$a = file_get_contents('files/edi/sample2.csv');
		$a = preg_split('/\r\n/',$a);
		$b = [];

		array_shift($a);

		foreach($a as $i)
		{
			$j = preg_split('/,/',$i);
			$d = preg_split('/\//',$j[5]);
			$e = $d[2].$d[0].$d[1];
			$e = preg_replace('/\s/','',$e);

			$thing = array(
				'line'        => $i,
				'chart'       => $j[2],
				'medicaid'    => $j[4],
				'serviceDate' => $e 
			);

			$b[] = $thing;

			if($j[4] != '')
			{
				$b[] = $thing;
				$x12[] = "HL*".++$hlCount."*2*22*0~";
				$x12[] = "TRN*1*$j[2]*1135562308~";
				$x12[] = "NM1*IL*1******MI*$j[4]~";
				$x12[] = "DTP*291*D8*$e~";
			}
		}

		$segCount = sizeof($x12)-1;
		$x12[] = "SE*$segCount*$stcontrol~";
		$x12[] = "GE*1*$gscontrol~";
		$x12[] = "IEA*1*$gscontrol~";

		file_put_contents('files/edi/testX12.x12',implode('',$x12));
		echo json_encode($b);
	}
	public function getBatchList()
	{
		$list = ftp_nlist($this->conn,'x12');
		echo json_encode($list);
	}
	public function createStatusRequest()
	{
		$date6 = date('ymd');
		$date8 = date('Ymd');
		$time = date('Hi');
		$gscontrol = '900100100';
		$stcontrol = '1001';
		$x12 = [];

#########################################################################################


		$x12[] = "ISA*00*          *00*          *ZZ*F00            *ZZ*EMEDNYBAT      *$date6*$time*U*00501*$gscontrol*0*T*:~";

		#$x12[] = "GS*HS*F00*EMEDNYBAT*$date8*$time*$gscontrol*X*005010X279A1~";
		$x12[] = "GS*HS*F00*EMEDNYBAT*$date8*$time*$gscontrol*X*005010X212~";
		#$x12[] = "GS*HS*F00*EMEDNYBAT*$date8*$time*1*X*005010X212~";

		$x12[] = "ST*276*$stcontrol*005010X212~";
		#$x12[] = "ST*276*$stcontrol*005010X212~";

		#$x12[] = "BHT*0022*13*$gscontrol*$date8*$time~";
		#$x12[] = "BHT*0010*13*$gscontrol*$date8*$time~";

		#$x12[] = "HL*1**20*1~";
		#$x12[] = "NM1*PR*2*NYSDOH*****FI*141797357~";
		#$x12[] = "HL*2*1*21*1~";
		#$x12[] = "NM1*1P*2*NEW YORK UNIV DENTAL CTR*****XX*1164555124~";

		#$x12[] = "HL*".++$hlCount."*2*22*0~";
		#$x12[] = "TRN*1*$claimId*1135562308~";
		#$x12[] = "NM1*IL*1******MI*$medicaid~";
		#$x12[] = "DTP*291*D8*$serviceDate~";

		#$segCount = sizeof($x12)-1;
		#$x12[] = "SE*$segCount*$stcontrol~";
		#$x12[] = "GE*1*1~";
		#$x12[] = "IEA*1*$gscontrol~";

#########################################################################################

/*
		$x12[] = "ISA*00*          *00*          *ZZ*F00            *ZZ*EMEDNYBAT      *$date6*$time*U*00501*$gscontrol*0*P*:~";
		$x12[] = "GS*HS*F00*EMEDNYBAT*$date8*$time*$gscontrol*X*005010X212~";
		$x12[] = "ST*276*$stcontrol*005010X212~";
		$x12[] = "BHT*0010*13*$gscontrol*$date8*$time~";

		$x12[] = "HL*1**20*1~";
		$x12[] = "NM1*PR*2*NYSDOH*****FI*141797357~";

		$x12[] = "HL*2*1*21*1~";
		$x12[] = "NM1*1P*2*NEW YORK UNIV DENTAL CTR*****XX*1164555124~";

		
		$x12[] = "HL*3*2*19*1~";
		$x12[] = "NM1*1P*2*NEW YORK UNIV DENTAL CTR*****XX*1164555124~";

		$birthDate = '19821222';
		$sex = 'F';
		$lastName = 'causer';
		$firstName = 'alison';
		$subscriberNumber = 'NX38444Q';
		$serviceDate = '20150408';

		$x12[] = "HL*4*3*22*0~";
		$x12[] = "DMG*D8*$birthDate*$sex~";
		$x12[] = "NM1*IL*1*$lastName*$firstName****MI*$subscriberNumber~";
		#$x12[] = "TRN*1*$tcn~";
		$x12[] = "DTP*472*RD8*$serviceDate-$serviceDate~";

		$segCount = sizeof($x12)-1;
		$x12[] = "SE*$segCount*$stcontrol~";
*/
		$x12[] = "GE*1*$gscontrol~";
		$x12[] = "IEA*1*$gscontrol~";

		# SAVE x12 file to disk
		$tfile = 'files/edi/temp/test.x12';
		file_put_contents($tfile,implode("",$x12));

		# Move file to server
		#$f = explode('.',$file);
		#$f = $f[0].'.x12';
		#$remoteFile = 'x12\\test.x12';
		#$localFile = 'files/edi/temp/x12';
		#$localFile = $tfile;
		#ftp_put($this->conn,$remoteFile,$localFile,FTP_BINARY);
/*
		echo '270 file created';
*/
		#$file = $_POST['file'];
		$statusRequest = implode('<br/>',$x12);
		echo json_encode(array(
			#'batch' => $file,
			'statusRequest' => $statusRequest
		));
	}
	public function addElly()
	{
		$file = $_POST['file'];
		$s = preg_split('/_/',$file);

		#get elly
		$localFile = 'files/edi/temp/a';

		$a = preg_split('/\./',$s[4]);
		$jsonName = '100000'.$a[0];
		$remoteFile = '3rdParty\271Queue\\'.$jsonName.'.json';
		ftp_get($this->conn,$localFile,$remoteFile,FTP_BINARY);
		$a = file_get_contents($localFile);


		$elly = json_decode($a,true);
		$keys = array_keys($elly);
		$bel = $elly['claims'];
		$ellyHash = [];
		foreach($bel as $bob)
		{
			$ellyHash[$bob['id']] = $bob['insurance'];
		}

		# GET claim file
		$remoteFile = '3rdParty\New\\'.$file;
		$localFile = 'files/edi/temp/a';
		ftp_get($this->conn,$localFile,$remoteFile,FTP_BINARY);
		$a = file_get_contents($localFile);

	$ss = explode('~',$a);
	
	$outbound = [];
	
	$art28 = array(
		'Providers' => [],
		'Segments' => [],
		'foot' => [],
		'BatchNum' => '100100100'
	); 
	
	$medicare = array(
		'Providers' => [],
		'Segments' => [],
		'foot' => [],
		'BatchNum' => '100100100'
	); 
	
	$other = array(
		'Providers' => [],
		'Segments' => [],
		'foot' => [],
		'BatchNum' => '100100100'
	); 
	
	$error = array(
		'Providers' => [],
		'Segments' => [],
		'foot' => [],
		'BatchNum' => '100100100'
	); 
	
	$mode = 'HEAD';
	$type = 'NO';
	$claimS = [];

	foreach($ss as $s)
	{
		if(preg_match('/^HL\*\d+\*\*20\*/',$s))
		{
			$mode = 'PROVIDER';
			$art28['Providers'][] = array('Segments' => [], 'Claims' => []);
			$medicare['Providers'][] = array('Segments' => [], 'Claims' => []);
			$other['Providers'][] = array('Segments' => [], 'Claims' => []);
			$error['Providers'][] = array('Segments' => [], 'Claims' => []);
		}
		if(preg_match('/^HL\*\d+\*\d+\*22\*/',$s))
		{
			$mode = 'CLAIM';
			$type = 'NO';
			$claimS = [];
		}
		if(preg_match('/^SE\*/',$s))
		{
			$mode = 'FOOT';
		}
		if(preg_match('/^CLM\*/',$s))
		{
			$a = preg_split('/\*/',$s);
			$ins = $ellyHash[$a[1]];
			$f1 = 0; # medicaid flag
			$f2 = 0; # medicare flag
			$f3 = 0; # mmc flag
			$f4 = 0; # other flag
			$insType = '!';
			foreach( $ins as $i)
			{
				if(preg_match('/^Med: Medicaid/',$i)){$f1 = 1;}
				else if(preg_match('/^OTHER: MEDICARE/',$i)){$f2 = 1;}
				else if(preg_match('/^MMC: /',$i)){$f3 = 1;}
				else {$f4 = 1;}
			}
			     if( $f1 == 1 && $f2 == 0 && $f3 == 0 && $f4 == 0 ){ $insType = 'Medicaid'; }
			else if( $f1 == 1 && $f2 == 1 && $f3 == 0 && $f4 == 0 ){ $insType = 'Medicare'; }
			else if( $f1 == 1 && $f2 == 1 && $f3 == 0 && $f4 > 0 ){ $insType = 'Other'; }
			else if( $f3 > 0  || $f4 > 0 ){ $insType = 'Error'; }
			else { $insType = 'Error'; }

			foreach($claimS as $c)
			{
				if($insType == 'Medicaid' )
				{
					$art28['Providers'][sizeof($art28['Providers'])-1]['Claims'][] = $c;
				}
				else if($insType == 'Medicare' )
				{
					$medicare['Providers'][sizeof($medicare['Providers'])-1]['Claims'][] = $c;
				}
				else if($insType == 'Other' )
				{
					$other['Providers'][sizeof($other['Providers'])-1]['Claims'][] = $c;
				}
				else if($insType == 'Error' )
				{
					$error['Providers'][sizeof($error['Providers'])-1]['Claims'][] = $c;
				}
			}

			$type = $insType;
			#$type = $insType.' '.$f1.$f2.$f3.$f4.' :: '.json_encode($ins);
		}
		$outbound[] = "$s :: $mode :: $type";
		if( $mode == 'HEAD' )
		{
			$art28['Segments'][] = $s;
			$medicare['Segments'][] = $s;
			$other['Segments'][] = $s;
			$error['Segments'][] = $s;
		}
		if( $mode == 'FOOT' )
		{
			$art28['foot'][] = $s;
			$medicare['foot'][] = $s;
			$other['foot'][] = $s;
			$error['foot'][] = $s;
		}
		if( $mode == 'PROVIDER' )
		{
			$art28['Providers'][sizeof($art28['Providers'])-1]['Segments'][] = $s;
			$medicare['Providers'][sizeof($art28['Providers'])-1]['Segments'][] = $s;
			$other['Providers'][sizeof($art28['Providers'])-1]['Segments'][] = $s;
			$error['Providers'][sizeof($art28['Providers'])-1]['Segments'][] = $s;
		}
		if( $mode == 'CLAIM' )
		{
			if( $type == 'NO' )
			{
				$claimS[] = $s;
			}
			else if( $type == 'Medicaid' )
			{
				$art28['Providers'][sizeof($art28['Providers'])-1]['Claims'][] = $s;
			}
			else if( $type == 'Medicare' )
			{
				$medicare['Providers'][sizeof($medicare['Providers'])-1]['Claims'][] = $s;
			}
			else if( $type == 'Other' )
			{
				$other['Providers'][sizeof($other['Providers'])-1]['Claims'][] = $s;
			}
			else if( $type == 'Error' )
			{
				$error['Providers'][sizeof($error['Providers'])-1]['Claims'][] = $s;
			}
			#else
			#{
			#}
			#$art28['Providers'][sizeof($art28['Providers'])-1]['Segments'][] = $s;
		}
	}

	//$debug = implode('<br/><br/>',$outbound);
	
################################ CREATE MEDICAID SEGMETNTS #########################################
$a = [];
$hlct = 0;
foreach( $art28['Segments'] as $segment)
{
	if(preg_match('/^ISA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[13] = preg_replace('/^0000/','1001',$z[13]);
		$art28['BatchNum'] = $z[13];
		$a[] = implode('*',$z);
	}
	else
	{
		$a[] = $segment;
	}
}
foreach( $art28['Providers'] as $provider )
{
	if( sizeof($provider['Claims']) > 0 )
	{
		foreach( $provider['Segments'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$a[] = implode('*',$z);
			}
			else
			{
				$a[] = $segment;
			}
		}
		foreach( $provider['Claims'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$a[] = implode('*',$z);
			}
			else
			{
				$a[] = $segment;
			}
		}
	}
}
foreach( $art28['foot'] as $segment)
{
	if(preg_match('/^IEA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[2] = preg_replace('/^0000/','1001',$z[2]);
		$a[] = implode('*',$z);
	}
	else
	{
		$a[] = $segment;
	}
}

################################ CREATE MEDICARE SEGMETNTS #########################################
$b = [];
$hlct = 0;
foreach( $medicare['Segments'] as $segment)
{
	if(preg_match('/^ISA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[13] = preg_replace('/^0000/','2001',$z[13]);
		$medicare['BatchNum'] = $z[13];
		$b[] = implode('*',$z);
	}
	else
	{
		$b[] = $segment;
	}
	#$b[] = $segment;
}
foreach( $medicare['Providers'] as $provider )
{
	if( sizeof($provider['Claims']) > 0 )
	{
		foreach( $provider['Segments'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$b[] = implode('*',$z);
			}
			else
			{
				$b[] = $segment;
			}
		}
		foreach( $provider['Claims'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$b[] = implode('*',$z);
			}
			else
			{
				$b[] = $segment;
			}
		}
/*
		foreach( $provider['Segments'] as $segment)
		{
			$b[] = $segment;
		}
		foreach( $provider['Claims'] as $segment)
		{
			$b[] = $segment;
		}
*/
	}
}
foreach( $medicare['foot'] as $segment)
{
	if(preg_match('/^IEA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[2] = preg_replace('/^0000/','2001',$z[2]);
		$b[] = implode('*',$z);
	}
	else
	{
		$b[] = $segment;
	}
}

################################ CREATE OTHER SEGMETNTS #########################################
$c = [];
$hlct = 0;
foreach( $other['Segments'] as $segment)
{
	if(preg_match('/^ISA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[13] = preg_replace('/^0000/','3001',$z[13]);
		$other['BatchNum'] = $z[13];
		$c[] = implode('*',$z);
	}
	else
	{
		$c[] = $segment;
	}
	#$c[] = $segment;
}
foreach( $other['Providers'] as $provider )
{
	if( sizeof($provider['Claims']) > 0 )
	{
		foreach( $provider['Segments'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$c[] = implode('*',$z);
			}
			else
			{
				$c[] = $segment;
			}
		}
		foreach( $provider['Claims'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$c[] = implode('*',$z);
			}
			else
			{
				$c[] = $segment;
			}
		}
/*
		foreach( $provider['Segments'] as $segment)
		{
			$c[] = $segment;
		}
		foreach( $provider['Claims'] as $segment)
		{
			$c[] = $segment;
		}
*/
	}
}
foreach( $other['foot'] as $segment)
{
	if(preg_match('/^IEA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[2] = preg_replace('/^0000/','3001',$z[2]);
		$c[] = implode('*',$z);
	}
	else
	{
		$c[] = $segment;
	}
}

################################ CREATE ERROR SEGMETNTS #########################################
$d = [];
$hlct = 0;
foreach( $error['Segments'] as $segment)
{
	if(preg_match('/^ISA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[13] = preg_replace('/^0000/','4001',$z[13]);
		$error['BatchNum'] = $z[13];
		$d[] = implode('*',$z);
	}
	else
	{
		$d[] = $segment;
	}
	#$d[] = $segment;
}
foreach( $error['Providers'] as $provider )
{
	if( sizeof($provider['Claims']) > 0 )
	{
		foreach( $provider['Segments'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$d[] = implode('*',$z);
			}
			else
			{
				$d[] = $segment;
			}
		}
		foreach( $provider['Claims'] as $segment)
		{
			if(preg_match('/^HL\*/',$segment))
			{
				$z = preg_split('/\*/',$segment);
				$z[1] = ++$hlct;
				$d[] = implode('*',$z);
			}
			else
			{
				$d[] = $segment;
			}
		}
/*
		foreach( $provider['Segments'] as $segment)
		{
			$d[] = $segment;
		}
		foreach( $provider['Claims'] as $segment)
		{
			$d[] = $segment;
		}
*/
	}
}
foreach( $error['foot'] as $segment)
{
	if(preg_match('/^IEA\*/',$segment))
	{
		$z = preg_split('/\*/',$segment);
		$z[2] = preg_replace('/^0000/','4001',$z[2]);
		$d[] = implode('*',$z);
	}
	else
	{
		$d[] = $segment;
	}
}

file_put_contents('files/edi/medicaid/'.$art28['BatchNum'].'.x12',implode("~",$a));
file_put_contents('files/edi/medicare/'.$medicare['BatchNum'].'.x12',implode("~",$b));
file_put_contents('files/edi/other/'.$other['BatchNum'].'.x12',implode("\n",$c));
file_put_contents('files/edi/error/'.$error['BatchNum'].'.x12',implode("\n",$d));

		# GET claim file
		$remoteFile = '3rdParty\New\\'.$file;
		$localFile = 'files/edi/temp/a';
		ftp_get($this->conn,$localFile,$remoteFile,FTP_BINARY);
		//$a = file_get_contents($localFile);

		require('lib/classes/EDI837.php');
		$edi = new EDI837();
		$obj = $edi->loadEDI837D('temp/a');

		$m = [];

		$thing = $obj['ediObj']->getStuff();

		$providers = $thing['providers'];
		foreach($providers as $p)
		{
			$claims = $p->getClaims();
			foreach($claims as $c)
			{
				$services = $c->getServices();
				$lines = [];
				foreach($services as $service)
				{
					$line = $service->getStuff();
					$amt = $line['amount'];
					$ada = $line['adacode'];
					$ada = preg_split('/:/',$ada);
					$ada = $ada[1];
					$lines[] = array($ada,$amt);
				}
				$clm = $c->getStuff();
				$m[] = array(
					$clm['claimid'],
					$ellyHash[$clm['claimid']],
					$clm['last'],
					$clm['first'],
					$clm['id'],
					1428,
					$clm['amount'],
					$clm['date'],
					$lines,
					'amt'
				);
			}
		}

		$debug = 'all good :)  No that we were looking for anything';

		echo json_encode(array(
			'batch'     => $thing['batch'],
			'claimList' => $m,
			'debug'     => $debug
		));
	}
	public function getNewList()
	{
		$list = ftp_nlist($this->conn,'3rdParty\New');
		echo json_encode($list);
	}
	public function get271List()
	{
		$list = ftp_nlist($this->conn,'3rdParty\271Queue');
		$listx = [];
		foreach($list as $i)
		{
			$a = explode('.',$i);
			if($a[2] == 'x12'){$listx[] = $i;}
		}
		echo json_encode($listx);
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
			$debug = 'Groot';
			while(preg_match('/^HL\*[0-9]+\*2\*22/',$segs[0]))
			{
				$seg = array_shift($segs);

				$claim = [];
	
				$seg = array_shift($segs);
				if(preg_match('/^TRN\*/',$seg))
				{
					$t = preg_split('/\*/',$seg);
					$claim['id'] = $t[2];
$debug = $t[2];
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

				if(preg_match('/^EB\*1\*IND\*30\*\*Presumptive Eli/',$segs[0]))
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

				if(preg_match('/^EB\*1\*IND\*30\*\*Outpatient Coverage w\/ CBLTC/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid Outpatient CBLTC';
				}

				if(preg_match('/^EB\*1\*IND\*30\*\*Outpatient Coverage No LTC/',$segs[0]))
				{
					$seg = array_shift($segs);
					$claim['insurance'][] = 'Med: Medicaid Outpatient No LTC';
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
					while(preg_match('/^MSG\*/',$segs[0])){$seg = array_shift($segs);}
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
				if(preg_match('/^EB\*F\*IND\*88/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*F\*IND\*98/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*F\*IND\*35/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*F\*IND\*5/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*Y\*IND\*AG/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^EB\*Y\*IND\*AG/',$segs[0])){$seg = array_shift($segs);}
				if(preg_match('/^DTP\*291\*D8\*/',$segs[0])){$seg = array_shift($segs);}

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
			if(preg_match('/^SE\*/',$seg)){}else{throw new exception('100: '.$debug);}
			$seg = array_shift($segs);
			if(preg_match('/^GE\*/',$seg)){}else{throw new exception('101');}
			$seg = array_shift($segs);
			if(preg_match('/^IEA\*/',$seg)){}else{throw new exception('102');}
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
		#$_SESSION['activeClaimFile'] = $a;


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
		$gscontrol = $thing['batch'];
		$gscontrol = preg_replace('/^0/','1',$gscontrol);
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

				if( $serviceDate != '')
				{
					$x12[] = "HL*".++$hlCount."*2*22*0~";
					$x12[] = "TRN*1*$claimId*1135562308~";
					$x12[] = "NM1*IL*1******MI*$medicaid~";
					$x12[] = "DTP*291*D8*$serviceDate~";
				}
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

		echo "270 file created $m";

	}
}

?>
