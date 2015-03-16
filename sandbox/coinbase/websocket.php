<?php
	session_start();
	$kara = array();
	$func = $_POST['func'];
	switch($func)
	{
		case 'startup':
			require_once('wsdb.php');
			$db = new wsdb();
			$_SESSION['count'] = 0;
			$r = $db->createTable();
			$kara = "Creating DB: $r";
			require_once('exchange.php');
			$exchange = new exchange();

			//$orderBook = $exchange->getOrderBook();
			//file_put_contents('book.json',$orderBook);
			$orderBook = file_get_contents('book.json');
			$orderBook = json_decode($orderBook,true);
			$kara = array(
				'createDB' => $r,
				'orderBook' => $orderBook
			);
			break;
		case 'upload':
			require_once('wsdb.php');
			$db = new wsdb();
			$kara = 'Uploading: '.++$_SESSION['count'];
			$db->upload($_POST['message']);
			break;
		case 'tick':
			$minions = array('zek','groot','bob');
			$kara = array(
				'minions' => $minions
			);
			break;
		default:
			break;
	}
	echo json_encode($kara);
?>
