<?php
	require_once('trader.php');
	$trader = new trader();
	$book     = $trader->getOrderBook();
	$orders   = $trader->getOrders();
	$accounts  = $trader->getAccounts();
	$debug = '';

	$openBuys  = array();
	$openSells = array();
	$zOrders = array();
	foreach($orders as $order)
	{
		if($order['type'] == 'buy') { $openBuys[]  = $order; }
		if($order['type'] == 'sell'){ $openSells[] = $order; }

		if($order['status'] == 'NEW')
		{
			$json = $trader->getOrderStatus($order['serverId']);
			$status = json_decode($json,true);
			//$order['status'] = $status['status'].'::'.$status['done_reason'];
			if($status['status'] == 'done' && $status['done_reason'] == 'filled')
			{
				$trader->updateOrderStatus($order['serverId'],'filled');
				$debug = "order filled";
			}
			else if($status['status'] == 'done' && $status['done_reason'] == 'canceled')
			{
				$trader->updateOrderStatus($order['serverId'],'canceled');
			}
		}
		$zOrders[] = $order;
	}
	foreach($openSells as $sell)
	{
		$balance = $sell['size'];
		$cost = 0;
		$price = $sell['price'];

		if($sell['status'] == 'filled') 
		{
			$buy = array_shift($openBuys);
			$avail = $buy['size'] - $buy['sold'];
			if($balance == $avail && $sell['status'] == 'filled')
			{
				$cost = $buy['price'];
				$trader->updateOrderSold($buy['id'],$buy['size']);
				$trader->updateOrderCost($buy['id'],0);
				$trader->updateOrderCost($sell['id'],$buy['price']);
				$profit = ($balance * $price) - ($balance * $cost);
				$trader->updateOrderProfit($sell['id'],$profit);

				$trader->updateOrderStatus($buy['serverId'],'sold');
				$trader->updateOrderStatus($sell['serverId'],'closed');

			}
		}
	}
	$btcCost = 0;
	$btcTotalValue = 0;
	$btcTotalSize = 0;
	foreach($openBuys as $buy)
	{
		if($buy['status'] == 'filled')
		{
			$btcCost = $buy['price'];
			$btcTotalValue += $buy['price'] * $buy['size'];
			$btcTotalSize += $buy['size'];
		}
	}
	if($btcTotalSize != 0){$btcCost = $btcTotalValue / $btcTotalSize;}
/*
*/

	echo json_encode(array(
		'book' => $book,
		'orders' => $zOrders,
		'accounts' => $accounts,
		'btcCost' => $btcCost,
		'debug' => $debug
	));
?>
