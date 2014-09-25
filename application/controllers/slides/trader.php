<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trader extends CI_Controller {

	#private $model;
	#private $filePath = 'files/EDIbatches/';

	function __construct(){
		parent::__construct();
		#$this->load->model('Character_model');
		#$this->model = $this->Character_model;
	}
	public function test(){
		$ms = array();
		$status = "Test Mode";
		header("status: $status");
		$ms[] = 'Setting up Test Enviornment';
		$ms[] = 'Connecting to Exchange model...';
		$this->load->model('Exchange');
		$test = $this->Exchange->test('james');
		$ms[] = 'Connected to model...';
		$ms[] = "Model test...$test";
		$ms[] = 'Done Testing :)';
		$e = '';
		foreach($ms as $m){$e.=$m.'<br/>';}
		echo $e;
/*
		$ms = 'Starting test<br/>';
		#$dbtest = $this->model->test();
		$file = 'test.txt';
		$ms .= "Saving file<br/>";
		file_put_contents($this->filePath.$file,"ready to move file and open it lunch time");
		$ms .= "Done Test<br/>";
		echo $ms;
*/
	}
}

?>
