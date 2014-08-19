<?php
	#file_put_contents('marketTrades.html',$json);
	$echo = array();
	$echo[] = 'Outlander';

	$aa = array('one','two');
	$bb = array('three','four');

	#$jamie = renderTable($aa,$bb);
	include("../lib/std.php");
	$jamie = testing();
	echo $jamie;

/*
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

	foreach($trades as $trade){
		$echo[] = "$trade";
	}
*/

	$msg = '';
	foreach($echo as $e){
		$msg .= "$e<br/>";
	}
	echo $msg;
?>
