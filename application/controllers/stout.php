<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function index()
	{

		$data['Market']      = $this->load->view('bit/bitMarket','',true);
		$data['Buy']         = $this->load->view('bit/bitBuy','',true);
		$data['Inventory']   = $this->load->view('bit/bitInventory','',true);
		$data['Sales']       = $this->load->view('bit/bitSales','',true);
		$data['test']        = $this->load->view('test','',true);
		$data['Exchange']    = $this->load->view('exchange','',true);

		$development['test'] = 'first worker';
		$data['development'] = $this->load->view('development',$development,true);

		$data['production']  = $this->load->view('production','',true);

		$this->load->view('home',$data);

	}

}
