<?php
	$startTime = time();
	include("bter.php");
	$rtn = array();
	$bter = new bter();
	$json = file_get_contents('http://data.bter.com/api/1/pairs');
	$list = json_decode($json,true);
	$rtn[] = "First...Get list of trading pairs";
	$pairs = count($list);
	$rtn[] = "\t$pairs pairs";

	$rtn[] = "Second...Load trades into DB";
	$count   = 0;
	$records = 0;
	$errors  = 0;
	foreach($list as $l){
		$count++;
		$obj = $bter->uploadBterData($l);
		$records += $obj['records'];
		$errors  += $obj['errors'];
	}
	$rtn[] = "\t$count pairs loaded";

	$rtn[] = "Third...Create final report";
	$endTime = time();
	$st = date('Y-m-d H:i:s',$startTime);
	$et = date('Y-m-d H:i:s',$endTime);
	$rtn[] = "\tS Time : $st";
	$rtn[] = "\tE Time : $et";
	$rtn[] = "\tRecords: $records";
	$rtn[] = "\tErrors: $errors";
	echo implode("\n",$rtn);
?>
