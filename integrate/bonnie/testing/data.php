<?php

	# Connect to DB
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);

	# Show date series
	$rs = mysql_query("select lineDate,lineTime from bter where lineTime = '00:00:00'");
	while($row = mysql_fetch_assoc($rs)){
		$date = $row{'lineDate'};
		$time = $row{'lineTime'};
		echo "$date : $time<br/>";
	}

##########################
	# Get price series
	$LTC = array();
	$rs = mysql_query("select ltc from bter where lineTime = '00:00:00'");
	while($row = mysql_fetch_assoc($rs)){
		$j = $row{'ltc'};
		$LTC[] = $row{'ltc'};
	}

	$stuff = convert2percent($LTC);
	showSeries($stuff);

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
########################

function showSeries($set){
	# Show change series
	echo "----------------<br/>";
	foreach($set as $i){
		echo "$i<br/>";
	}
}
	
?>
