<?php
	//Echo "cross browser workaround";
	$json = file_get_contents('https://api.mintpal.com/v1/market/trades/LTC/BTC');
	file_put_contents('marketTrades.html',$json);
	echo "$json";
?>
