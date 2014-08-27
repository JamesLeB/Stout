<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function index()
	{

		$data['test']        = $this->load->view('test','',true);
		$data['exchange']    = $this->load->view('exchange','',true);

		$development['market'] = $this->load->view('bit/bitMarket','',true);
		$development['buy'] = $this->load->view('bit/bitBuy','',true);
		$development['inventory'] = $this->load->view('bit/bitInventory','',true);
		$development['sales'] = $this->load->view('bit/bitSales','',true);
		$data['development'] = $this->load->view('development',$development,true);

		$data['production']  = $this->load->view('production','',true);

		$this->load->view('home',$data);

	}

}
