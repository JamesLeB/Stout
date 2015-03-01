<?php

	$status    = "Default";
	$market    = "Market";
	$accounts  = "Accounts"; 
	$trades    = "Trades";
	$orderBook = "OrderBook";
	$orders    = "Orders";

require_once('trader.php');

$trader = new trader();


$action = $_POST['action'];
$r = '';
switch($action)
{
	case 'ONE':
		$status = "Do one";
		$accounts  = $trader->getAccounts('');#"Accounts";
		break;
	case 'BID':
		$status    = "PLACE BID";
		$market    = '';
		#$accounts  = 'getting USD available';
		$accounts  = "USD Available: ".$trader->getAccounts('usda');
		$trades    = '';
		$orderBook = $trader->getOrderBook('');
		$orders    = $trader->placeOrder('bid');
		break;
	case 'ASK':
		$status = "PLACE ASK";
		$market    = '';
		#$accounts  = 'getting USD available';
		#$accounts  = "BTC Available: ".$trader->getAccounts('');
		$trades    = '';
		$orderBook = $trader->getOrderBook('');
		$orders    = $trader->placeOrder('ask');
		#$market    = $trader->getMarket();#"Market";
		#$trades    = $trader->getTrades();#"Trades";
		break;
	case 'DB':
		//$orders = $trader->testDB();
		break;
}

echo json_encode(array(
	$status,
	$market,
	$accounts,
	$trades,
	$orderBook,
	$orders
));

?>
