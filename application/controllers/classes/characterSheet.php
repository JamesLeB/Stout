<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CharacterSheet extends CI_Controller {

	public function index()
	{
/*
		$name  = $_POST['charName'];
		$race  = $_POST['charRace'];
		$class = $_POST['charClass'];
		$rtn = '';
		$rtn .= "Name $name<br/>";
		$rtn .= "Race $race<br/>";
		$rtn .= "Class $class<br/>";
		$rtn .= "";
		echo $rtn;
*/
		echo "index";
	}
	public function loadCharacterTable(){
		# SETUP Char table
		# Load data
		$this->load->model('local');
		$obj = $this->local->getCharacterList();
/*
		$heading = array('ID','Name','Race','Class');
		$rows = array();
		for($i=0;$i<10;$i++){
			$row = array($i,'Alpha','Human','Fighter');
			$rows[] = $row;
		}
		$obj = array($heading,$rows);
*/
		$heading = $obj[0];
		$rows    = $obj[1];
		# Format table
		$colWidth = array(200,150,150);
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
	public function test(){
		echo "test function";
	}
}
