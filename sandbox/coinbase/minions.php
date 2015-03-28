<?php
class minions
{
	private $x;

	public function __construct()
	{
	}
	public function loadMinions()
	{
		//$_SESSION['minions'] = [];
		$minions = [];
		for($i=1;$i<4;$i++)
		{
			$minion = array(
				'id'      => $i,
				'size'    => .01,
				'cost'    => 0.00,
				'price'   => 0.00,
				'orderId' => '00f',
				'state'   => 'Idle',
				'msg'     => 'Hmm',
				'order'   => []
			);
			$minions[] = $minion;
			//$_SESSION['minions'][] = $minion;
		}
		return $minions;
	}
	public function activateMinion($minionId)
	{
		if($_SESSION['minions'][$minionId-1]['state'] == 'Idle')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'Bid';
		}
		else if($_SESSION['minions'][$minionId-1]['state'] == 'Bid')
		{
			//$_SESSION['minions'][$minionId-1]['state'] = 'Idle';
		}
		else if($_SESSION['minions'][$minionId-1]['state'] == 'Bidding')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'Idle';
		}
		else if($_SESSION['minions'][$minionId-1]['state'] == 'OnBookB')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'xBid';
		}
	}
	public function loadOrders()
	{
		$order = $_SESSION['orders'];
		if(sizeof($order) > 0)
		{
			$_SESSION['minions'][0]['orderId'] = $order[0]['id'];
			$_SESSION['minions'][0]['size']    = $order[0]['size'];
			if($order[0]['side'] == 'buy')
			{
				$_SESSION['minions'][0]['cost']    = $order[0]['price'];
				$_SESSION['minions'][0]['state'] = 'OnBookB';
			}
			else
			{
				$_SESSION['minions'][0]['price']   = $order[0]['price'];
				$_SESSION['minions'][0]['state'] = 'OnBookS';
			}
		}
		return $_SESSION['orders'];
	}
	public function act()
	{
		require_once('exchange.php');
		$exchange = new exchange();

		$a = 'Ho';


		# GET HIGH BID
		$highBid = 0;
		$keys = array_keys($_SESSION['bookBids']);
		if(sizeof($keys) > 0)
		{
			rsort($keys);
			$highBid = $keys[0] - 100;
		}

		foreach($_SESSION['minions'] as $minion)
		{
			if($minion['state'] == 'Idle')
			{

				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Wating';
				$_SESSION['minions'][$minion['id']-1]['orderId'] = '';
				$_SESSION['minions'][$minion['id']-1]['cost'] = $highBid;
			}
			else if($minion['state'] == 'Bid')
			{

				# PLACING BID
				$size = .01;
				$side = 'buy';

				$thing = json_decode($exchange->placeOrder($size,$highBid,$side),true);
				$orderId = $thing['id'];
				
				$_SESSION['minions'][$minion['id']-1]['orderId'] = $orderId;
				$_SESSION['openOrders'][$orderId] = 'new';

				$_SESSION['minions'][$minion['id']-1]['state'] = 'Bidding';

				$_SESSION['minions'][$minion['id']-1]['cost'] = $highBid;
				
			}
			else if($minion['state'] == 'Bidding')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'fuck';
				$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookB';

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if($_SESSION['openOrders'][$oid] == 'open')
				{
					$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookB';
				}

			}
			else if($minion['state'] == 'OnBookB')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Climbing';
			}
##############################################################
			else if($minion['state'] == 'cBid')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'xCancel Bid';
				//$_SESSION['minions'][$minion['id']-1]['state'] = 'Idle';
				$_SESSION['debug'] = json_encode($_SESSION['openOrders']);
			}
##############################################################
			else if($minion['state'] == 'xBid')
			{
				$orderId = $_SESSION['minions'][$minion['id']-1]['orderId'];
				$a = $exchange->cancelOrder($orderId);
				$_SESSION['minions'][$minion['id']-1]['msg'] = $a;
				$_SESSION['minions'][$minion['id']-1]['state'] = 'cBid';
			}
			else
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Now what';
			}
		}
		//$a = json_encode($_SESSION['minions'][0]);
		//$_SESSION['minions'][$minion['id']-1]['state'] = 'xBid';
		return "$a : k";
	}
}
?>
