<?php
	session_start();
	$kara = 'Groot';
	$func = $_POST['func'];
	switch($func)
	{
		case 'startup':
			require_once('wsdb.php');
			$db = new wsdb();
			$_SESSION['count'] = 0;
			$_SESSION['click'] = 0;
			$r = $db->createTable();
			$kara = "Creating DB: $r";
			break;
		case 'upload':
			require_once('wsdb.php');
			$db = new wsdb();
			$kara = 'Uploading: '.++$_SESSION['count'];
			$db->upload($_POST['message']);
			break;
		case 'tick':
			$kara = ++$_SESSION['click'];
			break;
		default:
			$kara = 'default';
			break;
	}
	echo $kara;
?>
