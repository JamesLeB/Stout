<?php
	//Echo "cross browser workaround";
	$json = file_get_contents('https://api.mintpal.com/v1/market/orders/LTC/BTC/SELL');
	file_put_contents('marketSellOrders.html',$json);
	echo "$json";
?>
