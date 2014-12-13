<?php
	#$db->execute(1);
/*
	function historyTable(){
		$currentHistoryTable = "Current History Table";
		$currentHistoryTable = "
			<div class='label'>History</div>
			<table>
				<thead>
					<tr>
						<td>Index</td>
						<td>Timestamp</td>
						<td>Price</td>
						<td>Amount</td>
						<td>Tid</td>
						<td>Type</td>
						<td>Date</td>
						<td>Check</td>
						<td>Match</td>
					</tr>
				</thead>
				<tbody>
		";
			$currentHistoryTable .= "
				<tr>
					<td>$count</td>
					<td>$timeStamp</td>
					<td>$price</td>
					<td>$amount</td>
					<td>$tid</td>
					<td>$type</td>
					<td>$date</td>
					<td>$check</td>
					<td>$match</td>
				</tr>
			";
		$currentHistoryTable .= "</tbody></table>";
	} # END History table
*/
	# Get Current History Data
	function uploadBterData($pair){
		include("localdb.php");
		$db = new localdb();
		$tradesJson = "";
		if(1){
			$tradesJson = file_get_contents("http://data.bter.com/api/1/trade/$pair");
			file_put_contents('bter.json',$tradesJson);
		}else{
			$tradesJson = file_get_contents('bter.json');
		}
		$tradesObj = JSON_decode($tradesJson,true);
		$tradeData = $tradesObj['data'];
		$count = 0;
		foreach($tradeData as $trade){
			$count++;
			$timeStamp = $trade['date'];
			$price     = $trade['price'];
			$amount    = $trade['amount'];
			$tid       = $trade['tid'];
			$type      = $trade['type'];
			$date      = date('Y-m-d H:i:s',$trade['date']);
			# Insert record
			$nTrade = array(
				'timeStamp' => $timeStamp,
				'price'     => $price,
				'amount'    => $amount,
				'tid'       => $tid,
				'type'      => $type,
				'date'      => $date
			);
			$check = $db->insertBterTrade($nTrade);
			$match = $db->checkBterTrade($nTrade);
			if(!$match){
				$tt = date('Y-m-d H:i');
				$abter = $db->getBterTrade($nTrade);
				$m = "\n\n**************************************************\n";
				$m .= "Bad Trad Error on $tt\n";
				$m .= "**************************************************\n\n";
				$m .= "Trade $tid does not match stored trade\n\n";
				$m .= "MYSQL - ";
				foreach($abter as $a){$m .= "$a : ";}
				$m .= "\n";
				$m .= "BTER  - ";
				$m .= "$timeStamp : ";
				$m .= "$price : ";
				$m .= "$amount : ";
				$m .= "$type : ";
				file_put_contents('logs/errors',$m,FILE_APPEND);
			}
		}
	} # END Upload bter data
?>
