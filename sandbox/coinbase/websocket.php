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
			$_SESSION['socketBuffer'][] = $_POST['message'];
			$a = $_SESSION['socketBuffer'][0];
/*
			require_once('wsdb.php');
			$db = new wsdb();
			$kara = 'Uploading: '.++$_SESSION['count'];
			$db->upload($_POST['message']);
*/
			break;
		case 'tick':

			# CREATE LIVE BOOK
			$liveBook = [];
			$liveBookDepth = 10;

			$keys = array_keys($_SESSION['bookAsks']);
			$ct = 0;
			foreach($keys as $key)
			{
				if(++$ct > $liveBookDepth){ break; }
				$order = $_SESSION['bookAsks'][$key];
				array_unshift($liveBook,array($order[0],$key,$order[1],0,0,$order[4]));
			}

			$keys = array_keys($_SESSION['bookBids']);
			$ct = 0;
			foreach($keys as $key)
			{
				if(++$ct > $liveBookDepth){ break; }
				$order = $_SESSION['bookBids'][$key];
				$liveBook[] = array($order[0],$key,$order[1],0,0,$order[4]);
			}

			$minions = array('zek','groot','bob');

####
# SESSION BUFFER WILL BE EMPTY FIRST FEW TICKS!!!!
###

			$kara = array(
				'minions' => $minions,
				'liveBook' => $liveBook,
				'socketBuffer' => count($_SESSION['socketBuffer']),
				'test' => $_SESSION['socketBuffer']
			);
			break;
		default:
			break;
	}
	echo json_encode($kara);
?>
