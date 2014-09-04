<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function index()
	{

/*
		$development['market']    = $this->load->view('bit/bitMarket','',true);
		$development['buy']       = $this->load->view('bit/bitBuy','',true);
		$development['inventory'] = $this->load->view('bit/bitInventory','',true);
		$development['sales']     = $this->load->view('bit/bitSales','',true);
*/

		$slide = array();
		$slide[] = array('Grapher',$this->load->view('grapher','',true));
		$slide[] = array('Expense',$this->load->view('slides/expense','',true));
		$slide[] = array('Accounts',$this->load->view('slides/accounts','',true));
		$slide[] = array('Ledger',$this->load->view('slides/ledger','',true));
		#$slide[] = array('trader',$this->load->view('trader','',true));
		#$slide[] = array('exchange',$this->load->view('exchange','',true));
		#$slide[] = array('development',$this->load->view('development',$development,true));
		#$slide[] = array('production',$this->load->view('production','',true));

		$slides['slides'] = $slide;
		$data['slideTray'] = $this->load->view('slideTray',$slides,true);

		$this->load->view('home',$data);

	}

}
