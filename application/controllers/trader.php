<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trader extends CI_Controller {

	private $exchangeModel;

	function __construct()
	{
		parent::__construct();
		$this->load->model('Exchange');
		$this->exchangeModel = $this->Exchange;
	}
	public function index()
	{
		$coins = array();
		$list = $this->exchangeModel->getCoinList();
		foreach($list as $coin)
		{
			$buyCount = $this->exchangeModel->getBuyCount($coin);
			$buys = $this->exchangeModel->getBuys($coin);

			$index = 0;
			$ll = "<table>";
			foreach($buys as $b)
			{
				$index++;
				$ll .= "<tr>";
				$ll .= "<td>$index</td>";
				$ll .= "<td>$b[0]</td>";
				$ll .= "<td>$b[1]</td>";
				$ll .= "<td>$b[2]</td>";
				$ll .= "<td>$b[3]</td>";
				$ll .= "</tr>";
			}
			$ll .= "</table>";

			$linear = $this->linearRegression();
			$slope = $linear[0];
			$intercept = $linear[1];

			$coins[] = array($coin,$buyCount,$slope,$intercept,$ll);
			#$coins[] = array($coin,$buyCount,$buys);
		}
		echo json_encode($coins);
	}
	public function getData()
	{
		echo "watching a movie";
	}
/*
	public function exchanges(){
		$d['exchanges'] = $this->exchangeModel->getExchanges();
		echo $this->load->view('slides/trader/exchanges',$d,true);
	}
	public function trades(){
		echo $this->load->view('slides/trader/trades','',true);
	}
	public function accounts(){
		echo $this->load->view('slides/trader/accounts','',true);
	}
	public function regression(){
		echo $this->load->view('slides/trader/regression','',true);
	}
	public function viewHistory(){
		$d['history'] = $this->exchangeModel->getHistory();
		echo $this->load->view('slides/trader/viewHistory',$d,true);
	}
*/
###
### Linear Regression Work
###
			###!!!! supper userful graphinc example
			#$mark = time(); this keeps the brower from caching the image
			#$ms[] = "<img src='lib/graphs/scatter.php?$mark' />";

	private function linearRegression()
	{
		$X = array(43,21,25,42,57,59);
		$Y = array(99,65,79,75,87,81);
		if(sizeof($X) == sizeof($Y))
		{
			return $this->getLinearEquation($X,$Y);
		}
		else
		{
			return 0;
		}
	}
	private function getLinearEquation($X,$Y){
		array_shift($X);
		array_shift($Y);
		$ms = array();

		$sampleSize = sizeof($X);
		$sumX  = 0;
		$sumY  = 0;
		$sumXY = 0;
		$sumXX = 0;
		$sumYY = 0;
		$index = 0;
		foreach($X as $d)
		{
			$sumXX += $d*$d;
			$sumXY += $d*$Y[$index];
			$sumX  += $d;
			$index++;
		}
		foreach($Y as $d)
		{
			$sumYY += $d*$d;
			$sumY  += $d;
		}

		$intercept=(($sumY*$sumXX)-($sumX*$sumXY))/(($sampleSize*$sumXX)-($sumX*$sumX));
		$slope=(($sampleSize*$sumXY)-($sumX*$sumY))/(($sampleSize*$sumXX)-($sumX*$sumX));

		return array($slope,$intercept);
		#return "hello from groot";
	}
###
### END Linear Regression Work
###

}
?>
