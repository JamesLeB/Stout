<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function logout(){ session_unset(); }
private function openInstitutionalBatch($batch) # returns a array of claims
{
	$m = array();
	$m[] = "I am Groot";
	$segments = preg_split('/~/',$batch);
	try
	{
		$seg = array_shift($segments);
		if(preg_match('/^ISA\*/',$seg)) { } else { throw new exception(":( $seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^GS\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^ST\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^BHT\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^NM1\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^PER\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^NM1\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^HL\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^NM1\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)) { } else { throw new exception("$seg"); }
	
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^REF\*/',$seg)) { } else { throw new exception("$seg"); }

		$claims = array();
		while(preg_match('/^HL\*[0-9]+\*1\*22/',$segments[0]))
		{
			$claim = array();

			$seg = array_shift($segments);
			if(preg_match('/^HL\*[0-9]+\*1\*22/',$seg)) { } else { throw new exception("$seg"); }

			$seg = array_shift($segments);
			if(preg_match('/^SBR\*/',$seg)) { } else { throw new exception("$seg"); }

			$seg = array_shift($segments);
			if(preg_match('/^NM1\*/',$seg))
			{
				$temp = preg_split('/\*/',$seg);
				$claim['first']    = $temp[4];
				$claim['last']     = $temp[3];
				$claim['medicaid'] = $temp[9];
			}
			else
			{
				throw new exception("$seg");
			}

			$seg = array_shift($segments);
			if(preg_match('/^DMG\*/',$seg))
			{
				$temp = preg_split('/\*/',$seg);
				$claim['birth'] = $temp[2];
				$claim['sex']   = $temp[3];
			}
			else
			{
				throw new exception("$seg");
			}

			$seg = array_shift($segments);
			if(preg_match('/^NM1\*/',$seg)) { } else { throw new exception("$seg"); }

			$seg = array_shift($segments);
			if(preg_match('/^CLM\*/',$seg))
			{
				$temp = preg_split('/\*/',$seg);
				$trak = preg_split('/-/',$temp[1]);
				$claim['chart']   = $trak[0];
				$claim['claimId'] = $trak[1];
				$claim['amount']  = $temp[2];
			}
			else
			{
				throw new exception("$seg");
			}

			$seg = array_shift($segments);
			if(preg_match('/^DTP\*/',$seg))
			{
				$temp = preg_split('/\*/',$seg);
				$trak = preg_split('/-/',$temp[3]);
				$claim['serviceDate'] = $trak[0];
			}
			else
			{
				throw new exception("$seg");
			}

			$seg = array_shift($segments);
			if(preg_match('/^CL1\*/',$seg)) { } else { throw new exception("$seg"); }

			$seg = array_shift($segments);
			if(preg_match('/^HI\*BK/',$seg)) { } else { throw new exception("$seg"); }

			$seg = array_shift($segments);
			if(preg_match('/^HI\*BE/',$seg)) { } else { throw new exception("$seg"); }

			$seg = array_shift($segments);
			if(preg_match('/^NM1\*/',$seg)) { } else { throw new exception("$seg"); }

			$lines = array();
			while(preg_match('/^LX\*[0-9]+/',$segments[0]))
			{
				$line = array();

				$seg = array_shift($segments);
				if(preg_match('/^LX\*[0-9]+/',$seg)) { } else { throw new exception("$seg"); }

				$seg = array_shift($segments);
				if(preg_match('/^SV2\*/',$seg))
				{
					$temp = preg_split('/\*/',$seg);
					$trak = preg_split('/:/',$temp[2]);
					$line['adacode'] = $trak[1];
					$line['amount']  = $temp[3];
				}
				else
				{
					throw new exception("$seg");
				}

				$seg = array_shift($segments);
				if(preg_match('/^DTP\*472/',$seg))
				{
					$temp = preg_split('/\*/',$seg);
					$trak = preg_split('/-/',$temp[3]);
					$line['date'] = $trak[0];
				}
				else
				{
					throw new exception("$seg");
				}

				$lines[] = $line;

			}

			$claim['lines'] = $lines;
			$claims[] = $claim;

		}

		$seg = array_shift($segments);
		if(preg_match('/^SE\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^GE\*/',$seg)) { } else { throw new exception("$seg"); }

		$seg = array_shift($segments);
		if(preg_match('/^IEA\*/',$seg)) { } else { throw new exception("$seg"); }

		$m[] = "All good :)";
	}
	catch(exception $e)
	{
		$error = $e->getMessage();
		$m[] = "ERROR!! $error";
		return implode('<br/>',$m);
	}
	#foreach($segments as $seg) { $m[] = $seg; }
	return $claims;
}
	public function index()
	{
		$user = $_SESSION['user'];
		if($user == 'james')
		{
			$slide = array();
			$slide[] = array('Worker',     $this->load->view('slides/worker','',true));
			$slide[] = array('Trader',     $this->load->view('slides/trader','',true));
			$slide[] = array('Stage',      $this->load->view('slides/stage','',true));
			$slide[] = array('Grapher',    $this->load->view('grapher','',true));
			$slides['slides'] = $slide;
			$data['slideTray'] = $this->load->view('slideTray',$slides,true);
			$this->load->view('home',$data);
		}
		elseif($user == 'junior')
		{
			$d['load277'] = $this->load->view('junior/load277','',true);
			$d['todo'] = $this->load->view('junior/todo','',true);
			$d['billMedicaid'] = $this->load->view('junior/billMedicaid','',true);

/*
# Move this code to c/slides/worker getBatch function
$batch = 'B0068';
$dd['batch'] = $batch;
$a = file_get_contents("files/edi/SENT/$batch.x12");
$claimList = $this->openInstitutionalBatch($a);
$html = "";
foreach($claimList as $claim)
{
	$keys = array_keys($claim);
	foreach($keys as $key)
	{
		#$html .= "$key ";
	}
	$html .= $claim['first']." "; ;
	$html .= $claim['last']." "; ;
	$html .= $claim['medicaid']." "; ;
	$html .= $claim['birth']." "; ;
	$html .= $claim['sex']." "; ;
	$html .= $claim['chart']." "; ;
	$html .= $claim['claimId']." "; ;
	$html .= $claim['amount']." "; ;
	$html .= $claim['serviceDate']." "; ;
	$html .= "<br/>";
}
$dd['batchData'] = $html;
$d['billMedicaid'] = $this->load->view('junior/batchView',$dd,true);
*/

			$d['dbtables'] = $this->load->view('junior/dbtables','',true);
			$this->load->view('junior/home',$d);
		}
		elseif($user == 'john')
		{
			$d['user'] = $user;
			$claimList['headings'] = array('Id','Last','First','Date','Amount','Status');
			$this->load->model('denialmangement');
			$claimList['rows'] = $this->denialmangement->getClaimList();
			$d['claims'] = $claimList;
			$this->load->view('claims',$d);
		}
		elseif($user == 'james1')
		{
			# Load Character
			#$d['charSheet'] = $this->load->view('classes/jform','',true);
			#$data['jCharacter'] = $this->load->view('classes/jCharacter',$d,true);

			# Load coins
			#$coins['list'] = array();
			#$coins['list'] = $this->getBterCoinList();
			$data['coins'] = $this->load->view('classes/coins','',true);

			# Load character Sheet
			#$data['characterSheet'] = $this->load->view('classes/characterSheet','',true);
			$data['characterSheet'] = $this->load->view('classes/charSheet','',true);
			# Load database controls
			#$data['database'] = $this->load->view('classes/localdb','',true);

			# Load Map
			#$data['map'] = $this->load->view('classes/map','',true);

			# Load Spash
			#$data['splash'] = $this->load->view('slides/splash','',true);
			$data['splash'] = $this->load->view('slides/lampSetup','',true);

			# LOAD TRADER
			#$data['trader'] = $this->load->view('slides/trader.php','',true);

			# LOAD WEBGL
			#$data['webgl'] = $this->load->view('slides/webgl.php','',true);

			# Load Laning page
			$this->load->view('landing',$data);
		}
/*
		$development['market']    = $this->load->view('bit/bitMarket','',true);
		$development['buy']       = $this->load->view('bit/bitBuy','',true);
		$development['inventory'] = $this->load->view('bit/bitInventory','',true);
		$development['sales']     = $this->load->view('bit/bitSales','',true);
		$reports['report1'] = 'First Report';
		$reports['report2'] = 'Second Report';
		$reports['report3'] = 'Third Report';
		$reports['report4'] = 'Forth Report';
		$form['block1'] = $this->load->view('dnd/newCharFormBlock1','',true);
		$form['block2'] = $this->load->view('dnd/newCharFormBlock2','',true);
		$slide[] = array('WebGL',      $this->load->view('webgl','',true));
		$slide[] = array('Reports',    $this->load->view('reports',$reports,true));
		$slide[] = array('exchange',   $this->load->view('exchange','',true));
		$slide[] = array('development',$this->load->view('development',$development,true));
		$slide[] = array('production', $this->load->view('production','',true));
		$slide[] = array('Expense',    $this->load->view('slides/expense','',true));
		$slide[] = array('Accounts',   $this->load->view('slides/accounts','',true));
		$slide[] = array('Ledger',     $this->load->view('slides/ledger','',true));
		$slide[] = array('Characters', $this->load->view('dnd/character',$form,true));
*/
	}
}
