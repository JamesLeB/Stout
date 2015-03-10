<?php
	require_once('trader.php');
	$trader = new trader();
	$book     = $trader->getOrderBook();
	$orders   = $trader->getOrders();
	$debug = '';

	$openBuys  = array();
	$openSells = array();
	$zOrders = array();
	foreach($orders as $order)
	{
		if($order['type'] == 'buy'){ $openBuys[] = $order; }
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

		if(1)
		{
			$buy = array_shift($openBuys);
			$avail = $buy['size'] - $buy['sold'];
			if($balance == $avail)
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
/*
*/

	echo json_encode(array(
		'book' => $book,
		'orders' => $zOrders,
		'debug' => $debug
	));
?>
