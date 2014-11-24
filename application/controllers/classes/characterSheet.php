<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CharacterSheet extends CI_Controller {

	public function index()
	{
		$name  = $_POST['charName'];
		$race  = $_POST['charRace'];
		$class = $_POST['charClass'];
		$rtn = '';
		$rtn .= "Name $name<br/>";
		$rtn .= "Race $race<br/>";
		$rtn .= "Class $class<br/>";
		$rtn .= "";

		echo $rtn;
	}
	public function load(){
		# SETUP Char table
		$heading = array('ID','Name','Race','Class');
		$rows = array();
		for($i=0;$i<10;$i++){
			$row = array($i,'Alpha','Human','Fighter');
			$rows[] = $row;
		}
		$colWidth = array(50,200,100,100);
		$charTable = array(
			'jname'    => 'CharactersDB',
			'heading'  => $heading,
			'rows'     => $rows,
			'jWidth'   => 600,
			'colWidth' => $colWidth
		);
		# END SETUP Char table
		$rtn = $this->load->view('classes/jtable',$charTable,true);
		echo $rtn;
	}
	public function create(){
		$table  = $_POST['table'];
		$action = $_POST['action'];

		$this->load->model('local');
		$rtn = 'ss';
		if($action == 'Create'){
			$rtn = $this->local->createTable($table);
		}elseif($action == 'Delete'){
			$rtn = $this->local->deleteTable($table);
		}else{
			$rtn = "Bad command";
		}

		echo "Comand: $action $table<br/>From model: $rtn";
	}
	public function check(){
		$this->load->model('local');
		$tables = $this->local->getTableStatus();

		$d['objName'] = 'databaseTables';
		$d['tables'] = $tables;
		$data = $this->load->view('classes/localdb',$d,true);
		echo "$data";
	}
	public function test(){
		echo "test function";
	}
}
