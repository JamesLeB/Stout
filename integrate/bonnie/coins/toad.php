<style>
	img { border : solid 1px green; margin : 10px;}
	div { border : solid 1px blue; padding : 10px; margin : 10px;}
</style>
<?php

echo "Toads place<br/>";

echo "<div><h3>BTC Price</h3><img src='priceGraphs/btc.php'></div>";
echo "<div><h3>LTC Price</h3><img src='priceGraphs/ltc.php'></div>";
echo "<div><h3>DOGE Price</h3><img src='priceGraphs/doge.php'></div>";
echo "<div><h3>PTS Price</h3><img src='priceGraphs/pts.php'></div>";
#echo "<div><h3>QRK Price</h3><img src='priceGraphs/qrk.php'></div>";
echo "<div><h3>Delta</h3><img src='db.php'></div>";
echo "<div><h3>Volume</h3><img src='volume.php'></div>";
/*
	# Connect to DB
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);
	$a = array();
	$where = "where time like '%:00:00'";
	$rs = mysql_query("select date,time,ltc,doge,from btcvol $where order by date desc,time desc");
	$list = array();
	while($row = mysql_fetch_assoc($rs)){
		$date = $row{'date'};
		$time = substr($row{'time'},0,2);
		$ltc = $row{'ltc'};
		$doge = $row{'doge'};
		$pts = $row{'pts'};
		$list[] = $doge;
	}

function convert2percent($dataSET){
	# Convert price to percent change
	$set1 = array();
	$last = 0;
	foreach($dataSET as $data){
		$previous = $last;
		if($previous == 0){$previous = $data;}
		$change = ($data - $previous) / $previous * 100;
		$set1[] = $change;
		$last = $data;
	}
	return $set1;
}
*/
?>
