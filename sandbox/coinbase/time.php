<?php
	require_once('trader.php');
	$trader = new trader();
	$accounts = $trader->getAccounts();
	$book     = $trader->getOrderBook();
	$orders   = $trader->getOpenOrders();
	$openBids = $trader->checkOpenBids();
	echo json_encode(array(
		'status' => 'running',
		'accounts' => $accounts,
		'book' => $book,
		'orders' => $orders,
		'openBids' => $openBids
	));
?>
