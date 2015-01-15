<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Database extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('local');
	}
	public function index(){}
	public function go(){
		$rtn = $this->local->go();
		echo $rtn;
	}
	public function test(){
		$this->load->model('local');
		$rtn = $this->local->test();
		echo $rtn;
	}
	public function create(){
		$table = $_POST['table'];
		$e = $this->local->createTable($table);
		echo "$e";
	}
	public function drop(){
		$table = $_POST['table'];
		$e = $this->local->dropTable($table);
		echo "$e";
	}
}
