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
		#$series = $this->getBuySeries();
		$ms = array();
		$_SESSION['seriesName'] = 'Coin something';
		#$X = $series[0];
		#$Y = $series[1];
		$X = array('first',43,21,25,42,57,59);
		$Y = array('second',99,65,79,75,87,81);

		$_SESSION['xSeries'] = $X;
		$_SESSION['ySeries'] = $Y;
		#$ms[] = $this->array2html($X); #$ms[] = $this->array2html($Y);
		try{
			if(sizeof($X) != sizeof($Y)){throw new Exception('Series not same size!!');}

			$ms[] = "Getting line equation - broken";
			$ms[] = $this->getLinearEquation($X,$Y);

			$mark = time();
			$ms[] = "<img src='lib/graphs/scatter.php?$mark' />";

		}catch(Exception $e){
			$ms[] = $e->getMessage();
		}

		$e = ''; foreach($ms as $m){$e.="$m<br/>";} echo $e;
	}
	private function getLinearEquation($X,$Y){
		array_shift($X);
		array_shift($Y);
		$ms = array();

# X SERIES
		$sampleSize = sizeof($X);
		$sumX  = 0;
		$sumY  = 0;
		$sumXY = 0;
		$sumXX = 0;
		$sumYY = 0;
		#$ms[] = "-----------------"; $ms[] = "X series"; $ms[] = "-----------------";
		$index = 0;
		foreach($X as $d){
			$sumXX += $d*$d;
			$sumXY += $d*$Y[$index];
			$sumX  += $d;
			$index++;
			#$ms[] = $d;
		}
# Y SERIES
		#$ms[] = "-----------------"; $ms[] = "Y series"; $ms[] = "-----------------";
		foreach($Y as $d){
			$sumYY += $d*$d;
			$sumY  += $d;
			#$ms[] = $d;
		}

		$ms[] = "-----------------";
		$ms[] = "Summary";
		$ms[] = "-----------------";

		$ms[] = "Sample = $sampleSize";
		$ms[] = "SumX  = $sumX";
		$ms[] = "SumY  = $sumY";
		$ms[] = "SumXY = $sumXY";
		$ms[] = "SumXX = $sumXX";
		$ms[] = "SumYY = $sumYY";

		$e = ''; foreach($ms as $m){$e.="$m<br/>";} return $e;
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
	private function getBuySeries(){
		$buys = $this->exchangeModel->getBuys();
		$time = array('Time');
		$price = array('Price');
		foreach($buys as $buy){
			$time[]  = $buy['time'];
			$price[] = $buy['price'];
		}
		return array($time,$price);
	}
	public function getBuys(){
		$ms = array();
		$status = "Load mintPal buy Data";
		header("status: $status");
		$ms[] = 'Getting Mint data';
		$buys = $this->exchangeModel->getBuys();
		foreach($buys as $buy){
			$time  = $buy['time'];
			$price = $buy['price'];
			$ms[] = "$time\t$price";
		}
		$e = '';
		foreach($ms as $m){$e.=$m.'<br/>';}
		echo $e;
	}
	public function mint(){
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
		#$incoming = $this->uri->segment(3);
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

$ms[] = 'Connecting to DB...';
$db = $this->load->database('trader',true);
$ms[] = 'connection done...';

$query = 'SELECT * FROM coins';
$rs = $db->query($query);
foreach($rs->result_array() as $row){
	$id = $row['id'];
	$ms[] = ".... id is $id";
}

		$ms[] = 'Done Testing :)';
		$e = '';
		foreach($ms as $m){$e.=$m.'<br/>';}
		echo $e;
	}
}
?>
