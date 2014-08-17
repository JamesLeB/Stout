<?php
	$mydate = date('Y-m-d');
	$mytime = date('H:i');
	$a = file_get_contents('http://data.bter.com/api/1/tickers');
	$b = json_decode($a,true);
	$keys = array_keys($b);
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);
	$rs = mysql_query("insert into bter
		(lineDate,lineTime) values ('$mydate','$mytime')"
	);
	foreach($keys as $line){
		$average = $b{$line}{'avg'};
		$pairs = explode('_',$line);
		$topC = $pairs[0];
		$botC = $pairs[1];
		if( $botC == 'btc' ){
			$rs = mysql_query("update bter set $topC=$average
				where lineDate ='$mydate'
				and lineTime = '$mytime'
			");
		}
	}
	# get btc price
	$jsonbtc = file_get_contents('https://coinbase.com/api/v1/prices/sell');
	$z = json_decode($jsonbtc,true);
	$btc_price = $z{'amount'};
	$rs = mysql_query("update bter set btc=$btc_price
		where lineDate='$mydate' and lineTime = '$mytime'
	");
	# end btc price
	echo "data loaded $mydate $mytime\n";
?>
