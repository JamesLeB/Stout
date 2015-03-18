<?php
	session_start();
	$kara = '';
	$func = $_POST['func'];
	switch($func)
	{
		case 'startup':

			require_once('wsdb.php');
			$db = new wsdb();
			$_SESSION['count'] = 0;
			$db->createTable();

			require_once('exchange.php');
			$exchange = new exchange();

			//$orderBook = $exchange->getOrderBook();
			//file_put_contents('book.json',$orderBook);
			//$orderBook = file_get_contents('book.json');
			//$orderBook = json_decode($orderBook,true);

			$book     = file_get_contents('book.json');
			$book = json_decode($book);

			# CREATE LIVEBOOK!!!!!  We will rule the world :)
			$liveBook = [];
			$order = [1,2,3,4,5];
			$liveBook[]=$order;
			$liveBook[]=$order;

			$kara = array(
				'book'     => $book,
				'liveBook' => $liveBook
			);
			break;
		case 'upload':
/*
			require_once('wsdb.php');
			$db = new wsdb();
			$kara = 'Uploading: '.++$_SESSION['count'];
			$db->upload($_POST['message']);
*/
			break;
		case 'tick':
			//$minions = array('zek','groot','bob');
			//$kara = array( 'minions' => $minions);
			break;
		default:
			break;
	}
	echo json_encode($kara);
?>
