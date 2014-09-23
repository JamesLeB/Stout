<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grapher extends CI_Controller {

	private function setScaleFactor($price){
		if($price      > 10){ return 1;}
		if($price*10   > 10){ return 10;}
		if($price*100  > 10){ return 100;}
		if($price*1000 > 10){ return 1000;}
		return 1;
	}
	public function getBuys(){
		$timeOffset = 60*60*4;
		$json = file_get_contents('https://api.mintpal.com/v1/market/trades/LTC/BTC');
		$obj = json_decode($json,TRUE);
		$count = $obj['count'];
		$trades = $obj['trades'];
		usort($trades,'custSort');
		$startTime = $trades[0]['time'];
		$basePrice = $trades[0]['price'];
		$scaleFactor = $this->setScaleFactor($basePrice);
		#$headings = array_keys($trades[0]);
		$headings = array(
			'index',
			'time',
			'type',
			'price',
			'amount',
			'total',
			'elaps'
		);
		$buyHeadings = array(
			'time',
			'price'
		);
		$lines = array();
		$index = 1;
		$buys = array();
		$sells = array();
		$countBuys = 0;
		$countSells = 0;
		foreach($trades as $trade){
			$line = array();
			$line[] = $index++;
			#$line[] = $trade['time'];
			$line[] = date('Y-m-d H:i:s',$trade['time']+$timeOffset);
			$line[] = $trade['type'] == 0 ? 'Buy' : 'Sell';
			$price = $trade['price'];
			$line[] = $price;
			$line[] = $trade['amount'];
			$line[] = $trade['total'];
			$elapsed = floor(($trade['time']-$startTime)/60);
			$line[] = $elapsed;
			$lines[] = $line;
			if($trade['type'] == 0){
				$countBuys++;
				$buys[] = array(
					'time'  => $elapsed,
					'price' => $price * $scaleFactor
				);
			}else{
				$countSells++;
			}
		}
		$htmlTable = renderTable($headings,$lines);
		#$htmlTable = renderTable($buyHeadings,$buys);
		$rtn  = "Count = $count<br/>";
		$rtn .= "StartTime = $startTime<br/>";
		$rtn .= "Buy Count = $countBuys<br/>";
		$rtn .= "Sell Count = $countSells<br/>";
		$rtn .= $htmlTable;
		echo $rtn;
		$json = json_encode($buys);
		$file = 'lib/graphs/data/sample1.json';
		file_put_contents($file,$json);
	} # END function getBuys
	public function config(){
		echo "configuring graph...<br/>";

		# SET GRAPH CONFIG
		$config = array(
			'max'     => 10,
			'min'     => 0,
			'sizex'   => 600,
			'sizey'   => 300,
			'legendX' => 190,
			'legendY' => 20,
			'padding' => 20
		);
		$json1 = json_encode($config);
		$file1 = 'lib/graphs/config/default.json';
		file_put_contents($file1,$json1);

		# SET DATA SET 1
		$setName = 'DEFAULT';
		$label = array('A','B','C','D','E');
		$color = array(
			"R"=>0,
			"G"=>0,
			"B"=>256
		);
		$data  = array(1,2,3,4,3);
		$dataSet1 = array(
			'setName' => $setName,
			'label'   => $label,
			'color'   => $color,
			'data'    => $data
		);
		$json2 = json_encode($dataSet1);
		$file2 = 'lib/graphs/config/data1.json';
		file_put_contents($file2,$json2);

		echo "config done...<br/>";
	}
}

?>
