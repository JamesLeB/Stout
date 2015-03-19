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

			$_SESSION['count'] = 0;
			$_SESSION['socketBuffer'] = array();

			require_once('exchange.php');
			$exchange = new exchange();

			# GET ORDER BOOK
			//$orderBook = $exchange->getOrderBook();
			//file_put_contents('book.json',$orderBook);
			//$orderBook = file_get_contents('book.json');
			//$orderBook = json_decode($orderBook,true);
			$book = file_get_contents('book.json');
			$book = json_decode($book,true);

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
			#$_SESSION['bookBids'] = [];

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
			#$_SESSION['bookAsks'] = [];

			$kara = array(
				'book'  => $book,
				'debug' => $debug
			);

			break;

		case 'upload':
			$kara = 'Loaded: '.++$_SESSION['count'].' : Buffer: '.sizeof($_SESSION['socketBuffer']);
			$_SESSION['socketBuffer'][] = $_POST['message'];
			#require_once('wsdb.php');
			#$db = new wsdb();
			#$db->upload($_POST['message']);
			break;
		case 'tick':
			$stopOrder = 0;


		# Minions will go here, I think this should be done after the buffer is clear?
			$minions = array('zek','groot','bob');

			$nextOrder = '';
			$msg = '';

			# Check to see if the buffer is empty
			while(isset($_SESSION['socketBuffer'][0]) && $stopOrder == 0)
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
$stopOrder = 1;
						$msg = 'Proceess Done may effect book';
						break;
					case 'open':

						array_shift($_SESSION['socketBuffer']);
						break;

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
			$liveBookDepth = 3;

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

			$kara = array(
				'minions'      => $minions,
				'liveBook'     => $liveBook,
				'socketBuffer' => 'Groot: '.$stopOrder.' : '.$_POST['click'],
				'nextOrder'    => $nextOrder.'<br/><br/>'.$msg,
				'stopOrder'    => $stopOrder
			);
			break;
		default:
			break;
	}
	echo json_encode($kara);
?>
