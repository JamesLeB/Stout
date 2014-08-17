<?php
	#Echo "cross browser workaround";
	$json = file_get_contents('https://api.mintpal.com/v1/market/trades/LTC/BTC');
	$obj = json_decode($json,true);
	$keys = array_keys($obj);
	foreach($keys as $key){
		echo "$key<br/>";
	}
	#file_put_contents('marketTrades.html',$json);
?>
