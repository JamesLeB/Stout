<?php
class bter{
	private $db = '';
	public function __construct(){
		include("localdb.php");
		$this->db = new localdb();
		#$this->db->execute(1);
	}
	public function test(){
		return "hello from bter :)";
	}
	public function uploadBterData($pair){
		$obj = array();
		$obj['message'] = 'object message';
		$tradesJson = "";
		if(1){
			$tradesJson = file_get_contents("http://data.bter.com/api/1/trade/$pair");
			file_put_contents('bter.json',$tradesJson);
		}else{
			$tradesJson = file_get_contents('bter.json');
		}
		$tradesObj = JSON_decode($tradesJson,true);
		$tradeData = $tradesObj['data'];
		$obj['records'] = 0;
		$obj['errors'] = 0;
		foreach($tradeData as $trade){
			$obj['records']++;
			$timeStamp = $trade['date'];
			$price     = $trade['price'];
			$amount    = $trade['amount'];
			$tid       = $trade['tid'];
			$type      = $trade['type'];
			$date      = date('Y-m-d H:i:s',$trade['date']);
			# Insert record
			$nTrade = array(
				'pair'      => $pair,
				'timeStamp' => $timeStamp,
				'price'     => $price,
				'amount'    => $amount,
				'tid'       => $tid,
				'type'      => $type,
				'date'      => $date
			);
			$check = $this->db->insertBterTrade($nTrade);
			$match = $this->db->checkBterTrade($nTrade);
			if(!$match){
				$obj['errors']++;
				$tt = date('Y-m-d H:i');
				$abter = $this->db->getBterTrade($nTrade);
				$m = "\n\n**************************************************\n";
				$m .= "Bad Trade Error on $tt\n";
				$m .= "**************************************************\n\n";
				$m .= "Trade $tid does not match stored trade\n\n";
				$m .= "MYSQL - ";
				foreach($abter as $a){$m .= "$a : ";}
				$m .= "\n";
				$m .= "BTER  - ";
				$m .= "$pair : ";
				$m .= "$timeStamp : ";
				$m .= "$price : ";
				$m .= "$amount : ";
				$m .= "$type : ";
				$m .= "\n\n";
				file_put_contents('logs/errors',$m,FILE_APPEND);
			}
		} # END Trade Data loop
		return $obj;
	} # END Upload bter data
}
?>
