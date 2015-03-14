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
