<?php
	$json = file_get_contents('http://data.bter.com/api/1/pairs');
	$list = json_decode($json,true);
	$rtn = array();
	$rtn[] = "First...Get list of trading pairs";
	$count = 0;
	foreach($list as $l){
		$count++;
		$rtn[] = "\t$l";
	}
	$rtn[] = "\t$count pairs";
	$rtn[] = "Second...Run list and get history";
	$rtn[] = "Third...Load trades into DB";
	$rtn[] = "Fourth...Create final report";
	echo implode("\n",$rtn);
?>