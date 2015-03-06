<?php
	require_once('trader.php');
	$trader = new trader();
	$accounts = $trader->getAccounts();
	echo json_encode(array(
		'status' => 'running',
		'accounts' => $accounts
	));
?>
