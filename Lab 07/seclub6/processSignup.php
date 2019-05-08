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
					<li class="nav-item">
						<a class="nav-link" href="signup.html">SIGN&nbspUP</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="signup.html">PROFILE</a>
						<span class="sr-only">(current)</span> 
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
				<?php
				if(isset($_POST['Fname'])){
					$Fname	= $_POST['Fname'];
					$Lname	= $_POST['Lname'];
					$stuID	= $_POST['stuID'];
					$email	= $_POST['email'];
					$pw		= $_POST['pw'];
					$rpw	= $_POST['rpw'];
					$bd		= $_POST['bd'];
					$event	= $_POST['event'];

					$arr 	= array
					('uname' => ($Fname ." " . $Lname), 
						'studentID' => $stuID,
						'email' => $email,
						'password' => $pw,
						'rpassword' => $rpw,
						'birthday' => $bd,
						'event' => $event);

					echo '<div id="info" class="alert alert-info" role="alert"> Hi ' . $arr["uname"] . ', Welcome to SE Club!</div>';

					echo '<table class="table table-striped">
						  <tbody>
						    <tr>
						      <th scope="row">Name:</th>
						      <td>' . $arr["uname"]  . '</td>
						    </tr>
						    <tr>
						      <th scope="row">StudentID:</th>
						      <td>' . $arr["studentID"]  . '</td>
						    </tr>
						    <tr>
						      <th scope="row">Email:</th>
						      <td>' . $arr["email"]  . '</td>
						    </tr>
						    <tr>
						      <th scope="row">Birthday:</th>
						      <td>' . $arr["birthday"]  . '</td>
						    </tr>
						    <tr>
						      <th scope="row">Most Favourite Event:</th>
						      <td>' . $arr["event"]  . '</td>
						    </tr>
						  </tbody>
						</table>';

					$file 	= fopen("seclubmember.txt","w");
					$txt 	= implode(",", $arr);
					fwrite($file, $txt);
					fclose($file);

					$file 	= fopen("seclubmember2.txt","w");
					$txt 	= "Array\n(\n";
					foreach($arr as $x => $x_value) {
						$txt .= ('[' . $x . '] => ' . $x_value . "\n");
					}
					$txt 	.= ")";

					fwrite($file, $txt);
					fclose($file);
			/*
			file_put_contents("test.txt","Hello World. Testing!");

			fclose($file);
			*/
		}
		?>
	</div>
</main>

<footer class="container text-center font-italic">
	<hr>
	Copyright &copy 2019 UM Software Engineering Club<br>
	<a href="mailto:umseclub@um.edu.my">umseclub@um.edu.my</a>
</footer>

</div>

</body>
</html>