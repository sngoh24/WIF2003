<?php
session_start();
// login failed
if(!($_SESSION['login'] || $_SESSION['username'] || $_SESSION['password'] || $_SESSION['login'] == true)){
	header('location: login.php');
}
	include ('connect.php');
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
		$sql = "UPDATE question SET status = 2 WHERE id = '$id'";
		$result = $conn->query($sql);
		echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
	}
?>

	