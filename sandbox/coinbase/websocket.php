<?php
	session_start();
	$kara = '';
	$debug = '';
	$func = $_POST['func'];
	switch($func)
	{
		case 'startup':

			require_once('wsdb.php');
			$db = new wsdb();
			$db->createTable();

			$_SESSION['count']        = 0;
			$_SESSION['socketBuffer'] = [];
			$_SESSION['bookBids']     = [];
			$_SESSION['bookAsks']     = [];
			$_SESSION['bookSequence'] = 0;
			$_SESSION['bufferFirst']  = 0;
			$_SESSION['bufferLast']   = 0;

			$kara = 'Startup Complete';

			break;

		case 'getBook':

			require_once('exchange.php');
			$exchange = new exchange();

			# GET ORDER BOOK
			$book = $exchange->getOrderBook();
			//file_put_contents('book.json',$orderBook);
			//$book = file_get_contents('book.json');
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
					//$orders = array($orderId);
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

		case 'upload':
			$_SESSION['socketBuffer'][] = $_POST['message'];

			$fOrder = json_decode($_SESSION['socketBuffer'][0],true);
			$lOrder = json_decode($_POST['message'],true);

			$_SESSION['bufferFirst'] = $fOrder['sequence'];
			$_SESSION['bufferLast']  = $lOrder['sequence'];

			$kara = 'Loaded: '.++$_SESSION['count'].' : Buffer: '.sizeof($_SESSION['socketBuffer']);

			#require_once('wsdb.php');
			#$db = new wsdb();
			#$db->upload($_POST['message']);
			break;
		case 'tick':
			$stopOrder = 0;


			# Minions will go here, I think this should be done after the buffer is clear?
			# Minions need to act after buffer is clear!!!
			$minions = array('zek','groot','bob');

			$nextOrder = '';
			$msg = '';

# FLUSH ORDERS BEFORE FULL BOOK SEQUENCE

			# Check to see if the buffer is empty
			while(isset($_SESSION['socketBuffer'][0]) && $stopOrder == 0 && 0)
			{
				$nextOrder = $_SESSION['socketBuffer'][0];
				$o = json_decode($nextOrder,true);
				$type = $o['type'];
				switch($type)
				{
					case 'received':
						array_shift($_SESSION['socketBuffer']);
						$msg = 'Proceess received ignore';
						break;
					case 'done':
						array_shift($_SESSION['socketBuffer']);

						$side    = $o['side'] == 'buy' ? 'bid' : 'ask';
						$price   = $o['price'];
						$orderI  = $o['order_id'];

						$priceX = $price;

						$check1 = 'Default';
						$sampOrder = '';

						if($side == 'ask')
						{
							$check1 = 'ask side';

							# Get test sample
							if(isset($_SESSION['bookAsks'][$priceX][4]))
							{
								$sampOrderK = array_keys($_SESSION['bookAsks'][$priceX][4]);
								$sampOrder = $sampOrderK[0];
							}

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

							# Get test sample
							if(isset($_SESSION['bookBids'][$priceX][4]))
							{
								$sampOrderK = array_keys($_SESSION['bookBids'][$priceX][4]);
								$sampOrder = $sampOrderK[0];
							}

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

						$msg = $orderI.'<br/>'.$sampOrder.'<br/>'.$check1;

						break;
					case 'open':

						array_shift($_SESSION['socketBuffer']);

						$side    = $o['side'] == 'buy' ? 'bid' : 'ask';
						$price   = $o['price'];
						$orderI  = $o['order_id'];
						$size    = $o['remaining_size'];

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
						array_shift($_SESSION['socketBuffer']);
						$msg = 'Proceess Open remove from book';
						break;
					default:
						$msg = $type;
				} # END SWITCH ON ORDER TYPE (recieved,open,done,match)
			} # END OF PROCESSING BUFFER

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
				foreach($okeys as $okey)
				{
					$orders[] = array($okey,$order[4][$okey]);
				}
				array_unshift($liveBook,array($order[0],$key,$order[1],$order[2],$order[3],$orders));
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
				foreach($okeys as $okey)
				{
					$orders[] = array($okey,$order[4][$okey]);
				}
				$liveBook[] = array($order[0],$key,$order[1],$order[2],$order[3],$orders);
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
				'minions'      => $minions,
				'liveBook'     => $liveBook,
				'socketBuffer' => $sockStat,
				'nextOrder'    => $nextOrder.'<br/><br/>'.$msg,
				'stopOrder'    => $stopOrder
			);
			break;
# END TICK
		default:
			break;
	}
	echo json_encode($kara);
?>
