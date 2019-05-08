<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Sign Up</title>
</head>

<body style="background-color:#ADD8E6">
	<div class="container">

		<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
			<a class="navbar-brand" href="index.html">
				<img src= "selogothumb.jpg" style="width: 30px; height: 30px">
			Software Engineering Club</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.html">HOME</a> 
					</li>
					<li class="nav-item">
						<a class="nav-link" href="about.html">ABOUT</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="events.html">EVENTS</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="login.php">LOG IN</a>
					</li>
				</ul>

				<form class="form-inline my-2 my-lg-0">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</nav>
		
		<main>
			<div class="jumbotron" style="background-color:#F0F8FF; padding-top:70px">
				<div class="alert alert-success" role="alert">
					<?php
					include_once("config.php");
					if(isset($_POST['Fname'])){
						$Fname	= $_POST['Fname'];
						$Lname	= $_POST['Lname'];
						$stuid	= $_POST['stuID'];
						$email	= $_POST['email'];
						$pw		= $_POST['pw'];
						$rpw	= $_POST['rpw'];
						$bd		= $_POST['bd'];
						$event	= $_POST['event'];

						$sqlID = "
						SELECT 	id, email
						FROM 	members
						WHERE 	id = '$stuid' OR 
								email = '$email'";

						$result = $conn->query($sqlID) or die("Query Error");

						if($result->num_rows > 0){
							echo 'Email or Student ID already exists.<br>';
							echo '<a href="signup.html">Sign Up</a><br>';

							echo '<a href="login.php">Log In</a>';
						}else {
							$sql = "
							INSERT INTO		members
							VALUES ('$Fname', '$Lname', '$stuid', '$email', '$pw', '$rpw', '$bd', '$event')"
							;

							$conn->query($sql);

							echo '<h2>Registration successful</h2><br>';

							echo '<a href="login.php">Log In</a>';
						}
					}
					?>
				</div>
			</div>
		</main>

		<footer class="container text-center font-italic">
			<hr>
			Copyright &copy 2019 UM Software Engineering Club<br>
			<a href="mailto:umseclub@um.edu.my">umseclub@um.edu.my</a>
		</footer>

	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-	q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"	crossorigin="anonymous"></script>
	<script	src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-	JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"crossorigin="anonymous"></script>
</body>
</html>