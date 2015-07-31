<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function logout(){ session_unset(); }
	public function index()
	{

		$user = $_SESSION['user'];
		if($user == 'james')
		{
			# Load Character
			$d['table'] = '';#$this->load->view('dnd/characterTable','',true);
			$d['form']  = '';#$this->load->view('dnd/newCharacterForm','',true);

			$data['newCharacter'] = '';#$this->load->view('dnd/newCharacter',$d,true);

			# Load coins
			#$coins['list'] = array();
			#$coins['list'] = $this->getBterCoinList();
			$data['coins'] = '';#$this->load->view('trader','',true);

			# Load character Sheet
			$data['characterSheet'] = '';#$this->load->view('classes/charSheet','',true);

			# Load database controls
			$data['database'] = '';#$this->load->view('classes/localdb','',true);

			# Load Map
			$data['map'] = '';#$this->load->view('classes/map','',true);

			# Load Spash
			#$data['splash'] = $this->load->view('slides/splash','',true);
			$data['splash'] = '';#$this->load->view('slides/lampSetup','',true);

			# LOAD TRADER
			#$data['trader'] = $this->load->view('slides/trader.php','',true);

			# LOAD WEBGL
			$data['webgl'] = $this->load->view('webgl/webgl.php','',true);

			# Load Laning page
			$this->load->view('landing',$data);
		}
		elseif($user == 'junior')
		{
			$d['load277']      = $this->load->view('junior/load277','',true);
			$d['todo']         = $this->load->view('junior/todo','',true);
			$d['billMedicaid'] = $this->load->view('junior/billMedicaid','',true);
			$d['loadClaims']   = $this->load->view('junior/loadClaims','',true);
			$d['dbtables']     = $this->load->view('junior/dbtables','',true);
			$d['emdeonBridge'] = $this->load->view('junior/emdeonBridge','',true);

			$this->load->view('junior/home',$d);
		}
		elseif($user == 'john')
		{
			$d['user'] = $user;
			$d['one']   = $this->load->view('john/todo','',true);
			$d['two']   = $this->load->view('john/eleCheck','',true);
			$d['three'] = $this->load->view('john/fedres','',true);
			$this->load->view('john/home',$d);
		}
		elseif($user == 'jamesold')
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
	}
}
