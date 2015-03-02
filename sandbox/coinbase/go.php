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
	case 'STATUS':
		$status = "Getting Status";
		$aval  = $trader->getAccounts('available');
		$usd = $aval[0];
		$btc = $aval[1];
		$book = $trader->getOrderBook('book');
		$bidPrice = $book[0];
		$spread   = $book[1];
		$askPrice = $book[2];
		$market = "USD: $usd BTC: $btc";
		$accounts = "BID: $bidPrice SPREAD: $spread ASK: $askPrice";
		$trades = $trader->getOpenOrders();
		$orderBook = $trader->getLastBid();
		$orders = 'groot';
		break;
	case 'ONE':
		$status = "Do one";
		$accounts  = $trader->getAccounts('');#"Accounts";
		break;
	case 'BID':
		$status    = "PLACE BID";
		$aval  = $trader->getAccounts('available');
		$usd = $aval[0];
		$btc = $aval[1];
		$book = $trader->getOrderBook('book');
		$bidPrice = $book[0];
		$spread   = $book[1];
		$askPrice = $book[2];
		$market = "USD: $usd BTC: $btc";
		$accounts = "BID: $bidPrice SPREAD: $spread ASK: $askPrice";
		$j = $trader->placeOrder('bid');
		$trades    = $j[0];
		$orderBook = $j[1];
		$orders    = $j[2];
		break;
	case 'ASK':
		$status = "PLACE ASK";
		$aval  = $trader->getAccounts('available');
		$usd = $aval[0];
		$btc = $aval[1];
		$book = $trader->getOrderBook('book');
		$bidPrice = $book[0];
		$spread   = $book[1];
		$askPrice = $book[2];
		$market = "USD: $usd BTC: $btc";
		$accounts = "ASK: $bidPrice SPREAD: $spread ASK: $askPrice";
		$j = $trader->placeOrder('ask');
		$trades    = $j[0];
		$orderBook = $j[1];
		$orders    = $j[2];
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
