<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function logout(){ session_unset(); }
	public function getBter(){
		$html = "Test something";
		echo $html;
	}
	private function getBterCoinList(){
		$json = file_get_contents('http://data.bter.com/api/1/pairs');
		$obj = json_decode($json,TRUE);
		return $obj;
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
			$this->load->view('junior/juniorHome');
		}
		elseif($user == 'john')
		{
			$d['user'] = $user;
			$claimList['headings'] = array('Id','Last','First','Date','Amount','Status');
			$this->load->model('denialmangement');
			$claimList['rows'] = $this->denialmangement->getClaimList();
			$d['claims'] = $claimList;
			$this->load->view('claims',$d);
		}elseif($user == 'james1'){
			# Load Character
			$d['charSheet'] = $this->load->view('classes/jform','',true);
			$data['jCharacter'] = $this->load->view('classes/jCharacter',$d,true);
			# Load coins
			#$coins['list'] = array();
			$coins['list'] = $this->getBterCoinList();
			$data['coins'] = $this->load->view('classes/coins',$coins,true);
			# Load character Sheet
			$data['characterSheet'] = $this->load->view('classes/characterSheet','',true);
			# Load database controls
			$data['database'] = $this->load->view('classes/localdb','',true);
			# Load Map
			$data['map'] = $this->load->view('classes/map','',true);
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
