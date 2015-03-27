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
		else if($_SESSION['minions'][$minionId-1]['state'] == 'Climbing')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'Idle';
		}
	}
	public function act()
	{
		$a = 'Ho';
		foreach($_SESSION['minions'] as $minion)
		{
			if($minion['state'] == 'Idle')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Waiting';
			}
			else if($minion['state'] == 'Bid')
			{
				# GET HIGH BID
				$highBid = 0;
				$keys = array_keys($_SESSION['bookBids']);
				if(sizeof($keys) > 0)
				{
					rsort($keys);
					$highBid = $keys[0] - 100;
					$_SESSION['minions'][$minion['id']-1]['cost'] = $keys[0] + 0 - 100;
				}

				# PLACING BID
				require_once('exchange.php');
				$exchange = new exchange();
				$size = .01;
				$side = 'buy';
				$orderId = $exchange->placeOrder($size,$highBid,$side);

				$_SESSION['minions'][$minion['id']-1]['orderId'] = $orderId;
				$_SESSION['minions'][$minion['id']-1]['state'] = 'Climbing';
				
			}
			else
			{
				#$_SESSION['arcadia'] = $_SESSION['minions'][$minion['id']-1]['orderId'];
$kid = json_decode($_SESSION['arcadia'],true);
				$_SESSION['minions'][$minion['id']-1]['msg'] = $kid['id'];
			}
		}
		//$a = json_encode($_SESSION['minions'][0]);
		return "$a : k";
	}
}
?>
