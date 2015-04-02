<?php
class minions
{
	private $minionGo = false;

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
				'size'    => .05,
				'cost'    => 0.00,
				'price'   => 0.00,
				'orderId' => '',
				'state'   => 'Sleep',
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
		if($_SESSION['minions'][$minionId-1]['state'] == 'Sleep')
		{
			//$_SESSION['minions'][$minionId-1]['state'] = 'Flying';
			$_SESSION['minions'][$minionId-1]['state'] = 'Idle';
		}
		else if($_SESSION['minions'][$minionId-1]['state'] == 'Idle')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'Flying';
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
		$firstBidLine = [0,0];
		$keys = array_keys($_SESSION['bookBids']);
		if(sizeof($keys) > 0)
		{
			rsort($keys);
			$highBid = $keys[0] - 0;
			$kk = array_keys($_SESSION['bookBids'][$keys[0]][4]);
			foreach($kk as $jj)
			{
				$firstBidLine[0]++;
				$oid = $jj;
				if(isset($_SESSION['openOrders'][$oid]))
				{
					$firstBidLine[1]++;
				}
			}
		}

		# GET LOW ASK 
		$highAsk = 0;
		$firstAskLine = [0,0];
		$keys = array_keys($_SESSION['bookAsks']);
		if(sizeof($keys) > 0)
		{
			sort($keys);
			$highAsk = $keys[0] + 0;
			$kk = array_keys($_SESSION['bookAsks'][$keys[0]][4]);
			foreach($kk as $jj)
			{
				$firstAskLine[0]++;
				$oid = $jj;
				if(isset($_SESSION['openOrders'][$oid]))
				{
					$firstAskLine[1]++;
				}
			}
		}
		$bookSpread = round($highAsk - $highBid,2);

$minionJumpLog = $_SESSION['minionJumpLog'];
$a = json_encode($firstAskLine);
$b = json_encode($firstBidLine);
$c = json_encode($minionJumpLog);

#WORK ZONE
#$_SESSION['debug'] = "$a $b $c";

