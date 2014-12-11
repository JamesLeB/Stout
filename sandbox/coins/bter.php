<?php
	include("localdb.php");
	$db = new localdb();
	#$db->execute(1);
	# Get Current History Table
	$currentHistoryTable = "Current History Table";
	if(1){
		$tradesJson = "";
		if(1){
			$tradesJson = file_get_contents('http://data.bter.com/api/1/trade/btc_cny');
			file_put_contents('bter.json',$tradesJson);
		}else{
			$tradesJson = file_get_contents('bter.json');
		}
		$tradesObj = JSON_decode($tradesJson,true);
		$tradeData = $tradesObj['data'];
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
			# Add record to html table
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
		}
		$currentHistoryTable .= "</tbody></table>";
	}
	# END Get Current History Table
	# Get Data from MYSQL
	$mysqlData = "MYSQL Data";
	# END Get Data from MYSQL
?>
<div id='wrapper'>
	<div id="currentHistory"><?php echo $currentHistoryTable; ?></div>
	<div id="mysqlData"><?php echo $mysqlData; ?></div>
</div>
<style>
	#wrapper{
		border : 1px gray solid;
		width : 1200px;
		margin-left : auto;
		margin-right : auto;
		margin-top : 30px;
		padding : 20px;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
		font-size : 24px;
		height : 500px;
		position : relative;
	}
	#wrapper > div{
		border : 1px inset gray;
		margin : 10px;
		position : absolute;
		height : 400px;
		padding : 5px;
		overflow : auto;
	}
	#currentHistory{
		width : 900px;
	}
	#mysqlData{
		left : 950px;
		width : 200px;
	}
	table td{
		padding : 10px;
	}
	tbody td{
		background : lightgray;
	}
	thead td{
		background : green;
		color : white;
		font-weight : bold;
		text-align : center;
	}
	.label{
		Font-size : 30px;
	}
</style>
