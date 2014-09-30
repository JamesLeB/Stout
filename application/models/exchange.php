<?php
class Exchange extends CI_Model{

	#private $db;

	function __construct(){
		parent::__construct();
		#$this->db = $this->load->database('dentrix',true);
	}
	private function setScaleFactor($price){
		$factor = 1;
		while($price*pow(10,$factor) < 1000){
			$factor++;
		}
		return $factor;
	}
	public function getBuys(){
		$thing = $this->getTrades();
		$data = $thing['data'];
		$buys = $thing['buys'];
		return $buys;
	}
	public function getTrades(){
		$timeOffset = 60*60*4;
		$json = file_get_contents('https://api.mintpal.com/v1/market/trades/LTC/BTC');
		$obj = json_decode($json,TRUE);
		$count = $obj['count'];
		$trades = $obj['trades'];
		usort($trades,'custSort');
		$startTime = $trades[0]['time'];
		$basePrice = $trades[0]['price'];
		$scaleFactor = $this->setScaleFactor($basePrice);
		$headings = array(
			'index',
			'time',
			'type',
			'price',
			'scalePrice',
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
			$line[] = floor($price * pow(10,$scaleFactor));
			$line[] = $trade['amount'];
			$line[] = $trade['total'];
			$elapsed = floor(($trade['time']-$startTime)/(60*60));
			$line[] = $elapsed;
			$lines[] = $line;
			if($trade['type'] == 0){
				$countBuys++;
				$buys[] = array(
					'time'  => $elapsed,
					'price' => floor($price * pow(10,$scaleFactor))
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
		$rtn .= "Scale Factor = $scaleFactor<br/>";
		$rtn .= $htmlTable;
		return array(
			'data' => $rtn,
			'buys' => $buys
		);
		#echo $rtn;
	} # END function getTrades
	public function getMarket($incoming){
		$echo = array();
		$echo[] = 'Outlander';
		$echo[] = $incoming;

		$json = file_get_contents('https://api.mintpal.com/v1/market/trades/LTC/BTC');
		$obj = json_decode($json,true);
	
		$count = $obj['count'];
		$echo[] = "Count $count";
	
		$trades = $obj['trades'];
	
		$heading = array('id');
		$keys = array_keys($trades[0]);
		foreach($keys as $key){ $heading[] = $key; }
		$heading[] = 'test';
	
		$allTrades = array();
		$sellTrades = array();
		$buyTrades = array();
		$buys = array();
		$id = 0;
		foreach($trades as $trade){
			$row = array(++$id);
			$row[] = date('Y-m-d H:i:s',$trade['time']);
			$row[] = $trade['type'] == 0 ? 'Buy' : 'Sell';
			$row[] = $trade['price'];
			$row[] = $trade['amount'];
			$row[] = $trade['total'];
			$row[] = "jamie";
			$allTrades[] = $row;
			if($trade['type'] == 1){$sellTrades[] = $row;}
			if($trade['type'] == 0){$buyTrades[] = $row;}
		}

		if( $incoming == 'trades' ){$echo[] = renderTable($heading,$allTrades);}
		if( $incoming == 'sell'   ){$echo[] = renderTable($heading,$sellTrades);}
		if( $incoming == 'buy'    ){$echo[] = renderTable($heading,$buyTrades);}

		$msg = '';
		foreach($echo as $e){
			$msg .= "$e<br/>";
		}
		echo $msg;

	}
	function test($x){
		return "return from model test function";
	}
/*
		$htmlTable = 'table';
		$file = "lib/queries/patientLedger.sql";
		if(file_exists($file)){
			$query = file_get_contents($file);
			$parm = array($x);
			$rs = $this->db->query($query,$parm);
			if($rs){
				#$prs = processResultSet($rs);
				$prs = $this->processLedger($rs);
				$htmlTable = renderTable($prs[0],$prs[1]);
			}
		}
		return $htmlTable;
*/
}
?>
