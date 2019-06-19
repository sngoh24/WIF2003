<!DOCTYPE html>
<html>
<head>
	<!-- CSS File -->
	<link rel="stylesheet" type="text/css" href="indexCSS.css">
	
	<script>sessionStorage.clear()</script>

	<!-- icon -->
	<link rel="shortcut icon" href="Brain Logo.png">

	<!-- Title -->
	<title>Critical Thinking Skills</title>
	
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<!--Here the navigation bar.-->
	<nav id="resultNav">
		<div class="row">
			<li><a href="home.php"><img src="Brain Logo.png" alt="Brain Logo" class="logo"></a></li>
			<ul>
				<li><a href="home.php#CTS">WHAT IS CTS?</a></li>
				<li><a href="home.php#MISSION">OUR MISSION</a></li>
				<li><a href="home.php#contact">CONTACT US</a></li>
				<li><a href="form.php" class="startBtn">NEW ATTEMPT</a></li>
			</ul>
		</div>
	</nav>

	<hr>
	
	<main>
		<?php 
			session_start();
			if(isset($_SESSION['login']) && 
			isset($_SESSION['id']) &&
			isset($_SESSION['matricNo']) &&
			$_SESSION['login'] == true){
				$duration = $_SESSION['totalMin'];
		?>
		<div id=resultContent>
		<h2>Quiz Completed!</h2>
		<h3 id="resultTime">Time Used: <?php echo $duration ?> minutes</h3>

		<table class="homeTable">
			<!--What is CTS?-->
			<tr id="resultRow">
				<td class="resultLeft">
					<div id="resultText">
						<h4>Your answers have been saved and submitted.</h4>
						<p>The answers will be marked and reviewed by our admininstrators within one working week.</p>
						<p> The results of this test will be sent to you via your personal email address that has been previously collected.</p>
						<p>Thank you for taking part in this Critical Thinking Skills (CTS) Test!</p>
					</div>
				</td>
				<td class="resultRight" style="background-image: url(resultImg.png);"></td>
			</tr>
		</table>
	</div>
	</main>
	<?php
		session_destroy();
	} else {
		header("location: home.php");
	}
	?>
	<!--Here the footer-->
	<footer>
		&copy 2019 - CREATIVEBRAIN
	</footer>
</body>
</html>