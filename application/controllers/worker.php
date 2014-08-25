<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

	public function index(){ echo "this is the index"; }

	public function test(){
		#$arg1 = $this->uri->segment(4);
		#file_put_contents('marketTrades.html',$json);

		$echo = array();
		$echo[] = 'Outlander';

		$json = file_get_contents('https://api.mintpal.com/v1/market/trades/LTC/BTC');
		$obj = json_decode($json,true);
	
		$count = $obj['count'];
		$echo[] = "Count $count";
	
		$trades = $obj['trades'];
	
		$heading = array('id');
		$keys = array_keys($trades[0]);
		foreach($keys as $key){ $heading[] = $key; }
		$heading[] = 'test';
	
		$rows = array();
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
			$rows[] = $row;
		}

		$echo[] = renderTable($heading,$rows);

		$msg = '';
		foreach($echo as $e){
			$msg .= "$e<br/>";
		}
		echo $msg;

	}
}

?>
