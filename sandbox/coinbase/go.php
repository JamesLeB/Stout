<?php
require_once('trader.php');
# GET config file

$trader = new trader();

$market    = $trader->getMarket();#"Market";
$accounts  = $trader->getAccounts();#"Accounts";
$trades    = $trader->getTrades();#"Trades";
$orderBook = "OrderBook";
$orders    = "Orders";

echo json_encode(array(
	$market,
	$accounts,
	$trades,
	$orderBook,
	$orders
));

/*
*/
?>
