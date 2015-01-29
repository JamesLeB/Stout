<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trader extends CI_Controller {

	private $exchangeModel;

	function __construct()
	{
		parent::__construct();
		$this->load->model('Exchange');
		$this->exchangeModel = $this->Exchange;
	}
	public function getCoinDetail()
	{
		$h = $this->load->view('trader/coinDetail','',true);
		echo $h;
	}
	public function getCoinList()
	{ 
		$list = $this->exchangeModel->getCoinList();
		echo json_encode($list);
	}
	public function getCoinSlope()
	{
		$coin = $_POST['coin'];
		//echo "coin: $coin";

		$buyCount = $this->exchangeModel->getBuyCount($coin);
		$volume24 = $this->exchangeModel->getVolume24($coin);
		$buys     = $this->exchangeModel->getBuys($coin);

		$buysAll = $buys[0];
		$buys24  = $buys[1];
		$buys48  = $buys[2];

		$slope   = 0;
		$slope24 = 0;
		$slope48 = 0;

		if(1 && isset($buys24[0][0]))
		{
			# Process under 24 buys
			$start = $buys24[0][0];
			$X = array();
			$Y = array();
			foreach($buys24 as $b)
			{
				$elaps = $b[0] - $start;
				$X[] = $elaps;
				$Y[] = $b[1];
			}
			$linear  = $this->linearRegression($X,$Y);
			$slope24 = $linear[0];
			$inter24 = $linear[1];
		}
		if(1 && isset($buys48[0][0]))
		{
			# Process under 48 buys
			$start = $buys48[0][0];
			$X = array();
			$Y = array();
			foreach($buys48 as $b)
			{
				$elaps = $b[0] - $start;
				$X[] = $elaps;
				$Y[] = $b[1];
			}
			$linear  = $this->linearRegression($X,$Y);
			$slope48 = $linear[0];
			$inter48 = $linear[1];
		}
		if(1 && isset($buysAll[0][0]))
		{
			#Process All buys
			$start = $buysAll[0][0];
			$X = array();
			$Y = array();
			foreach($buysAll as $b)
			{
				$elaps = $b[0] - $start;
				$X[] = $elaps;
				$Y[] = $b[1];
			}
			$linear = $this->linearRegression($X,$Y);
			$slope = $linear[0];
			$intercept = $linear[1];
		}
		$data = array($slope,$slope48,$slope24,$volume24);
		echo json_encode($data);
	}
	public function index()
	{
		$ll = 'test table';
		if(0)
		{
			# Build Test table
			$index = 0;
			$ll = "<table id='coinTable'>";
			foreach($buysAll as $b)
			{
				$elaps = $b[0] - $start;
				$index++;
				$ll .= "<tr>";
				$ll .= "<td>$index</td>";
				$ll .= "<td>$b[0]</td>";
				$ll .= "<td>$b[1]</td>";
				$ll .= "<td>$b[2]</td>";
				$ll .= "<td>$b[3]</td>";
				$ll .= "<td>$elaps</td>";
				$ll .= "</tr>";
			}
			$ll .= "</table>";
			$ll .= "
				<style>
					#coinTable td {padding:10px;}
				</style>
			";
		}
	}
	public function getData()
	{
		echo "watching a movie";
	}

	###!!!! supper userful graphinc example
	#$mark = time(); this keeps the brower from caching the image
	#$ms[] = "<img src='lib/graphs/scatter.php?$mark' />";

	private function linearRegression($X,$Y)
	{
		if(sizeof($X) > 2 && sizeof($X) == sizeof($Y))
		{
			return $this->getLinearEquation($X,$Y);
		}
		else
		{
			return array(0,0);
		}
	}
	private function getLinearEquation($X,$Y)
	{
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
		$intercept = 0;
		$slope = 0;
		if($sumXX != 0)
		{
			$intercept=(($sumY*$sumXX)-($sumX*$sumXY))/(($sampleSize*$sumXX)-($sumX*$sumX));
			$slope=(($sampleSize*$sumXY)-($sumX*$sumY))/(($sampleSize*$sumXX)-($sumX*$sumX));
		}
		return array($slope,$intercept);
	}
}
?>
