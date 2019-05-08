<?php
	$server = 'localhost';
	$db 	= 'seclub';
	$user 	= 'user';
	$pass 	= 'userpwd';

	$conn	= new mysqli($server, $user, $pass, $db);

	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
	//echo "Connected successfully";
?>