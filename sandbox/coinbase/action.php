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
	);
	require_once('trader.php');
	$trader = new trader();
	return $trader->placeOrder($order);
}
function newAsk($json)
{
	$obj = json_decode($json,true);
	$order = array(
		'side'       => 'sell',
		'size'       => $obj['size'],
		'price'      => $obj['price'],
		'product_id' => $obj['product'],
	);
	require_once('trader.php');
	$trader = new trader();
	return $trader->placeOrder($order);
}
function createTable()
{
	require_once('trader.php');
	$trader = new trader();
	return $trader->createTable();
}
function cancelOrder($id)
{
	require_once('trader.php');
	$trader = new trader();
	return $trader->cancelOrder($id);
}
function runOrderTable()
{
	require_once('trader.php');
	$trader = new trader();
	return $trader->runOrderTable();
}

require_once('trader.php');
$trader = new trader();

$rtn = 'default';
$func = $_POST['func'];
$json = $_POST['json'];

switch($func)
{
	case 'newBid':
		$rtn = newBid($json);
		break;
	case 'newAsk':
		$rtn = newAsk($json);
		break;
	case 'createTable':
		$rtn = createTable();
		break;
	case 'cancelOrder':
		$obj = json_decode($json,true);
		$rtn = cancelOrder($obj['bidId']);
		break;
	case 'runOrderTable':
		$rtn = runOrderTable();
		break;
	case 'getBalances':
		$a = $trader->getAccounts();
		$b = array($a['usdBalance'],$a['btcBalance']);
		$rtn = json_encode($b);
		break;
	case 'getOrders':
		$a = $trader->getOrders();
		$rtn = json_encode($a);
		break;
}

echo $rtn;

?>
