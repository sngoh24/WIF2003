<?php
include('connect.php');

if(isset($_POST['login'])) {
	$errMsg = '';

		// Get data from FORM
	$username = $_POST['username'];
	$password = $_POST['password'];

	if($username == '')
		$errMsg = 'Enter username';
	if($password == '')
		$errMsg = 'Enter password';

	if($errMsg == '') {
		try {
			$sql = "
			SELECT username, password, status 
			FROM user 
			WHERE username = '$username'";
			$result = $conn->query($sql);	
			$correctAns = array();
			while($row = $result->fetch_assoc()) {
				$username1 = $row["username"];
				$password1 = $row["password"];
				$status1 = $row["status"];			
			}

				//Deny access if user is inactive
			if($status1 == 2){
				echo '<script>';
				echo "alert(\"User '$username' is inactive. Please try again.\")";
				echo '</script>';					
				echo "<meta http-equiv='refresh' content='0;url=login.php'>";
			}
				//Deny access if user is not found
			else if($username != $username1){
					//$errMsg = "User '$username' not found.";
				echo '<script>';
				echo "alert(\"User '$username' not found. Please try again.\")";
				echo '</script>';
				echo "<meta http-equiv='refresh' content='0;url=login.php'>";
			}
			//Deny access if password does not match
			else {
				if(password_verify($password, $password1)) {
					session_start();
					$_SESSION['login'] = true;		
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					date_default_timezone_set('Asia/Kuala_Lumpur');
					$ts 	= time();
					$date 	= new DateTime;
					$date->setTimestamp($ts); 
					$date 	= $date->format('Y-m-d H:i:s');

					$sql = "
					UPDATE 	user
					SET 	lastloggedin 	= '$date' 
					WHERE 	username 		= '$username'";

					$conn->query($sql) or die($conn->error);

					header('Location: home.php');
					exit;
				}
				else
				//$errMsg = 'Password not match.';
				echo '<script>';
				echo 'alert("Password does not match. Please try again.")';
				echo '</script>';
				echo "<meta http-equiv='refresh' content='0;url=login.php'>";
			}
		}
		catch(PDOException $e) {
			$errMsg = $e->getMessage();
		}
	}
}
?>

<html>
<head>
	<!-- css file -->
	<link rel="stylesheet" type="text/css" href="admin-form.css">
	
	<!-- icon -->
	<link rel="shortcut icon" href="Brain Logo.png">
	
	<title>Critical Thinking Skills</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php
	if(isset($errMsg)){
		echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
	}
	?>
	<!-- Log in Form -->
	<div id="id01" class="modal" style="
	background-image: url('../Background.png');">
	<form class="modal-content" action="" method="post">
		<div class="container">
			<h1>Log In</h1>
			<hr>
			<!-- Username -->
			<label for="username">Username</label>
			<input class="form-control"  type="text" placeholder="Enter Username" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" class="box" required>

			<!-- Password -->
			<label for="password">Password</label>
			<input class="form-control" type="password" placeholder="Enter Password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" class="box" required>

			<div class="clearfix">
				<!-- User Home -->
				<a href="../home.php" style="text-decoration: none">
					<button type="button" class="cancelbtn">Home</button>
				</a>

				<!-- Admin Home -->
				<button type="submit" class="loginbtn" name='login' value="Login">Log In</button>
			</div>
		</div>
	</form>
</div>

</body>
</html>
