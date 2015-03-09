<?php
	require_once('trader.php');
	$trader = new trader();
	$accounts = $trader->getAccounts();
	$book     = $trader->getOrderBook();
	$orders   = $trader->getOpenOrders();
	echo json_encode(array(
		'status' => 'running',
		'accounts' => $accounts,
		'book' => $book,
		'orders' => $orders
	));
?>
