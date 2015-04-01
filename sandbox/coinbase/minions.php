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
		for($i=1;$i<=3;$i++)
		{
			$minion = array(
				'id'      => $i,
				'size'    => .01,
				'cost'    => 0.00,
				'price'   => 0.00,
				'orderId' => '',
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
			//$_SESSION['minions'][$minionId-1]['state'] = 'Flying';
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
		else if($_SESSION['minions'][$minionId-1]['state'] == 'OnBookA')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'xAsk';
		}
		else if($_SESSION['minions'][$minionId-1]['state'] == 'Flying')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'Ask';
			//$_SESSION['minions'][$minionId-1]['state'] = 'Idle';
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
				$_SESSION['minions'][0]['state'] = 'OnBookA';
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
			$highBid = $keys[0] - 0;
		}
		# GET LOW ASK 
		$highAsk = 0;
		$keys = array_keys($_SESSION['bookAsks']);
		if(sizeof($keys) > 0)
		{
			sort($keys);
			$highAsk = $keys[0] + 0;
		}

		foreach($_SESSION['minions'] as $minion)
		{
			if($minion['state'] == 'Idle')
			{

				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Wating';
				$_SESSION['minions'][$minion['id']-1]['orderId'] = '';
				$_SESSION['minions'][$minion['id']-1]['cost'] = $highBid;
				$_SESSION['minions'][$minion['id']-1]['price'] = 0;
			}
			else if($minion['state'] == 'Bid')
			{

				# PLACING BID
				$size = .01; # this should equal the minion size
				$side = 'buy';

				$thing = json_decode($exchange->placeOrder($size,$highBid,$side),true);
				$orderId = $thing['id'];
				
				$_SESSION['minions'][$minion['id']-1]['orderId'] = $orderId;
				$_SESSION['openOrders'][$orderId] = 'new';

				$_SESSION['minions'][$minion['id']-1]['state'] = 'Bidding';

				$_SESSION['minions'][$minion['id']-1]['cost'] = $highBid;
				
			}
			else if($minion['state'] == 'Flying')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Fly';
				$_SESSION['minions'][$minion['id']-1]['price'] = $highAsk;
				$_SESSION['minions'][$minion['id']-1]['state'] = 'Ask';
			}
			else if($minion['state'] == 'Ask')
			{

				# PLACING ASK 
				$size = .01; # this should equal the minion size
				$side = 'sell';

				$thing = json_decode($exchange->placeOrder($size,$highAsk,$side),true);
				$orderId = $thing['id'];
				
				$_SESSION['minions'][$minion['id']-1]['orderId'] = $orderId;
				$_SESSION['openOrders'][$orderId] = 'asking';

				$_SESSION['minions'][$minion['id']-1]['state'] = 'Asking';

				$_SESSION['minions'][$minion['id']-1]['price'] = $highAsk;
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Create Ask';
				
			}
			else if($minion['state'] == 'Asking')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Check Ask';

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'open')
				{
					$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookA';
				}
			}
			else if($minion['state'] == 'Bidding')
			{
				//$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookB';

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'open')
				{
					$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookB';
				}

			}
			else if($minion['state'] == 'OnBookB')
			{
				$_SESSION['debug'] = 'climb need book info';

				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Climbing';


########## WORK ZONE getting depth in book
/*
				$lastLine = 0;
				$depthCheck = 'NO';
				foreach($keys as $key)
				{
					$_SESSION['debug'] = "$key : $currentAsk";
					if( $key > $currentAsk){break;}
					$orderKeys = array_keys($_SESSION['bookAsks'][$key][4]);
					foreach($orderKeys as $cOrder)
					{
						$depth += $_SESSION['bookAsks'][$key][4][$cOrder];
						$lastLine = $key;
					}
				}
*/
				$currentBid = $_SESSION['minions'][$minion['id']-1]['cost'];
				$highBid = 0;
				$keys = array_keys($_SESSION['bookBids']);
				if(sizeof($keys) > 0)
				{
					rsort($keys);
					$highBid = $keys[0];
				}
				$spread = round($highBid - $currentBid,2);
				$depth = 0;

				$_SESSION['debug'] .= "<br/>
					Checking distance from top of bid<br/>
					Cost $currentBid<br/>
					Top $highBid<br/>
					spread $spread<br/>
					depth $depth<br/>
				";
/*
					lastLine $lastLine<br/>
					depthCheck $depthCheck
*/
########## WORK ZONE



				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'filled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'Flying';
				}
			}
			else if($minion['state'] == 'OnBookA')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Fishing';

