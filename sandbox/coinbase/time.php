<?php
	require_once('trader.php');
	$trader = new trader();
	$book     = $trader->getOrderBook();
	$orders   = $trader->getOrders();

	echo json_encode(array(
		'book' => $book,
		'orders' => $orders
	));
?>
