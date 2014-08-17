<html>
<head>
	<link href='style.css' rel='stylesheet'>
</head>
<body>
<!--
	<div>
			<img id='growth' src="db.php">
			<img src="priceGraphs/zet.php">
	</div>
	<div class='coin'>
		btc
		<div class='price'>
			<img src="priceGraphs/btc.php">
		</div>
	</div>
--!>
	<div>Ticker</div>
	<div>Ask n Bid</div>
	<div>History</div>
	<div id='list'>
		<?php
			#showCoinData();
			getCoins();
			function showCoinData(){
				$json1 = file_get_contents('http://data.bter.com/api/1/ticker/ltc_btc');
				$json2 = file_get_contents('http://data.bter.com/api/1/depth/ltc_btc');
				$json3 = file_get_contents('http://data.bter.com/api/1/trade/ltc_btc');
				echo "---------------------------------<br/>";
				$c = json_decode($json3,true);
				$keys3 = array_keys($c);
				foreach($keys3 as $key){
					$data = $c{$key};
					echo "$key :: $data<br/>";
				}
				echo "---------------------------------<br/>";
$count = 1;
				$history = $c{'data'};
				foreach($history as $trade){
					$z = array_keys($trade);
					foreach($z as $x){echo "$x::";}
$date = $trade{'date'};
$price = $trade{'price'};
$amount = $trade{'amount'};
$tid = $trade{'tid'};
$type = $trade{'type'};
$what = $trade{'Array'};
					echo "$trade - $count";
					echo ":: $date";
					echo ":: $price";
					echo ":: $amount";
					echo ":: $tid";
					echo ":: $type";
					echo ":: $what";
					echo "<br/>";
					$count++;
				}
				echo "---------------------------------<br/>";
				$a = json_decode($json1,true);
				$keys1 = array_keys($a);
				foreach($keys1 as $key){
					$data = $a{$key};
					echo "$key :: $data<br/>";
				}
				echo "---------------------------------<br/>";
				#echo "$json2<br/>";
				#echo "---------------------------------<br/>";
				$b = json_decode($json2,true);
				$keys2 = array_keys($b);
				foreach($keys2 as $key){
					$data = $b{$key};
					echo "$key :: $data<br/>";
				}
				echo "---------------------------------<br/>";
				$bids = $b{'bids'};
				foreach($bids as $bid){
					$val1 = $bid[0];
					$val2 = $bid[1];
					echo "$val1 :: $val2<br/>";
				}
				echo "---------------------------------<br/>";
			}
			function getCoins(){
				$json = file_get_contents('http://data.bter.com/api/1/tickers');
				$a = json_decode($json,true);
				$keys = array_keys($a);
				$hash = $a{'ltc_btc'};
				$hashkeys = array_keys($hash);
				foreach($hashkeys as $key){
					echo "$key : ";
				}
				foreach($keys as $line){
					$pairs = explode('_',$line);
					$top = $pairs[0];
					$bot = $pairs[1];
					if($bot == 'btc'){
						echo "<div class='coin'>";
						echo "$top<br/>";
						$name = getName($top);
						#echo "<div class='name'>$name</div>";
						echo "<div class='price'><img src='priceGraphs/$top.php'></div>";
						echo "</div>";
					}
				}
			}
			function getName($x){
				$name = 'default';
				if($x == 'ltc'){
					$name = 'Litecoin';
				}
				return $name;
			}
		?>
	</div>
</body>
