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
			$db->createTable();
			require_once('exchange.php');
			$exchange = new exchange();

			//$orderBook = $exchange->getOrderBook();
			//file_put_contents('book.json',$orderBook);
			$orderBook = file_get_contents('book.json');
			$orderBook = json_decode($orderBook,true);

$liveBids = array();

foreach($orderBook['bids'] as $order)
{
	if(isset($liveBids[number_format($order[0],2)]))
	{
		$liveBids[number_format($order[0],2)]['size'] += $order[1];
		$liveBids[number_format($order[0],2)]['orders'][] = 
			array('orderId' => $order[2], 'orderSize' => $order[1]);
	}
	else
	{
		$entry = array(
			'side' => 'bid',
			'size' => $order[1],
			'minionC' => 0,
			'minionA' => 0,
			'orders' => array(array('orderId' => $order[2], 'orderSize' => $order[1]))
		);
		$liveBids[number_format($order[0],2)] = $entry;
	}
}


$book = array();

$keys = array_keys($liveBids);
arsort($keys);
$count = 0;
foreach($keys as $key)
{
	$a = array();
	foreach($liveBids[$key]['orders'] as $o)
	{
		$a[] = $o['orderId']." : ".$o['orderSize'];
	}
	if(++$count > 10){ break; }
	$book[] = array(
		$liveBids[$key]['side'],
		$key,
		$liveBids[$key]['size'],
		$liveBids[$key]['minionC'],
		$liveBids[$key]['minionA'],
		implode('<br/>',$a)
	);
}

			$kara = array(
				'orderBook' => $orderBook,
				'book'      => $book
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
