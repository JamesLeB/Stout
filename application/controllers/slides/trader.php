<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trader extends CI_Controller {

	private $exchangeModel;

	function __construct(){
		parent::__construct();
		$this->load->model('Exchange');
		$this->exchangeModel = $this->Exchange;
	}
###
### Linear Regression Work
###
	public function linearRegression(){
		header("status: Calculating Linear Regression");
		$ms = array();
		$ms[] = 'Load X values';
		$X = array('X series',1,2,3,4,5);
		$ms[] = $this->array2html($X);
		$ms[] = 'Load Y values';
		$Y = array('Y series',1,2,3,4,5);
		$ms[] = $this->array2html($Y);
		try{
			$ms[] = 'Validate Series Length';
			if(sizeof($X) != sizeof($Y)){throw new Exception('Series not same size!!');}
			$ms[] = '!!! NEED TO PASS SERIES DATA TO GRAPH !!!';
			$ms[] = 'Load Graph';
			$mark = time();
			$ms[] = "<img src='lib/graphs/scatter.php?$mark' />";
		}catch(Exception $e){
			$ms[] = $e->getMessage();
		}

		$e = ''; foreach($ms as $m){$e.="$m<br/>";} echo $e;
	}
	private function array2html($a){
		$html = "<table class='array2html'><tr>";
		foreach($a as $e){$html .= "<td>$e</td>";}
		$html .= "</tr></table>";
		return $html;
	}
###
### END Linear Regression Work
###
	public function getBuys(){
		$ms = array();
		$status = "Load mintPal buy Data";
		header("status: $status");
		$ms[] = 'Getting Mint data';
		$market = $this->exchangeModel->getBuys('trades');
		$e = '';
		foreach($ms as $m){$e.=$m.'<br/>';}
		echo $e;
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
