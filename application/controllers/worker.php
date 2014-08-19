<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

	public function index(){ echo "this is the index"; }

	public function test(){
		//$arg1 = $this->uri->segment(4);

		#file_put_contents('marketTrades.html',$json);
		$echo = array();
		$echo[] = 'Outlander';

		$heading = array('one','two');
		$mArray = array();


		$json = file_get_contents('https://api.mintpal.com/v1/market/trades/LTC/BTC');
		$obj = json_decode($json,true);
	
		$count = $obj['count'];
		$echo[] = "Count $count";
	
		$trades = $obj['trades'];
	
		$echo[] = 'Trade Keys:';
		$keys = array_keys($trades[0]);
		foreach($keys as $key){
			$echo[] = "$key";
		}
	
/*
		foreach($trades as $trade){
			$echo[] = "$trade";
		}
*/

		$msg = '';
		foreach($echo as $e){
			$msg .= "$e<br/>";
		}
		echo $msg;
/*
		$jamie = renderTable($aa,$bb);
		echo $jamie;
*/
	}
}

?>
