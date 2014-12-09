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
	public function addCharacter(){
		$name  = $_POST['name'];
		$race  = $_POST['race'];
		$class = $_POST['class'];
		$this->load->model('local');
		$rtn = $this->local->addCharacter($name,$race,$class);
		echo "$rtn";
	}
	public function loadCharacterTable(){
		# SETUP Character table
		# Load data
		$this->load->model('local');
		$obj = $this->local->getCharacterList();
		$heading = $obj[0];
		$rows    = $obj[1];
		# Format table
		$colWidth = array(150,150,150);
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
