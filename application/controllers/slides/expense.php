<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expense extends CI_Controller {

	private $model;

	function __construct(){
		parent::__construct();
		$this->load->model('Expense_model');
		$this->model = $this->Expense_model;
	}
	public function index(){
		echo "Default return from Expense controller";
	}
	public function setup(){
		echo "setting up Expense<br/>";
		echo $this->model->setupList();
	}
	public function addRecord(){

		$dirtyName = $this->uri->segment(4);
		$cleanName = str_replace('%20',' ',$dirtyName);
		$Type = $this->uri->segment(5);

		$record = array();
		$record['name'] = $cleanName;
		$record['type'] = $Type;

		$list = $this->model->addRecord($record);
		echo $this->makeListTable($list);
	}
	public function loadList(){
		$list = $this->model->getList();
		echo $this->makeListTable($list);
	}
	public function deleteRecord(){
		$arg1 = $this->uri->segment(4);
		$list = $this->model->deleteRecord($arg1);
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
