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
	$check   = 0;
	$errors  = 0;
	foreach($list as $l){
		$count++;
		$obj = $bter->uploadBterData($l);
		$records += $obj['records'];
		$check   += $obj['check'];
		$errors  += $obj['errors'];
		#$rtn[] = "\t$l";
	}
	$rtn[] = "\tPairs loaded: $count";

	$rtn[] = "Final report";
	$endTime = time();
	$sd = date('Y-m-d',$startTime);
	$st = date('H:i:s',$startTime);
	$et = date('H:i:s',$endTime);
	$rtn[] = "\tS Time : $st";
	$rtn[] = "\tE Time : $et";
	$rtn[] = "\tRecords loaded: $records";
	$rtn[] = "\tRecords added: $check";
	$rtn[] = "\tErrors found: $errors\n";
	$report = "Loadbter Report $sd $st - $et Records:$records Added:$check Errors:$errors\n";
	file_put_contents('logs/loadbter',$report,FILE_APPEND);
	echo implode("\n",$rtn);
?>
