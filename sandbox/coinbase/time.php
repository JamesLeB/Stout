<?php
	require_once('trader.php');
	$trader = new trader();
	$accounts = $trader->getAccounts();
	$book     = $trader->getOrderBook();
	echo json_encode(array(
		'status' => 'running',
		'accounts' => $accounts,
		'book' => $book
	));
?>
