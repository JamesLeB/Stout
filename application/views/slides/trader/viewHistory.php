<?php
	$keys = array_keys($history[0]);
	$html = "";
	$html .= "<table id='bterHistory'>";
	$html .= "<thead'>";
	$html .= "<tr>";
	foreach($keys as $key)
	{
		$html .= "<th>$key</th>";
	}
	$html .= "</tr>";
	$html .= "</thead'>";
	$html .= "<tbody'>";
	foreach($history as $line){
		$html .= "<tr>";
		foreach($keys as $key)
		{
			$html .= "<td>".$line[$key]."</td>";
		}
		$html .= "</tr>";
	}
	$html .= "</tbody'>";
	$html .= "</table>";
	$style = "
		<style>
			#bterHistory
			{
				margin-left : 30px;
				margin-top  : 30px;
				border-spacing : 5px;
			}
			#bterHistory th
			{
				background : green;
				color : white;
				padding : 5px;
			}
			#bterHistory td
			{
				background : lightgray;
				padding : 5px;
			}
		</style>
	";
//$html = $history;
	echo $html.$style;
?>