########## WORK ZONE getting depth in book
				$currentAsk = $_SESSION['minions'][$minion['id']-1]['price'];
				$lowAsk = 0;
				$keys = array_keys($_SESSION['bookAsks']);
				if(sizeof($keys) > 0)
				{
					sort($keys);
					$lowAsk = $keys[0];
				}
				$spread = round($currentAsk - $lowAsk,2);
				$currentCost = $_SESSION['minions'][$minion['id']-1]['cost'];
				$profit = $lowAsk - $currentCost;
				$depth = 0;
				$lastLine = 0;
				$depthCheck = 'NO';
				foreach($keys as $key)
				{
					$_SESSION['debug'] = "$key : $currentAsk";
					if( $key > $currentAsk){break;}
					$orderKeys = array_keys($_SESSION['bookAsks'][$key][4]);
					foreach($orderKeys as $cOrder)
					{
						$depth += $_SESSION['bookAsks'][$key][4][$cOrder];
						$lastLine = $key;
					}
				}
				$_SESSION['debug'] .= "<br/>
					checking distance from bottom of ask<br/>
					price $currentAsk<br/>
					booktop $lowAsk<br/>
					spread $spread<br/>
					depth $depth<br/>
					lastLine $lastLine<br/>
					depthCheck $depthCheck<br/>
					profit $profit
				";
########## WORK ZONE
				if($depth > 1 && $spread > .01){$_SESSION['minions'][$minion['id']-1]['state'] = 'xAsk';}

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'filled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'PunchOut';
				}
			}
			else if($minion['state'] == 'PunchOut')
			{
				require_once('wsdb.php');
				$db = new wsdb();
				$test = $db->punchOut($_SESSION['minions'][$minion['id']-1]);
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'punch';
				$_SESSION['minions'][$minion['id']-1]['state'] = 'Punched';
			}
			else if($minion['state'] == 'Punched')
			{
				$_SESSION['minions'][$minion['id']-1]['cost'] = 0;
				$_SESSION['minions'][$minion['id']-1]['price'] = 0;
				$_SESSION['minions'][$minion['id']-1]['orderId'] = ''; 
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'all over';
				$_SESSION['minions'][$minion['id']-1]['state'] = 'Idle';
			}
/*
			$db->createTable();
*/
			else if($minion['state'] == 'cBid')
			{
				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'canceled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'Idle';
				}
			}
			else if($minion['state'] == 'xBid')
			{
				$orderId = $_SESSION['minions'][$minion['id']-1]['orderId'];
				$a = $exchange->cancelOrder($orderId);
				$_SESSION['minions'][$minion['id']-1]['msg'] = $a;
				$_SESSION['minions'][$minion['id']-1]['state'] = 'cBid';
			}
			else if($minion['state'] == 'xAsk')
			{
				$orderId = $_SESSION['minions'][$minion['id']-1]['orderId'];
				$a = $exchange->cancelOrder($orderId);
				$_SESSION['minions'][$minion['id']-1]['msg'] = $a;
				$_SESSION['minions'][$minion['id']-1]['state'] = 'cAsk';
			}
			else if($minion['state'] == 'cAsk')
			{
				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'canceled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'Flying';
					$_SESSION['minions'][$minion['id']-1]['orderId'] = '';
				}
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
