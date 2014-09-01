<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expense extends CI_Controller {

	public function index(){
		echo "Default return from Expense controller";
	}
	public function setup(){
		echo "setting up Expense<br/>";
		$this->load->model('expenseModel');
		echo $this->expenseModel->setupList();
	}
	public function addRecord(){

		$dirtyName = $this->uri->segment(4);
		$cleanName = str_replace('%20',' ',$dirtyName);
		$Type = $this->uri->segment(5);

		$record = array();
		$record['name'] = $cleanName;
		$record['type'] = $Type;

		$this->load->model('expenseModel');
		#echo "controller - adding record";
		$list = $this->expenseModel->addRecord($record);
		echo $this->makeListTable($list);
	}
	public function loadList(){
		$this->load->model('expenseModel');
		$list = $this->expenseModel->getList();
		echo $this->makeListTable($list);
	}
	public function deleteRecord(){
		$arg1 = $this->uri->segment(4);
		$this->load->model('expenseModel');
		$list = $this->expenseModel->deleteRecord($arg1);
		echo $this->makeListTable($list);
	}
	private function makeListTable($list){
		$headings = $list['headings'];
		$oldRecords = $list['records'];
		$newRecords = array();
		foreach($oldRecords as $record){
			$id = $record[0];
			$record[] = "<button onclick='deleteExpense($id);'>X</button>";
			$newRecords[] = $record;
		}
		$table = renderTable($headings,$newRecords);
		return $table;
	}
}

?>
