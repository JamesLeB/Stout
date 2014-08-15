<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class James extends CI_Controller {

	public function index()
	{
		$db1 = $this->load->database('money',true);
		#$rs = $db1->query('drop table myxtable');
		#$rs = $db1->query('create table myxtable(tblis int)');
		echo "from controller";
		$this->load->view('home');
	}
}
