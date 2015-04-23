<?php

	# Set variables
	$server = 'serverip';
	$user   = 'username';
	$pass   = 'password';
	$datab  = 'database';

	# Connect to Database
	$conn = mysqli_connect($server,$user,$pass,$datab);

	# Get records from database
	$query = "SELECT col1 FROM tablee";
	$stmt = mysqli_prepare($conn,$query);
	$stmt->execute();
	$stmt->bind_result($col1);
	while($stmt->fetch())
	{
		# Processes record
	}

	# Change records in database
	$query = "UPDATE table set col1 = ? where id = ?";
	$stmt = mysqli_prepare($conn,$query);
	$stmt->bind_param('si',$val1,$id);
	$val1 = 'value';
	$id   = 1;
	$stmt->execute();
	
	# Add new record to database
	$query = "INSERT INTO orders (col1) values (?)";
	$stmt = mysqli_prepare($conn,$query);
	$stmt->bind_param('s',$val1);
	$val1 = 'value';
	$stmt->execute();

?>
