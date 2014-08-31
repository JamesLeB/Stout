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
	public function addRecord(){

		$type    = $this->uri->segment(4);
		$account = $this->uri->segment(5);
		$budget  = $this->uri->segment(6);
		$vendor  = $this->uri->segment(7);
		$amount  = $this->uri->segment(8);

		$record = array();
		$record['type']    = $type;
		$record['account'] = $account;
		$record['budget']  = $budget;
		$record['vendor']  = $vendor;
		$record['amount']  = $amount;

		$this->load->model('ledgerModel');
		#echo "controller - adding record";
		$ledger = $this->ledgerModel->addRecord($record);
		echo $this->makeLedgerTable($ledger);
	}
	public function loadLedger(){
		$this->load->model('ledgerModel');
		$ledger = $this->ledgerModel->getLedger();
		echo $this->makeLedgerTable($ledger);
	}
	public function deleteLedgerEntry(){
		$arg1 = $this->uri->segment(4);
		$this->load->model('ledgerModel');
		$ledger = $this->ledgerModel->deleteLedgerEntry($arg1);
		echo $this->makeLedgerTable($ledger);
	}
	private function makeLedgerTable($ledger){
		$headings = $ledger['headings'];
		$oldRecords = $ledger['records'];
		$newRecords = array();
		foreach($oldRecords as $record){
			$id = $record[0];
			$record[] = "<button onclick='deleteLedgerEntry($id);'>X</button>";
			$newRecords[] = $record;
		}
		$table = renderTable($headings,$newRecords);
		return $table;
	}
}

?>
