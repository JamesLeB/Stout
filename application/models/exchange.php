<?php
class Exchange extends CI_Model{

	#private $db;

	function __construct(){
		parent::__construct();
		#$this->db = $this->load->database('dentrix',true);
	}
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
