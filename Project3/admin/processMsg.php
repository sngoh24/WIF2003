<?php 
session_start();
// login failed
if(!($_SESSION['login'] || $_SESSION['username'] || $_SESSION['password'] || $_SESSION['login'] == true)){
	header('location: login.php');
}

include_once('connect.php');

// edit message 
if(isset($_POST['submit'])){
	$status = $_POST['editstatus'];
	$id 	= $_POST['msgid'];
	$sql = "
	UPDATE 	message
	SET 	status 	= '$status'
	WHERE 	id		= $id";

	$conn->query($sql) or die($conn->error);

} elseif(isset($_POST['add'])) {
	// add new message
	$enquiry 	= $_POST["enquiry"];
	$name 		= $_POST["name"];
	$email 		= $_POST["email"];
	$message 	= $_POST["message"];
	$createdBy	= $_SESSION['username'];
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$ts = time();
	$date = new DateTime;
	$date->setTimestamp($ts); 
	$date = $date->format('Y-m-d H:i:s');

	//insert message into database
	$sql = "
	INSERT INTO message (type, name, email, message, lastUpdatedBy, lastUpdatedOn, createdBy, createdOn) 
	VALUES		('$enquiry', '$name', '$email', '$message', '$createdBy', '$date', '$createdBy', '$date')";

	$conn->query($sql) or die($conn->error);
}
header("location: message.php");
?>