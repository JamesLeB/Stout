<?php
# GET config file
$config = file_get_contents('secret');
$config = preg_split('/\s/',$config);
$path = 'https://api.exchange.coinbase.com';

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $path.'/products/BTC-USD/stats');
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

$result = curl_exec($curl);

//  Get balances
$url = '/accounts';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $path.$url);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

// create signature
$timestamp = time();
$method = 'GET';
$body = '';
//$body = json_encode($body);
$what = $timestamp.$method.$url.$body;

$signature = base64_encode(hash_hmac("sha256",$what, base64_decode($config[0]), true));

curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	"CB-ACCESS-KEY: $config[1]",
	"CB-ACCESS-SIGN: $signature",
	"CB-ACCESS-TIMESTAMP: $timestamp",
	"CB-ACCESS-PASSPHRASE: $config[2]"
));
$balance = curl_exec($curl);

echo json_encode(array(
	$result,
	$balance,
	"Groot"
));

?>