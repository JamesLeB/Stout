<?php
	# Get Current History Table
	$currentHistoryTable = "Current History Table";
	if(1){
		$tradesJson = file_get_contents('http://data.bter.com/api/1/trade/btc_cny');
		$tradesObj = JSON_decode($tradesJson,true);
		$tradeData = $tradesObj['data'];
		$currentHistoryTable = "
			<div class='label'>History</div>
			<table>
				<thead>
					<tr>
						<td>Timestamp</td>
						<td>Price</td>
						<td>Amount</td>
						<td>Tid</td>
						<td>Type</td>
						<td>Date</td>
					</tr>
				</thead>
				<tbody>
		";
		foreach($tradeData as $trade){
			$timeStamp = $trade['date'];
			$price     = $trade['price'];
			$amount    = $trade['amount'];
			$tid       = $trade['tid'];
			$type      = $trade['type'];
			$data      = date('Y-m-d H:i:s',$trade['date']);
			$currentHistoryTable .= "
				<tr>
					<td>$timeStamp</td>
					<td>$price</td>
					<td>$amount</td>
					<td>$tid</td>
					<td>$type</td>
					<td>$data</td>
				</tr>
			";
		}
		$currentHistoryTable .= "</tbody></table>";
	}
	# END Get Current History Table
	# Get Data from MYSQL
	$mysqlData = "MYSQL Data";
	if(1){
		$c = file_get_contents('../../files/james');
		$c = preg_split('/\s/',$c);
		$user = $c[0];
		$pass = $c[1];
		$db   = $c[2];
		$link = mysqli_connect('localhost',$user,$pass,$db);
		$m = array();
		if($link){
			$m[] = 'Columns';
			$query = "drop table bter";
			$result = $link->query($query);
			$query = "create table bter (
				time_stamp int,
				price float,
				amount float,
				tid int,
				type varchar(8),
				date datetime
			)";
			$result = $link->query($query);
			$query = "show columns from bter";
			$result = $link->query($query);
			while($row = mysqli_fetch_array($result)){
				$m[] = $row[0]." ".$row[1];
			}
			mysqli_close($link);
		}else{
			$m[] = 'Connection Failed';
		}
		$m = implode('<br/>',$m);
		$mysqlData = $m;
	}
	# END Get Data from MYSQL
?>
<div id='wrapper'>
	<div id="currentHistory"><?php echo $currentHistoryTable; ?></div>
	<div id="mysqlData"><?php echo $mysqlData; ?></div>
</div>
<style>
	#wrapper{
		border : 1px gray solid;
		width : 1000px;
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
		width : 700px;
	}
	#mysqlData{
		left : 750px;
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
