<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

	#private $model;
	private $filePath = 'files/EDIbatches/';

	function __construct(){
		parent::__construct();
		#$this->load->model('Character_model');
		#$this->model = $this->Character_model;
	}
	public function test(){
		$ms = 'Starting test<br/>';
		#$dbtest = $this->model->test();
		$file = 'test.txt';
		$ms .= "Saving file<br/>";
		file_put_contents($this->filePath.$file,"ready to move file and open it lunch time");
		$ms .= "Done Test<br/>";
		echo $ms;
	}
	public function getTestFile(){
		$file = 'next.x12';
		$ms = file_get_contents($this->filePath.$file);
		echo $ms;
	}
}

?>
