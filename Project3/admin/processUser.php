<?php 
session_start();
// login failed
if(!($_SESSION['login'] || $_SESSION['username'] || $_SESSION['password'] || $_SESSION['login'] == true)){
	header('location: login.php');
}

include('connect.php');

// edit user 
if(isset($_POST['editSubmit'])){
	if(isset($_POST['password']) && isset($_POST['rpassword'])){
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$sql = "
		UPDATE 	user
		SET 	password 	= '$password'
		WHERE 	id 			= '$tempid'";
	}
	$status = $_POST['editStatus'];
	$tempid = $_POST['tempid'];
	$sql = "
	UPDATE 	user
	SET 	status 	= '$status'
	WHERE 	id 		= '$tempid'";

	$conn->query($sql) or die($conn->error);

} elseif(isset($_POST['inactiveSubmit'])){
	$status = 2;
	$tempid = $_POST['tempid1'];
	$sql = "
	UPDATE 	user
	SET 	status 	= '$status'
	WHERE 	id 		= '$tempid'";

	$conn->query($sql) or die($conn->error);

} elseif(isset($_POST['add'])) {
	// add new user
	$userid 	= $_POST["userid"];
	$password 	= password_hash($_POST['password'], PASSWORD_BCRYPT);
	$status 	= $_POST["status"];
	$createdBy	= $_SESSION['userid'];
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$ts = time();
	$date = new DateTime;
	$date->setTimestamp($ts); 
	$date = $date->format('Y-m-d H:i:s');

	// insert user into database
	$sql = "
	INSERT INTO user (username, password, status, createdBy, createdOn) 
	VALUES		('$username', '$password', '$status', '$createdBy', '$date')";

	$conn->query($sql) or die($conn->error);
}
 header("location: users.php");
?>