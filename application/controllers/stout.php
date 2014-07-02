<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}

}
