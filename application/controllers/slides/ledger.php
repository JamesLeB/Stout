<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ledger extends CI_Controller {

	public function index(){
		echo "Default return from Action controller";
	}
	public function setup(){
		echo "setting up ledger<br/>";
		$this->load->model('ledgerModel');
		echo $this->ledgerModel->setupLedger();
/*
		$config = array(
			'max'     => 10,
			'min'     => 0,
			'sizex'   => 600,
			'sizey'   => 300,
			'padding' => 20
		);
		$json = json_encode($config);
		$file = 'lib/graphs/config/default.json';
		file_put_contents($file,$json);
		echo "$json";
*/
	}
	public function loadLedger(){
		echo "loading ledger<br/>";
		$this->load->model('ledgerModel');
		echo $this->ledgerModel->getLedger();
	}
	public function deleteLedgerEntry(){
		echo "loading ledger<br/>";
		$this->load->model('ledgerModel');
		echo $this->ledgerModel->deleteLedgerEntry();
	}
}

?>
