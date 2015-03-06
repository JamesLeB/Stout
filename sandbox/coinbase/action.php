<?php

#$db->createTable();

function newBid($json)
{
	$obj = json_decode($json,true);
	require_once('database.php');
	$db = new database();
	$order = array(
		'side'       => 'buy',
		'size'       => $obj['size'],
		'price'      => $obj['price'],
		'product_id' => $obj['product'],
		'USD'        => $obj['usd'],
		'BTC'        => $obj['btc'],
		'spread'     => $obj['spread'] 
	);
	$ms = $db->saveOrder($order);

	require_once('trader.php');
	$ms .= "<br/>sending order to coinbase";

	return $ms;
}
$rtn = 'default';
$func = $_POST['func'];
$json = $_POST['json'];
switch($func)
{
	case 'newBid':
		$rtn = newBid($json);
		break;
}

echo $rtn;

?>
