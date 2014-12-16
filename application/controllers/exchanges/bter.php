<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bter extends CI_Controller {

	public function index(){
		echo "Default return from Bter controller";
	}
	public function getBter(){
		#ticker
		$tickerJson = file_get_contents('http://data.bter.com/api/1/ticker/BTC_CNY');
		$tickerObj = JSON_decode($tickerJson,true);
		$m = "<h3>Ticker</h3><table>";
		$m .= "<tr>";
		$m .= "<td>Last</td>";
		$m .= "<td>High</td>";
		$m .= "<td>Low</td>";
		$m .= "<td>Avg</td>";
		$m .= "<td>Sell</td>";
		$m .= "<td>Buy</td>";
		$m .= "<td>Vol_btc</td>";
		$m .= "<td>Vol_cny</td>";
		$m .= "</tr>";
		$m .= "<tr>";
		$m .= "<td>".$tickerObj['last']."</td>";
		$m .= "<td>".$tickerObj['high']."</td>";
		$m .= "<td>".$tickerObj['low']."</td>";
		$m .= "<td>".$tickerObj['avg']."</td>";
		$m .= "<td>".$tickerObj['sell']."</td>";
		$m .= "<td>".$tickerObj['buy']."</td>";
		$m .= "<td>".$tickerObj['vol_btc']."</td>";
		$m .= "<td>".$tickerObj['vol_cny']."</td>";
		$m .= "</tr>";
		$m .= "</table>";
		$ticker = $m;
		#depth
		$depthJson = file_get_contents('http://data.bter.com/api/1/depth/btc_cny');
		$depthObj = JSON_decode($depthJson,true);
		$keys = array_keys($depthObj);
		$m = "<table>";
		foreach($keys as $k){
			$d = $depthObj[$k];
			$d = gettype($d);
			$m .= "<tr>";
			$m .= "<td>$k</td>";
			$m .= "<td>$d</td>";
			$m .= "</tr>";
		}
		$m .= "</table>";
		#$depth = "Result: ".$depthObj['result'];
		$depth = "depth";
		#asks
		$asksA = $depthObj['asks'];
		$t = "<h3>Asks</h3><table>";
		foreach($asksA as $a){
			$t .= "<tr>";
			foreach($a as $aa){
				$t .= "<td>$aa</td>";
			}
			$t .= "</tr>";
		}
		$t .= "</table>";
		$asks = $t;
		#bids
		$bidsA = $depthObj['bids'];
		$t = "<h3>Bids</h3><table>";
		foreach($bidsA as $a){
			$t .= "<tr>";
			foreach($a as $aa){
				$t .= "<td>$aa</td>";
			}
			$t .= "</tr>";
		}
		$t .= "</table>";
		$bids = $t;
		#history
		$tradesJson = file_get_contents('http://data.bter.com/api/1/trade/btc_cny');
		$tradesObj = JSON_decode($tradesJson,true);
		$t = "";
		$tradeData = $tradesObj['data'];
		$t .= "<h3>History</h3><table>";
		$t .= "<tr>";
		$t .= "<td>Timestamp</td>";
		$t .= "<td>Price</td>";
		$t .= "<td>Amount</td>";
		$t .= "<td>Tid</td>";
		$t .= "<td>Type</td>";
		$t .= "<td>Date</td>";
		$t .= "</tr>";
		foreach($tradeData as $trade){
			$t .= "<tr>";
			$t .= "<td>".$trade['date']."</td>";
			$t .= "<td>".$trade['price']."</td>";
			$t .= "<td>".$trade['amount']."</td>";
			$t .= "<td>".$trade['tid']."</td>";
			$t .= "<td>".$trade['type']."</td>";
			$t .= "<td>".date('Y-m-d H:i:s',$trade['date'])."</td>";
			$t .= "</tr>";
		}
		$t .= "</table>";
		
		#foreach($tradesObj as $trade){
		#	$t .= gettype($trade);
		#}
		$trades = $t;
		$obj = array($ticker,$asks,$bids,$trades);
		$json = JSON_encode($obj);
		echo $json;
	}
	private function getBterCoinList(){
		$json = file_get_contents('http://data.bter.com/api/1/pairs');
		$obj = json_decode($json,TRUE);
		return $obj;
	}
}

?>
