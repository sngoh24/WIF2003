<?php 
session_start();

if(isset($_POST['email']) AND 
	isset($_POST['pw'])){
	include_once("config.php");
	$email		= $_POST['email'];
	$password	= $_POST['pw'];

	$sql	= "
	SELECT 	*
	FROM 	members
	WHERE 	email 		= '$email'
	";
	$result = $conn->query($sql) or die("Query Error");

	if($row = $result->fetch_assoc() AND 
		(password_verify($password, $row["password"]))){
		$_SESSION['logged_in'] 	= true;
		$_SESSION['user_id'] 	= $row["studentid"];
		$_SESSION['user_email'] = $email;
		header('Location: profile.php?action=login_success');
	} else {
		header('Location: login.php?id=login_failed');
	}
}
?>