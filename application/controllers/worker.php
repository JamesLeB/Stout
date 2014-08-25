<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

	public function index(){ echo "this is the index"; }

	public function getMarket(){
		#file_put_contents('marketTrades.html',$json);

		$incoming = $this->uri->segment(3);

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
			#$row[] = $trade['time'];
			$row[] = date('Y-m-d H:i:s',$trade['time']);
			#$row[] = $trade['type'];
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
}

?>
