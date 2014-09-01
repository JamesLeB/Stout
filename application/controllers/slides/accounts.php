<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {

	public function index(){
		echo "Default return from Action controller";
	}
	public function setup(){
		echo "setting up Accounts<br/>";
		$this->load->model('accountsModel');
		echo $this->accountsModel->setupList();
	}
	public function addRecord(){

		$accountName = $this->uri->segment(4);
		$test = str_replace('%20',' ',$accountName);
		$accountType = $this->uri->segment(5);

		$record = array();
		$record['name'] = $test;
		$record['type'] = $accountType;

		$this->load->model('accountsModel');
		#echo "controller - adding record";
		$list = $this->accountsModel->addRecord($record);
		echo $this->makeListTable($list);
	}
	public function loadList(){
		$this->load->model('accountsModel');
		$list = $this->accountsModel->getList();
		echo $this->makeListTable($list);
	}
	public function deleteRecord(){
		$arg1 = $this->uri->segment(4);
		$this->load->model('accountsModel');
		$list = $this->accountsModel->deleteRecord($arg1);
		echo $this->makeListTable($list);
	}
	private function makeListTable($list){
		$headings = $list['headings'];
		$oldRecords = $list['records'];
		$newRecords = array();
		foreach($oldRecords as $record){
			$id = $record[0];
			$record[] = "<button onclick='deleteAccount($id);'>X</button>";
			$newRecords[] = $record;
		}
		$table = renderTable($headings,$newRecords);
		return $table;
	}
}

?>
