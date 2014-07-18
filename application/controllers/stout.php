<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function index()
	{

		$data['test']        = $this->load->view('test','',true);
		$data['development'] = $this->load->view('development','',true);
		$data['production']  = $this->load->view('production','',true);

		$this->load->view('home',$data);

	}

}
