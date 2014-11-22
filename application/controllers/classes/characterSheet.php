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
}
