<?php
	//Echo "cross browser workaround";
	$json = file_get_contents('https://api.mintpal.com/v1/market/orders/LTC/BTC/BUY');
	file_put_contents('marketBuyOrders.html',$json);
	echo "$json";
?>
