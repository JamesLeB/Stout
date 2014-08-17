<?php
	$mydate = date('Y-m-d'); $mytime = date('H:i');
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);
	$rs = mysql_query("
		insert into btcvol (date,time) values ('$mydate','$mytime')
	");
	$json = file_get_contents('http://data.bter.com/api/1/tickers');
	$a = json_decode($json,true);
	$keys = array_keys($a);
	foreach($keys as $key){
		$k = explode('_',$key);
		$coin = $k[0];
		$reserv = $k[1];
		if($reserv == 'btc'){
			$data = $a{$key}{'vol_btc'};
			$rs = mysql_query("
				update btcvol set $coin=$data where date = '$mydate' and time = '$mytime'
			");
		}
	}
	echo "loaded btc volumn data at $mydate $mytime\n";
?>
