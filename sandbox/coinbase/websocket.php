<?php
	session_start();
	$kara = 'Groot';
	$func = $_POST['func'];
	require_once('wsdb.php');
	$db = new wsdb();
	switch($func)
	{
		case 'startup':
			$_SESSION['count'] = 0;
			$r = $db->createTable();
			$kara = "Creating DB: $r";
			break;
		case 'upload':
			$kara = 'Uploading: '.++$_SESSION['count'];
			$db->upload('1');
			break;
		default:
			$kara = 'default';
			break;
	}
	echo $kara;
?>