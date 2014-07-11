<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function index()
	{
		$data['develop'] = $this->load->view('develop','',true);
		$this->load->view('home',$data);
	}

}
