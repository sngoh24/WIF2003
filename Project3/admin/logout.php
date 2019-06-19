<!DOCTYPE html>
<?php

session_start();
// login failed
if(!($_SESSION['login'] || $_SESSION['username'] || $_SESSION['password'] || $_SESSION['login'] == true)){
	header('location: login.php');
}

include_once('connect.php');

date_default_timezone_set('Asia/Kuala_Lumpur');
$ts 	= time();
$date 	= new DateTime;
$date->setTimestamp($ts); 
$date 	= $date->format('Y-m-d H:i:s');
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$sql = "
UPDATE 	user
SET 	lastloggedout 	= '$date' 
WHERE 	username 		= '$username'";
$conn->query($sql) or die($conn->error);

session_destroy();

?>

<html>
<head>
	<!-- css file -->
	<link rel="stylesheet" type="text/css" href="admin-form.css">
	
	<!-- icon -->
	<link rel="shortcut icon" href="../Brain Logo.png">
	
	<title>Critical Thinking Skills</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php
	if(isset($errMsg)){
		echo '<div style="color:#FF0000;text-align:center;font-size:17px;">' . $errMsg . '</div>';
	}
	?>
	<!-- Log in Form -->
	<div id="id01" class="modal" style="
	background-image: url('../Background.png');">
	<form class="modal-content" action="" method="post">
		<div class="container">
			<h1>Successfully log out</h1>
			<hr>
			<div class="clearfix">
				<!-- User Home -->
				<a href="../home.php" style="text-decoration: none">
					<button type="button" class="cancelbtn">Home</button>
				</a>
				<!-- Admin Log In -->
				<a href="login.php" style="text-decoration: none">
					<button type="button" class="loginbtn" name='login' value="Login">Log In</button>
				</a>
			</div>
		</div>
	</form>
</div>
</body>
</html>
