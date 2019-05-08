<?php
$servername = 'localhost';
$db = 'lab8';
$username = 'user1';
$password = 'user1abc';

try 
{
	$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Database connected successfully<br>"; 
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}
?>