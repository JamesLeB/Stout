<?php
	session_start();
	$kara = '';
	$func = $_POST['func'];
	switch($func)
	{
		case 'startup':
			$debug = '';

			require_once('wsdb.php');
			$db = new wsdb();
$_SESSION['X'] = 1;
			$_SESSION['count'] = 0;
			$_SESSION['socketBuffer'] = array();
			$db->createTable();

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
				$orderId = array(
					'id'  => $order[2],
					'amt' => $order[1]
				);
				if(!isset($bookBids[$order[0]]))
				{
					$orders = array($orderId);
					$bookBids[$order[0]] = array('bid',$order[1],0,0,$orders);
				}
				else
				{
					$bookBids[$order[0]][4][] = $orderId;
					$bookBids[$order[0]][1]  += $order[1];
				}
			}
			$_SESSION['bookBids'] = $bookBids;

			# LOAD ASKS
			$bookAsks = [];
			foreach($book['asks'] as $order)
			{
				$orderId = array(
					'id'  => $order[2],
					'amt' => $order[1]
				);
				if(!isset($bookAsks[$order[0]]))
				{
					$orders = array($orderId);
					$bookAsks[$order[0]] = array('ask',$order[1],0,0,$orders);
				}
				else
				{
					$bookAsks[$order[0]][4][] = $orderId;
					$bookAsks[$order[0]][1] += $order[1];
				}
			}
			$_SESSION['bookAsks'] = $bookAsks;

			$kara = array(
				'book'     => $book,
				'debug'    => $debug
			);

			break;

		case 'upload':
			$kara = 'Loaded: '.++$_SESSION['count'];
			$_SESSION['socketBuffer'][] = $_POST['message'];
			$a = $_SESSION['socketBuffer'][0];
/*
			require_once('wsdb.php');
			$db = new wsdb();
			$db->upload($_POST['message']);
*/
			break;
		case 'tick':

			# CREATE LIVE BOOK
			$liveBook = [];
			$liveBookDepth = 2;

			$keys = array_keys($_SESSION['bookAsks']);
			$ct = 0;
			foreach($keys as $key)
			{
				if(++$ct > $liveBookDepth){ break; }
				$order = $_SESSION['bookAsks'][$key];
				array_unshift($liveBook,array($order[0],$key,$order[1],$order[2],$order[3],$order[4]));
			}

			$keys = array_keys($_SESSION['bookBids']);
			rsort($keys);
			$ct = 0;
			foreach($keys as $key)
			{
				if(++$ct > $liveBookDepth){ break; }
				$order = $_SESSION['bookBids'][$key];
				$liveBook[] = array($order[0],$key,$order[1],$order[2],$order[3],$order[4]);
			}

			$minions = array('zek','groot','bob');

####
# SESSION BUFFER WILL BE EMPTY FIRST FEW TICKS!!!!
###
			$nextOrder = '';
			$msg = '';
			if(isset($_SESSION['socketBuffer'][0]))
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
						$side = $o['side'] == 'buy' ? 'bid' : 'ask';
						$price = $o['price'];
						$orderId = $o['order_id'];
						$size = $o['remaining_size'];

						$orderId = array(
							'id'  => $orderId,
							'amt' => $size
						);

						if($side == 'ask')
						{
							array_shift($_SESSION['socketBuffer']);
						}
						else
						{
							$priceX = '293.82000000';

# This is the check that prevents adding record over and over
# Wont happen once I am always shift the buffer
if($_SESSION['X'] == 1)
{
							if(isset($_SESSION['bookBids'][$priceX]))
							{
								$_SESSION['bookBids'][$priceX][4][] = $orderId ;
								$t = 0;
								foreach($_SESSION['bookBids'][$priceX][4] as $a)
								{
									$t += $a['amt'];
								}
								$_SESSION['bookBids'][$priceX][1] = $t ;
								$_SESSION['X'] = 0;
							}
							else
							{
								$_SESSION['bookBids'][$priceX] = array($side,$size,1,0,array($orderId));
							}
}
						}
							$msg = "test: ".$_SESSION['X'];
						break;
					case 'match':
						array_shift($_SESSION['socketBuffer']);
						$msg = 'Proceess Open remove from book';
						break;
					default:
						$msg = $type;
				}
			}

			$kara = array(
				'minions' => $minions,
				'liveBook' => $liveBook,
				'socketBuffer' => count($_SESSION['socketBuffer']),
				'nextOrder' => $nextOrder.'<br/><br/>'.$msg
			);
			break;
		default:
			break;
	}
	echo json_encode($kara);
?>
