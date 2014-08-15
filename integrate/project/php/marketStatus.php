<?php
	//Echo "cross browser workaround";
	$json = file_get_contents('https://api.mintpal.com/v1/market/stats/LTC/BTC');
	file_put_contents('marketStatus.html',$json);
	echo "$json";
?>
