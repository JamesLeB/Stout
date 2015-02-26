<?php

# GET config file
$config = file_get_contents('secret');
$config = preg_split('/\s/',$config);
$path = 'https://api.exchange.coinbase.com';

# Get Market stats
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $path.'/products/BTC-USD/stats');
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

$result = curl_exec($curl);

# Get Trade History
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $path.'/products/BTC-USD/trades');
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

$trades = curl_exec($curl);
$obj = json_decode($trades,true);
$keys = array_keys($obj[0]);
$tradeTable .= '<table>';
$tradeTable .= '<tr>';
$tradeTable .= "<td>index</td>";
$tradeTable .= "<td>time</td>";
$tradeTable .= "<td>trade_id</td>";
$tradeTable .= "<td>price</td>";
$tradeTable .= "<td>size</td>";
$tradeTable .= "<td>side</td>";
$tradeTable .= '</tr>';
$count = 0;
$afterId;
foreach($obj as $trade)
{
	$time     = $trade['time'];
	$trade_id = $trade['trade_id'];
	$price    = $trade['price'];
	$size     = $trade['size'];
	$side     = $trade['side'];

$afterId = $trade_id;

	$tradeTable .= '<tr>';
	$count++;

	$tradeTable .= "<td>$count</td>";
	$tradeTable .= "<td>$time</td>";
	$tradeTable .= "<td>$trade_id</td>";
	$tradeTable .= "<td>$price</td>";
	$tradeTable .= "<td>$size</td>";
	$tradeTable .= "<td>$side</td>";

	$tradeTable .= '</tr>';
}
$tradeTable .= '</table>';

#####################################################################

curl_setopt($curl, CURLOPT_URL, $path."/products/BTC-USD/trades?after=$afterId");
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	"CB-BEFORE: 2"
));

$trades = curl_exec($curl);
$obj = json_decode($trades,true);
$keys = array_keys($obj[0]);
$tradeTable .= '<table>';
$tradeTable .= '<tr>';
$tradeTable .= "<td>index</td>";
$tradeTable .= "<td>time</td>";
$tradeTable .= "<td>trade_id</td>";
$tradeTable .= "<td>price</td>";
$tradeTable .= "<td>size</td>";
$tradeTable .= "<td>side</td>";
$tradeTable .= '</tr>';
$count = 0;
foreach($obj as $trade)
{
	$time     = $trade['time'];
	$trade_id = $trade['trade_id'];
	$price    = $trade['price'];
	$size     = $trade['size'];
	$side     = $trade['side'];

	$tradeTable .= '<tr>';
	$count++;

	$tradeTable .= "<td>$count</td>";
	$tradeTable .= "<td>$time</td>";
	$tradeTable .= "<td>$trade_id</td>";
	$tradeTable .= "<td>$price</td>";
	$tradeTable .= "<td>$size</td>";
	$tradeTable .= "<td>$side</td>";

	$tradeTable .= '</tr>';
}
$tradeTable .= '</table>';

$trades = $tradeTable;

$curl = curl_close();

#####################################################################

#  Get Account Balances
$url = '/accounts';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $path.$url);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

# create signature
$timestamp = time();
$method = 'GET';
$body = '';
#$body = json_encode($body);
$what = $timestamp.$method.$url.$body;

$signature = base64_encode(hash_hmac("sha256",$what, base64_decode($config[0]), true));

curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	"CB-ACCESS-KEY: $config[1]",
	"CB-ACCESS-SIGN: $signature",
	"CB-ACCESS-TIMESTAMP: $timestamp",
	"CB-ACCESS-PASSPHRASE: $config[2]"
));
$balances = curl_exec($curl);

$obj = json_decode($balances,true);

$usdBalance = 0;
$usdHold = 0;
$usdAvailable = 0;

$btcBalance = 0;
$btcHold = 0;
$btcAvailable = 0;

$james = gettype($obj);
$html = '';

foreach($obj as $account)
{
	if($account['currency'] == 'USD')
	{
		$usdBalance = $account['balance'];
		$usdHold = $account['hold'];
		$usdAvailable = $account['available'];
	}
	if($account['currency'] == 'BTC')
	{
		$btcBalance = $account['balance'];
		$btcHold = $account['hold'];
		$btcAvailable = $account['available'];
	}
}

$myAccounts = array();
$myAccounts[] = "-----------------";
$myAccounts[] = "Account Report";
$myAccounts[] = "-------";
$myAccounts[] = "USD Balance: $usdBalance";
$myAccounts[] = "USD Hold: $usdHold";
$myAccounts[] = "USD Available: $usdAvailable";
$myAccounts[] = "-------";
$myAccounts[] = "BTC Balance: $btcBalance";
$myAccounts[] = "BTC Hold: $btcHold";
$myAccounts[] = "BTC Available: $btcAvailable";
$myAccounts[] = "-------";

$myAccounts = implode('<br/>',$myAccounts);

echo json_encode(array(
	$result,
	$myAccounts,
	$trades,
	'order',
	'last'
));

?>
