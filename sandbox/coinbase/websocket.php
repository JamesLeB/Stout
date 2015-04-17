<?php
	session_start();
	$kara = '';
	$debug = '';
	$func = $_POST['func'];
	switch($func)
	{
		case 'startup':

			# DATABASE CONNECTION
			#require_once('wsdb.php'); $db = new wsdb(); $db->createPunchOut();

			# INITIALIZE SESSION VARS
			$_SESSION['count']        = 0;
			$_SESSION['lastCount']    = 0;
			$_SESSION['socketBuffer'] = [];
			$_SESSION['bookBids']     = [];
			$_SESSION['bookAsks']     = [];
			$_SESSION['bookSequence'] = 0;
			$_SESSION['bufferFirst']  = 0;
			$_SESSION['bufferLast']   = 0;
			$_SESSION['startLiveBook']= 0;
			$_SESSION['currentSequence']= 0;
			$_SESSION['msg']= 'hello';
			$_SESSION['orders'] = [];
			$_SESSION['debug'] = '';
			$_SESSION['openOrders'] = [];

			# LOAD MINIONS
			require_once('minions.php');
			$minions = new minions();
			$_SESSION['minions'] = $minions->loadMinions();
			$_SESSION['minionJumpLog'] = array(0,sizeof($_SESSION['minions']),0,0);
			$kara = $_SESSION['minions'];

			break;

		case 'clearDebug':

			$_SESSION['debug'] = '';
			$kara = 'Clear';
			
			break;
		case 'loadOrders':

			require_once('minions.php');
			$minions = new minions();
			$a = $minions->loadOrders();

			$kara = $a;

			break;

		case 'getOpenOrders':

			$_SESSION['debug'] = json_encode($_SESSION['openOrders']);
			break;

		case 'getOrders':


			require_once('exchange.php');
			$exchange = new exchange();
			$orders = json_decode($exchange->getOpenOrders(),true);
			$_SESSION['orders'] = $orders;
			$_SESSION['debug'] = json_encode($_SESSION['orders']);

			break;

		case 'activateMinion':

			require_once('minions.php');
			$minions = new minions();
			$minions->activateMinion($_POST['minionId']);
			$kara = "activate Minion: ".$_POST['minionId'];

			break;

		case 'getBalance':
			require_once('exchange.php');
			$exchange = new exchange();
			$balance = $exchange->getBalance();
			$b = json_decode($balance,true);
			$usdA = 0;
			$btcA = 0;
			foreach($b as $bb)
			{
				if($bb['currency'] == 'USD'){$usdA = $bb['available'];}
				if($bb['currency'] == 'BTC'){$btcA = $bb['available'];}
			}
			$kara = array($usdA,$btcA);
			$_SESSION['btcA'] = $btcA;
			break;

		case 'getBook':

			require_once('exchange.php');
			$exchange = new exchange();

			# GET ORDER BOOK
			$book = $exchange->getOrderBook();
			$book = json_decode($book,true);

			$_SESSION['bookSequence']=$book['sequence'];

			# LOAD BIDS
			$bookBids = [];
			foreach($book['bids'] as $order)
			{
				# Check for price line
				if(!isset($bookBids[$order[0]]))
				{
					# Add new price line
					$bookBids[$order[0]] = array('bid',$order[1],0,0,array($order[2] => $order[1]));
				}
				else
				{
					# Add order to price line
					$bookBids[$order[0]][4][$order[2]] = $order[1];
					$bookBids[$order[0]][1]  += $order[1];
				}
			}
			# Put Bid Book on session
			$_SESSION['bookBids'] = $bookBids;

			# LOAD ASKS
			$bookAsks = [];
			foreach($book['asks'] as $order)
			{
				# Check for price line
				if(!isset($bookAsks[$order[0]]))
				{
					# Add new price line
					$bookAsks[$order[0]] = array('ask',$order[1],0,0,array($order[2] => $order[1]));
				}
				else
				{
					# Add order to price line
					$bookAsks[$order[0]][4][$order[2]] = $order[1];
					$bookAsks[$order[0]][1] += $order[1];
				}
			}
			# Put Ask Book on session
			$_SESSION['bookAsks'] = $bookAsks;


			break;

# looks like this case is no longer used !!!
		case 'upload':

			$_SESSION['socketBuffer'][] = $_POST['message'];

			$fOrder = json_decode($_SESSION['socketBuffer'][0],true);
			$lOrder = json_decode($_POST['message'],true);

			$_SESSION['bufferFirst'] = $fOrder['sequence'];
			$_SESSION['bufferLast']  = $lOrder['sequence'];

			$kara = 'Loaded: '.++$_SESSION['count'].' : Buffer: '.sizeof($_SESSION['socketBuffer']);

			# SEND MESSAGE TO DATABASE
			#require_once('wsdb.php');
			#$db = new wsdb();
			#$db->upload($_POST['message']);

			break;

#############################################################
# STOPPED HERE !!!!!!!
##############################################################

		case 'syncBuffer':

			# FLUSH ORDERS BEFORE FULL BOOK SEQUENCE
			while( isset($_SESSION['socketBuffer'][0])
				&& ($_SESSION['bookSequence'] - $_SESSION['bufferFirst']) >= 0)
			{
				array_shift($_SESSION['socketBuffer']);
				$thing = $_SESSION['socketBuffer'][0];
				$thing = json_decode($thing,true);
				$_SESSION['bufferFirst'] = $thing['sequence'];
			}
			$_SESSION['startLiveBook'] = 1;

			break;

		case 'tick':
			$stopOrder = 0;
			$feedData = 'feed data';
			$matchedResult = array(0,0,'');

			$ct = 0;
			if(isset($_POST['payload']))
			{
				$payload = $_POST['payload'];
				$ct = sizeof($payload);
				foreach($payload as $message)
				{
					$_SESSION['socketBuffer'][] = $message;
				}
			}
			//$_SESSION['count'] += $ct;
			//$feedData  = 'msg ct: '.$_SESSION['count'];
			$feedData .= 'Buff sz: '.sizeof($_SESSION['socketBuffer']);

			$nextOrder = '';

			# reorder buffer
			function cmp($a,$b)
			{
				$a = json_decode($a,true);
				$b = json_decode($b,true);

				$a = $a['sequence'];
				$b = $b['sequence'];
				
				if($a == $b){ return 0; }
				return ($a < $b) ? -1 : 1;
			}
			if(isset($_SESSION['socketBuffer'][0]))
			{
				usort($_SESSION['socketBuffer'],"cmp");
				# trim buffer
				while(sizeof($_SESSION['socketBuffer']) > 200 && $_SESSION['startLiveBook'])
				{
					array_shift($_SESSION['socketBuffer']);
				}
				$fOrder = json_decode($_SESSION['socketBuffer'][0],true);
				$lOrder = json_decode($_SESSION['socketBuffer'][sizeof($_SESSION['socketBuffer'])-1],true);
				$_SESSION['bufferFirst'] = $fOrder['sequence'];
				$_SESSION['bufferLast']  = $lOrder['sequence'];
				$_SESSION['currentSequence'] = 0;
			}




			# Check to see if the buffer is empty
			if(
				isset($_SESSION['socketBuffer'][0]) &&
				$stopOrder == 0 &&
				$_SESSION['startLiveBook']
			)
			{
			foreach($_SESSION['socketBuffer'] as $nextOrder)
			{
				$o = json_decode($nextOrder,true);

				# CHECK for bad sequence
				$_SESSION['msg'] = 
					'Current: '.$o['sequence'].' '.
					'Last: '.$_SESSION['currentSequence'];
				
				if( $o['sequence'] - $_SESSION['currentSequence'] < 0 )
				{
					$_SESSION['msg'] = 'Bad sequence number '.$o['sequence'].' '.$_SESSION['currentSequence'];
					$stopOrder = 1;
					break;
				}
				$_SESSION['currentSequence'] = $o['sequence'];

				$type = $o['type'];
				switch($type)
				{
					case 'received':
						break;
					case 'done':

						$side    = $o['side'] == 'buy' ? 'bid' : 'ask';
						$price   = $o['price'];
						$orderI  = $o['order_id'];

						$priceX = $price;

						$check1 = 'Default';
						//$sampOrder = '';

						### Update open Orders
						$keys = array_keys($_SESSION['openOrders']);
						if(isset($_SESSION['openOrders'][$orderI]))
						{
							$_SESSION['openOrders'][$orderI] = $o['reason'];
						}
						###

						if($side == 'ask')
						{
							$check1 = 'ask side';

							# Check if price line AND order are on book
							if(isset($_SESSION['bookAsks'][$priceX]))
							{
								# Deleted order
								unset($_SESSION['bookAsks'][$priceX][4][$orderI]);
								$keys = array_keys($_SESSION['bookAsks'][$priceX][4]);
								# Check size of price line order hash
								if(sizeof($keys) == 0)
								{
									unset($_SESSION['bookAsks'][$priceX]);
								}
								else
								{
									# Update price line total
									$total = 0;
									foreach($keys as $key)
									{
										$total += $_SESSION['bookAsks'][$priceX][4][$key];
									}
									$_SESSION['bookAsks'][$priceX][1] = $total;
								}
							}
						}
						else
						{
							$check1 = 'bid side';

							# Check if price line AND order are on book
							if(isset($_SESSION['bookBids'][$priceX]))
							{
								# Deleted order
								unset($_SESSION['bookBids'][$priceX][4][$orderI]);
								$keys = array_keys($_SESSION['bookBids'][$priceX][4]);
								# Check size of price line order hash
								if(sizeof($keys) == 0)
								{
									unset($_SESSION['bookBids'][$priceX]);
								}
								else
								{
									# Update price line total
									$total = 0;
									foreach($keys as $key)
									{
										$total += $_SESSION['bookBids'][$priceX][4][$key];
									}
									$_SESSION['bookBids'][$priceX][1] = $total;
								}
							}
						}


						break;
					case 'open':
						$side    = $o['side'] == 'buy' ? 'bid' : 'ask';
						$price   = $o['price'];
						$orderI  = $o['order_id'];
						$size    = $o['remaining_size'];

						### Update open Orders
						$keys = array_keys($_SESSION['openOrders']);
						if(isset($_SESSION['openOrders'][$orderI]))
						{
							$_SESSION['openOrders'][$orderI] = 'open';
						}
						###

						if($side == 'ask')
						{
							//$priceX = '294.01000000';
							$priceX = $price;
							# Check for price Line
							if(isset($_SESSION['bookAsks'][$priceX]))
							{
								# Add order to price line
								$_SESSION['bookAsks'][$priceX][4][$orderI] = $size;
								# Update price line total
								$total = 0;
								$keys = array_keys($_SESSION['bookAsks'][$priceX][4]);
								foreach($keys as $key)
								{
									$total += $_SESSION['bookAsks'][$priceX][4][$key];
								}
								$_SESSION['bookAsks'][$priceX][1] = $total;
							}
							else
							{
								# Add new price line
								$_SESSION['bookAsks'][$priceX] = array($side,$size,0,0,array($orderI=>$size));
							}
						}
						else
						{
							//$priceX = '293.82000000';
							$priceX = $price;
							# Check for price Line
							if(isset($_SESSION['bookBids'][$priceX]))
							{
								# Add order to price line
								$_SESSION['bookBids'][$priceX][4][$orderI] = $size;
								# Update price line total
								$total = 0;
								$keys = array_keys($_SESSION['bookBids'][$priceX][4]);
								foreach($keys as $key)
								{
									$total += $_SESSION['bookBids'][$priceX][4][$key];
								}
								$_SESSION['bookBids'][$priceX][1] = $total;
							}
							else
							{
								# Add new price line
								$_SESSION['bookBids'][$priceX] = array($side,$size,0,0,array($orderI=>$size));
							}
						}
						
						break;

					case 'match':
						$a = "<br/>Maker id";
						$b = "<br/>Maker size";
						$c = "<br/>Match size";
						$d = "<br/>test";
						$matchedResult = array(1,1,$nextOrder.$a.$b.$c.$d);
						break;
					default:
				} # END SWITCH ON ORDER TYPE (recieved,open,done,match)
			} # END OF PROCESSING BUFFER
			} # END OF PROCESSING BUFFER ON close for if other for for each


############################ Minions  #################################

			require_once('minions.php');
			$minions = new minions();
			$minionActionReturn = $minions->act();


############################ End Minions  #############################





############################   CREATE LIVE BOOK #################################
			# CREATE LIVE BOOK
			$liveBook      = [];
			$liveBookDepth = 5;

			# Load asks onto live book
			$keys = array_keys($_SESSION['bookAsks']);
			sort($keys);
			$ct = 0;
			foreach($keys as $key)
			{
				if(++$ct > $liveBookDepth){ break; }
				$order = $_SESSION['bookAsks'][$key];
				$okeys = array_keys($order[4]);
				$orders = [];
				$myAsks = 0;
				foreach($okeys as $okey)
				{
					$orders[] = array($okey,$order[4][$okey]);
					if(isset($_SESSION['openOrders'][$okey])){$myAsks++;}
				}
				array_unshift($liveBook,array($order[0],$key,$order[1],$myAsks,$order[3],$orders));
				//$liveBook[] = array($order[0],$key,$order[1],$order[2],$order[3],$orders);
			}

			# Load bids onto live book
			$keys = array_keys($_SESSION['bookBids']);
			rsort($keys);
			$ct = 0;
			foreach($keys as $key)
			{
				if(++$ct > $liveBookDepth){ break; }
				$order = $_SESSION['bookBids'][$key];
				$okeys = array_keys($order[4]);
				$orders = [];
				$myBids = 0;
				foreach($okeys as $okey)
				{
					$orders[] = array($okey,$order[4][$okey]);
					if(isset($_SESSION['openOrders'][$okey])){$myBids++;}
				}
				$liveBook[] = array($order[0],$key,$order[1],$myBids,$order[3],$orders);
			}
############################   END CREATE LIVE BOOK #################################

			//if($_POST['click'] > 100){$stopOrder = 1;}
$sockStat  = '<table>';
$sockStat .= '<tr>';
$sockStat .= '<td>bookSequence</td>';
$sockStat .= '<td>'.$_SESSION['bookSequence'].'</td>';
$sockStat .= '</tr>';

$sockStat .= '<tr>';
$sockStat .= '<td>BurrferFirst</td>';
$sockStat .= '<td>'.$_SESSION['bufferFirst'].'</td>';
$sockStat .= '</tr>';

$sockStat .= '<tr>';
$sockStat .= '<td>BurrferLast</td>';
$sockStat .= '<td>'.$_SESSION['bufferLast'].'</td>';
$sockStat .= '</tr>';
$sockStat .= '</table>';


			$kara = array(
				'minions'      => $_SESSION['minions'],
				'liveBook'     => $liveBook,
				'socketBuffer' => $sockStat,
				'feedData'     => $feedData,
				'nextOrder'    => $nextOrder,
				'stopOrder'    => $stopOrder,
				'active'       => $_SESSION['startLiveBook'],
				'msg'          => $_SESSION['msg'],
				'debug'        => $_SESSION['debug'],
				'minionAction' => $minionActionReturn,
				'matchedResult' => $matchedResult
			);
			break;
# END TICK
		default:
			break;
	}
	echo json_encode($kara);
?>
