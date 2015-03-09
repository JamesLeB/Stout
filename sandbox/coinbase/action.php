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
function cancelBid($id)
{
	require_once('trader.php');
	$trader = new trader();
	return $trader->cancelOrder($id);
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
	case 'cancelBid':
		$obj = json_decode($json,true);
		$rtn = cancelBid($obj['bidId']);
		break;
}

echo $rtn;

?>
