<?php
	set_time_limit(6000);
	$startTime = time();
	include("bter.php");
	$rtn = array();
	$bter = new bter();

	$rtn[] = "\nGet list of trading pairs";
	#$json = file_get_contents('http://data.bter.com/api/1/pairs');
	$list = array('btc_usd');#json_decode($json,true);
	$pairs = count($list);
	$rtn[] = "\tPairs retrieved: $pairs";

	$rtn[] = "Load trade history";
	$count   = 0;
	$records = 0;
	$errors  = 0;
	foreach($list as $l){
		$count++;
		$obj = $bter->uploadBterData($l);
		$records += $obj['records'];
		$errors  += $obj['errors'];
		#$rtn[] = "\t$l";
	}
	$rtn[] = "\tPairs loaded: $count";

	$rtn[] = "Final report";
	$endTime = time();
	$st = date('H:i:s',$startTime);
	$et = date('H:i:s',$endTime);
	$rtn[] = "\tS Time : $st";
	$rtn[] = "\tE Time : $et";
	$rtn[] = "\tRecords loaded: $records";
	$rtn[] = "\tErrors found: $errors\n";
	echo implode("\n",$rtn);
?>
