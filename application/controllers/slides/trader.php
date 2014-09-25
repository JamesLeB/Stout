<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trader extends CI_Controller {

	private $exchangeModel;

	function __construct(){
		parent::__construct();
		$this->load->model('Exchange');
		$this->exchangeModel = $this->Exchange;
	}
	public function test(){
		$ms = array();
		$status = "Test Mode";
		header("status: $status");
		$ms[] = 'Setting up Test Enviornment';
		$ms[] = 'Connecting to Exchange model...';
		$test = $this->exchangeModel->test('james');
		$ms[] = 'Connected to model...';
		$ms[] = "Model test...$test";
		$ms[] = 'Done Testing :)';
		$e = '';
		foreach($ms as $m){$e.=$m.'<br/>';}
		echo $e;
	}
}

?>
