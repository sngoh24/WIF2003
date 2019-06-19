<!DOCTYPE html>
<html>
<head>
	<!-- CSS File -->
	<link rel="stylesheet" type="text/css" href="indexCSS.css">
	
	<!-- icon -->
	<link rel="shortcut icon" href="Brain Logo.png">

	<!-- Title -->
	<title>Critical Thinking Skills</title>
	
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<!-- This is button to go top.-->
	<button onclick="topFunction()" id="topBtn" title="Go to top">Top</button>

	<!--Here the navigation bar.-->
	<nav id="homeNav">
		<div class="row">
			<li><a href="home.php"><img src="Brain Logo.png" alt="Brain Logo" class="logo"></a></li>
			<ul>
				<li><a href="#CTS">WHAT IS CTS?</a></li>
				<li><a href="#MISSION">OUR MISSION</a></li>
				<li><a href="#contact">CONTACT US</a></li>
				<li><a href="form.php" class="startBtn">GET STARTED</a></li>
			</ul>
		</div>
	</nav>

	<hr>

	<main>
		<!--Here the heading-->
		<div id="head1">
			<div id="headContent1">
				<h1><q>Education is not the learning of facts, but the training of the mind to think.</q></h1>
				<h3>- Albert Einstein</h3>
			</div>
			<div id="headContent2">
				<h3>Let's test your critical thinking skills.</h3>
				<a href="form.php" class="startBtn">GET STARTED</a>
			</div>
		</div>
		<hr>

		<!--Here start the table.-->
		<table class="homeTable">
			<!--What is CTS?-->
			<tr id="CTS">
				<td class="homebg" style="background-image: url(Thinking2.jpeg);"></td>
				<td id="critical">
					<h2>What is Critical Thinking?</h2>
					<h3>Critical thinking is the ability to think clearly and
					rationally, understanding the logical connection between ideas.</h3>
					<h4>Critical thinking has been the subject of much debate and thought since the time of early Greek philosophers such as Plato and Socrates and has continued to be a subject of discussion	into the modern age, for example the ability to recognise fake news.</h4>
					<h4><span style="float: right;">(Skillsyouneed.com, 2019)</span></h4>

				</td>
			</tr>

			<!--Mission.-->
			<tr id="MISSION">
				<td id="mission">
					<h2>Our Mission</h2>
					<h3>Our mission is to develop a Web application to assess the Critical Thinking Skills (CTS) of students from Faculty of Business Administration and Accountancy of University of MALAYA (UM).</h3>
					<h4>The development of our Web application will be start on 19 February 2019 until 14 May 2019 within the cost of RM150,000.</h4>
				</td>
				<td class="homebg" style="background-image: url(Mission.jpg);"></td>
			</tr>
		</table>

		<hr>

		<!--Contact Us.-->
		<table class="homeTable">
			<tr id="contact">
				<!--Information.-->
				<td id="contactbg">
					<h2>Contact Us</h2>
					<p>Mustafa Syahmi</p>
					<p>Telephone No: <a href="tel:+60187831151" target="_top">+6018-7831151</a></p>
					<p>Email: <a href="mailto:mussyahmi31@gmail.com" target="_top">mussyahmi31@gmail.com</a></p>
				</td>

				<td id="message">
					<!--Here start the form-->			
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
						<fieldset>
							<legend>Leave us a message</legend>
							<label>Please indicate your enquiry type to ensure that your message is passed on to the most relevant person.</label>
							<!--Enquiry-->
							<select id="CUenquiry" name="CUenquiry" required>
								<option selected disabled hidden>Select your enquiry</option>
								<option value="1">General Enquiry / Feedback</option>
								<option value="2">I need more information</option>
								<option value="3">I would like to write a guest post for CreativeBrain</option>
								<option value="4">I would like permission to reproduce some content</option>
								<option value="5">I've found a problem with the content</option>
								<option value="6">I've found a broken link or other technical problem</option>
								<option value="7">I would like to advertise with CreativeBrain</option>
							</select>

							<!--Name-->
							<input type="text" id="CUname" name="CUname" required placeholder="Enter your name" autocomplete="on" tabindex="1" size="50" invalid="this.setCustomValidity('Please enter your name')">

							<!--Email-->
							<input type="email" id="CUemail" required name="CUemail" placeholder="Enter your e-mail" tabindex="3" size="100" oninvalid="this.setCustomValidity('Please enter valid email')">

							<!--Message-->
							<label>Your message - Please provide as much information as possible.</label>			
							<textarea id="CUmessage" name="CUmessage" rows="10" cols="40" required placeholder="Enter your message..." autocomplete="off" tabindex="5" invalid="this.setCustomValidity('Please enter your message')"></textarea><br>

							<!--Submit-->
							<input type="submit" value="Send" 
							>

							<!--Reset-->
							<input type="reset">
						</fieldset>
					</form>
				</td>
			</tr>
		</table>
		<br>
	</main>

	<!--Here the footer-->
	<footer>
		&copy 2019 - CREATIVEBRAIN
	</footer>

	<script>
		// When the scrolls down 20px from the top of the document, show the button
		window.onscroll = function() {scrollFunction()};

		function scrollFunction() {
			if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
				document.getElementById("topBtn").style.display = "block";
			} else {
				document.getElementById("topBtn").style.display = "none";
			}
		}

		// When the user clicks on the button, scroll to the top of the document
		function topFunction() {
			document.body.scrollTop = 0;
			document.documentElement.scrollTop = 0;
		}

		
	</script>

	<!-- php script -->
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//connect to database
		require "connect.php";
		
		$CUenquiry 	= $_POST["CUenquiry"];
		$CUname 	= $_POST["CUname"];
		$CUemail 	= $_POST["CUemail"];
		$CUmessage 	= $_POST["CUmessage"];
		date_default_timezone_set('Asia/Kuala_Lumpur');
		$ts = time();
		$date = new DateTime;
		$date->setTimestamp($ts); 
		$date = $date->format('Y-m-d H:i:s');

		//insert message into database
		$sql = "
			INSERT INTO message (type, name, email, message, lastUpdatedBy, lastUpdatedOn, createdBy, createdOn) 
			VALUES		('$CUenquiry', '$CUname', '$CUemail', '$CUmessage', '$CUname', '$date', '$CUname', '$date')";
			$conn->query($sql) or die($conn->error);
	}
	?>
</body>
</html>