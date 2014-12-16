<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trader extends CI_Controller {

	private $exchangeModel;

	function __construct(){
		parent::__construct();
		$this->load->model('Exchange');
		$this->exchangeModel = $this->Exchange;
	}
	public function index(){
		echo "Message from Trader Controler";
	}
	public function exchanges(){
		echo "Exchanges";
	}
###
### Linear Regression Work
###
	private function linearRegression(){
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
			#$ms[] = "<img src='lib/graphs/scatter.php?$mark' />";

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

/*
		$ms[] = "Sample = $sampleSize";
		$ms[] = "SumX  = $sumX";
		$ms[] = "SumY  = $sumY";
		$ms[] = "SumXY = $sumXY";
		$ms[] = "SumXX = $sumXX";
		$ms[] = "SumYY = $sumYY";
		$ms[] = "";
*/

		$intercept=(($sumY*$sumXX)-($sumX*$sumXY))/(($sampleSize*$sumXX)-($sumX*$sumX));
		$slope=(($sampleSize*$sumXY)-($sumX*$sumY))/(($sampleSize*$sumXX)-($sumX*$sumX));

		$ms[] = "Slope..b. $slope";
		$ms[] = "Intercept..a. $intercept";
		$ms[] = " y = a + bx";

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
}
?>