		foreach($_SESSION['minions'] as $minion)
		{
				#$_SESSION['debug'] = round($_SESSION['btcA'],8);
			if($minion['state'] == 'Idle')
			{

				$s = $highAsk - $highBid;
				$_SESSION['minions'][$minion['id']-1]['msg'] = $bookSpread;
				$_SESSION['minions'][$minion['id']-1]['orderId'] = '';
				$_SESSION['minions'][$minion['id']-1]['cost'] = $highBid;
				$_SESSION['minions'][$minion['id']-1]['price'] = $highAsk;
				$_SESSION['minions'][$minion['id']-1]['orderId'] = $this->minionGo;

				$chk3 = $bookSpread  >= .02 ? 'Y' : 'N';
				if($chk3 = 'Y')
				{
					if($this->minionGo)
					{
						$_SESSION['minions'][$minion['id']-1]['state'] = 'Bid';
					}
				}
			}
			else if($minion['state'] == 'Bid')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'check book';

				# PLACING BID
#WORK
				if(0 && $_SESSION['minionJumpLog'][0] == 0)
				{
					$size = $_SESSION['minions'][$minion['id']-1]['size'];
					$side = 'buy';
					$thing = json_decode($exchange->placeOrder($size,$highBid,$side),true);
					$orderId = $thing['id'];
					$_SESSION['minions'][$minion['id']-1]['orderId'] = $orderId;
					$_SESSION['openOrders'][$orderId] = 'new';
					$_SESSION['minions'][$minion['id']-1]['state'] = 'Bidding';
					$_SESSION['minions'][$minion['id']-1]['cost'] = $highBid;
				}
				else
				{
					$_SESSION['minions'][$minion['id']-1]['msg'] = 'GOOD MORING';
				}
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
				#$size = $_SESSION['minions'][$minion['id']-1]['size'];
				$_SESSION['debug'] = $_SESSION['btcA'];
				$size = round($_SESSION['btcA'],8);
				$side = 'sell';

				$thing = json_decode($exchange->placeOrder($size,$highAsk,$side),true);
				#$_SESSION['debug'] = json_encode($thing);
				$orderId = $thing['id'];
				
				$_SESSION['minions'][$minion['id']-1]['orderId'] = $orderId;
				$_SESSION['openOrders'][$orderId] = 'asking';

				$_SESSION['minions'][$minion['id']-1]['state'] = 'Asking';

				$_SESSION['minions'][$minion['id']-1]['price'] = $highAsk;
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Create Ask';
				
			}
			else if($minion['state'] == 'Asking')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Chck Ask';

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'open')
				{
					$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookA';
					$_SESSION['minionJumpLog'][3]--;
					$_SESSION['minionJumpLog'][2]++;
				}
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'filled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'PunchOut';
					$_SESSION['minions'][$minion['id']-1]['orderId'] = '';
					$_SESSION['minionJumpLog'][2]--;
					$_SESSION['minionJumpLog'][1]++;
				}
			}
			else if($minion['state'] == 'Bidding')
			{
				//$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookB';

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'open')
				{
					$_SESSION['minions'][$minion['id']-1]['state'] = 'OnBookB';
					$_SESSION['minionJumpLog'][1]--;
					$_SESSION['minionJumpLog'][0]++;
				}
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'filled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'Flying';
					$_SESSION['minionJumpLog'][0]--;
					$_SESSION['minionJumpLog'][3]++;
				}

			}
			else if($minion['state'] == 'OnBookB')
			{
				$currentBid = $_SESSION['minions'][$minion['id']-1]['cost'];
				$highBid = 0;
				$backSpread = 0;
				$keys = array_keys($_SESSION['bookBids']);
				if(sizeof($keys) > 0)
				{
					rsort($keys);
					$highBid = $keys[0];
					$backSpread = round($keys[0] - $keys[1],2);
				}
				//$_SESSION['debug'] = $backSpread;

				$spread = round($highBid - $currentBid,2);
				$depth = 0;

				$lastLine = 0;
				foreach($keys as $key)
				{
					if( $key <= $currentBid){break;}
					$orderKeys = array_keys($_SESSION['bookBids'][$key][4]);
					foreach($orderKeys as $cOrder)
					{
						$depth += $_SESSION['bookBids'][$key][4][$cOrder];
						$lastLine = $key;
					}
				}

				$chk1 = $spread      >= .001 ? 'Y' : 'N';
				$chk2 = $depth       >=  .1  ? 'Y' : 'N';
				$chk3 = $bookSpread  >= .01 ? 'Y' : 'N';
				$chk4 = $backSpread   > .01 ? 'Y' : 'N';
				$chk5 = 'G';

				$_SESSION['minions'][$minion['id']-1]['msg'] = $chk1.$chk2.$chk3.$chk4.$chk5;
				if(($chk1 == 'Y' && $chk2 == 'Y' && $chk3 == 'Y') || !$this->minionGo)
				{
					$_SESSION['minions'][$minion['id']-1]['state'] = 'xBid';
					$_SESSION['minionJumpLog'][0]--;
					$_SESSION['minionJumpLog'][1]++;
				}

/*
				$_SESSION['debug'] = "<br/>
					Checking distance from top of bid<br/>
					Cost $currentBid<br/>
					Top $highBid<br/>
					spread $spread<br/>
					depth $depth<br/>
				";
*/

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'filled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'Flying';
					$_SESSION['minionJumpLog'][0]--;
					$_SESSION['minionJumpLog'][3]++;
				}
			}
			else if($minion['state'] == 'OnBookA')
			{

				$currentAsk = $_SESSION['minions'][$minion['id']-1]['price'];
				$lowAsk = 0;
				$backSpread = 99;
				$keys = array_keys($_SESSION['bookAsks']);
				if(sizeof($keys) > 0)
				{
					sort($keys);
					$lowAsk = $keys[0];
					$backSpread = round($keys[1] - $keys[0],2);
				}
############ WORK ZONE
/*
$payload = json_encode($_SESSION['bookAsks'][$keys[0]]);
				$_SESSION['debug'] = "
						next task figure out how to jump back<br/>
						$payload<br/>
						How many orders on lowest rung?<br/>
						How many of those are mine?<br/>
					"; 
*/
############ WORK ZONE

				$spread = round($currentAsk - $lowAsk,2);
				$currentCost = $_SESSION['minions'][$minion['id']-1]['cost'];
				$profit = round($lowAsk - $currentCost,2);
				$depth = 0;
				$lastLine = 0;
				$depthCheck = 'NO';
				foreach($keys as $key)
				{
					#$_SESSION['debug'] = "$key : $currentAsk";
					if( $key >= $currentAsk){break;}
					$orderKeys = array_keys($_SESSION['bookAsks'][$key][4]);
					foreach($orderKeys as $cOrder)
					{
						$depth += $_SESSION['bookAsks'][$key][4][$cOrder];
						$lastLine = $key;
					}
				}

/*
				$_SESSION['debug'] = "<br/>
					checking distance from bottom of ask<br/>
					price $currentAsk<br/>
					booktop $lowAsk<br/>
					spread $spread<br/>
					depth $depth<br/>
					lastLine $lastLine<br/>
					depthCheck $depthCheck<br/>
					profit $profit
				";
*/

				$chk1 = $spread      > .001 ? 'Y' : 'N';
				$chk2 = $depth       >= 1  ? 'Y' : 'N';
				$chk3 = $bookSpread  > .001 ? 'Y' : 'N';
				# NOT SURE IF THIS IS A USEFUL CHECK
				$chk4 = $profit      >= .01 ? 'Y' : 'Y';
				$chk5 = $backSpread   > .01 ? 'Y' : 'N';


				$_SESSION['minions'][$minion['id']-1]['msg'] = $chk1.$chk2.$chk3.$chk4.$chk5;
				
				if($chk1 == 'Y' && $chk2 == 'Y' && $chk3 == 'Y' && $chk4 == 'Y')
				{
					$_SESSION['minions'][$minion['id']-1]['state'] = 'xAsk';
					$_SESSION['minionJumpLog'][2]--;
					$_SESSION['minionJumpLog'][3]++;
				}
				if($chk5 == 'Y')
				{
					#$_SESSION['minions'][$minion['id']-1]['state'] = 'xAsk';
				}

				$oid = $_SESSION['minions'][$minion['id']-1]['orderId'];
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'filled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'PunchOut';
					$_SESSION['minionJumpLog'][2]--;
					$_SESSION['minionJumpLog'][1]++;
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
/*
*/
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
				if(!isset($_SESSION['openOrders'][$oid]))
				{
					//$_SESSION['minions'][$minion['id']-1]['orderId'] = '';
					//$_SESSION['minions'][$minion['id']-1]['state'] = 'Idle';
				}
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'canceled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'Flying';
					$_SESSION['minions'][$minion['id']-1]['orderId'] = '';
				}
				if(isset($_SESSION['openOrders'][$oid]) && $_SESSION['openOrders'][$oid] == 'filled')
				{
					unset($_SESSION['openOrders'][$oid]);
					$_SESSION['minions'][$minion['id']-1]['state'] = 'PunchOut';
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
