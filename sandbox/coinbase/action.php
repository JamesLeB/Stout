<?php

#$db->createTable();

function newBid($json)
{
	$obj = json_decode($json,true);
	$order = array(
		'side'       => 'buy',
		'size'       => $obj['size'],
		'price'      => $obj['price'],
		'product_id' => $obj['product'],
		'USD'        => $obj['usd'],
		'BTC'        => $obj['btc'],
		'spread'     => $obj['spread'] 
	);

	$ms = 'New Bid';
	require_once('trader.php');
	$trader = new trader();
	$ms .= "<br/>".$trader->placeOrder('bid',$order);

	return $ms;
}
function createTable()
{
	require_once('trader.php');
	$trader = new trader();
	return $trader->createTable();
}
$rtn = 'default';
$func = $_POST['func'];
$json = $_POST['json'];
switch($func)
{
	case 'newBid':
		$rtn = newBid($json);
		break;
	case 'createTable':
		$rtn = createTable();
		break;
}

echo $rtn;

?>
