<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function index()
	{
		$user = $_SESSION['user'];
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
*/
		$slide = array();
		$slide[] = array('Worker',     $this->load->view('slides/worker','',true));
		$slide[] = array('Trader',     $this->load->view('slides/trader','',true));
		$slide[] = array('Stage',      $this->load->view('slides/stage','',true));
		$slide[] = array('Grapher',    $this->load->view('grapher','',true));
/*
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
		$slides['slides'] = $slide;
		$data['slideTray'] = $this->load->view('slideTray',$slides,true);

		if($user == 'james')
		{
			$this->load->view('home',$data);
		}
		elseif($user == 'john')
		{
			$d['user'] = $user;

/*
			$claimList['headings'] = array('Id','Last','First','Date','Amount','Status');
			$this->load->model('denialmangement');
			$claimList['rows'] = $this->denialmangement->getClaimList();
			$d['claims'] = $claimList;
			$this->load->view('claims',$d);
*/

	# SETUP JTABLE
	$heading = array('Name','Address','Sex');
	$row = array('James','New York','Male');
	$rows = array();
	for($i=0;$i<100;$i++){
		$rows[] = $row;
	}
	$colWidth = array(100,200,100);
	$obj = array(
		'jname'    => 'jtable',
		'heading'  => $heading,
		'rows'     => $rows,
		'jWidth'   => 500,
		'colWidth' => $colWidth
	);
	# END SETUP JTABLE

	# SETUP Char table
	$heading = array('ID','Name','Race','Class');
	$rows = array();
	for($i=0;$i<10;$i++){
		$row = array($i,'Alpha','Human','Fighter');
		$rows[] = $row;
	}
	$colWidth = array(50,200,100,100);
	$charTable = array(
		'jname'    => 'CharactersDB',
		'heading'  => $heading,
		'rows'     => $rows,
		'jWidth'   => 600,
		'colWidth' => $colWidth
	);
	# END SETUP Char table
	$d['charTable'] = $this->load->view('classes/jtable',$charTable,true);
	$d['charSheet'] = $this->load->view('classes/jform',$charTable,true);
	
			$data['jCharacter'] = $this->load->view('classes/jCharacter',$d,true);
			$data['jtable'] = $this->load->view('classes/jtable',$obj,true);
			$this->load->view('landing',$data);
		}
	}
	public function logout(){
		session_unset();
	}
}
