<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trader extends CI_Controller {

	private $exchangeModel;

	function __construct(){
		parent::__construct();
		$this->load->model('Exchange');
		$this->exchangeModel = $this->Exchange;
	}
	public function mint(){
		#$incoming = $this->uri->segment(3);
		$ms = array();
		$status = "Load Mintpal Data";
		header("status: $status");
		$ms[] = 'Getting Mint data';
		$market = $this->exchangeModel->getMarket('trades');
		$e = '';
		foreach($ms as $m){$e.=$m.'<br/>';}
		echo $e;
	}
	public function test(){
		$ms = array();
		$status = "Test Mode";
		header("status: $status");
		$ms[] = 'Setting up Test Enviornment';
		$ms[] = 'Connecting to Exchange model...';
		$test = $this->exchangeModel->test('james');
		$ms[] = 'Connected to model';
		$ms[] = "Model test...$test";
		$ms[] = 'Getting data from Request...';
		$test = '';
		if(isset($_REQUEST['test'])){
			$test = $_REQUEST['test'];
		}
		$ms[] = "Request Test...$test";
		$ms[] = 'Done Testing :)';
		$e = '';
		foreach($ms as $m){$e.=$m.'<br/>';}
		echo $e;
	}
}

?>
