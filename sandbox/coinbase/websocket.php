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

			$kara = array(
				'book'  => $book,
				'debug' => $debug
			);

			break;

		case 'upload':
			$kara = 'Loaded: '.++$_SESSION['count'];
			$_SESSION['socketBuffer'][] = $_POST['message'];
/*
			require_once('wsdb.php');
			$db = new wsdb();
			$db->upload($_POST['message']);
*/
			break;
		case 'tick':

			# CREATE LIVE BOOK
			$liveBook      = [];
			$liveBookDepth = 2;

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

		# Minions will go here, I think this should be done after the buffer is clear?
			$minions = array('zek','groot','bob');

			$nextOrder = '';
			$msg = '';

			# Check to see if the buffer is empty
			while(isset($_SESSION['socketBuffer'][0]))
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
						$msg = 'Proceess Done may effect book';
						break;
					case 'open':

						array_shift($_SESSION['socketBuffer']);
						break;

						$side    = $o['side'] == 'buy' ? 'bid' : 'ask';
						$price   = $o['price'];
						$orderI  = $o['order_id'];
						$size    = $o['remaining_size'];

						# This will change when price line order list is a hash
						$orderId = array(
							'id'  => $orderI,
							'amt' => $size
						);

						# Process Open Ask
						if($side == 'ask')
						{
							array_shift($_SESSION['socketBuffer']);
						}
						# Process Open Bid
						else
						{
							$priceX = '293.82000000';
							# Check to Price line in book
							if(isset($_SESSION['bookBids'][$priceX]))
							{
								# This needs to be reworked after Price line order list change
								$checkForOrder = 0;
								foreach($_SESSION['bookBids'][$priceX][4] as $a)
								{
									if($a['id'] == $orderI)
									{
										# Update order
										$a['amt'] = 69;
										$checkForOrder = 1;
									}
								}
								# Add order
								if(!$checkForOrder)
								{
									# Add order to book
									$_SESSION['bookBids'][$priceX][4][] = $orderId ;

									# Update price total size
									$t = 0;
									foreach($_SESSION['bookBids'][$priceX][4] as $a)
									{
										$t += $a['amt'];
									}
									$_SESSION['bookBids'][$priceX][1] = $t ;
								}
							}
							# Add new Price Line
							else
							{
								$_SESSION['bookBids'][$priceX] = array($side,$size,1,0,array($orderId));
							}
						}
						$msg = "test: ";
						break;
					case 'match':
						array_shift($_SESSION['socketBuffer']);
						$msg = 'Proceess Open remove from book';
						break;
					default:
						$msg = $type;
				} # END SWITCH ON ORDER TYPE (recieved,open,done,match)
			} # END OF PROCESSING BUFFER

			$kara = array(
				'minions'      => $minions,
				'liveBook'     => $liveBook,
				'socketBuffer' => 'Groot',
				'nextOrder'    => $nextOrder.'<br/><br/>'.$msg
			);
			break;
		default:
			break;
	}
	echo json_encode($kara);
?>
