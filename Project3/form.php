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
	<div id="formdiv" class="modal">
		<a href="home.php" class="close">&times;</a>
		<form id="Pform" class="modal-content" action="processForm.php" method="POST" validate>
			<!--Logo-->
			<img src="Brain Logo.png" class="logo">
			<?php 
				if(isset($_POST['login_failed'])){
					echo '<div class="alert-warning">
					Please register before answering the questions.
					</div>';
				}
			?>
			<!--Instruction-->
			<h3><br>Please fill in this form to start.</h3>

			<hr>

			<!-- Personal Detail -->
			<div id="PD" class="tab">
				<h3>Personal Detail</h3>

				<!-- Registration/Matriculation Number -->
				<input type="text" id="matricNo" placeholder="Enter Registration/Matriculation Number" name="matricNo" autofocus required>

				<!-- Email -->
				<input type="email" id="email" placeholder="Enter Your Email" name="email" required>

				<!-- University -->
				<select name="university" required>
					<option selected disabled hidden>Your University</option>
					<option value="1">University of Malaya</option>
					<option value="2">Other</option>
				</select>

				<!--Faculty -->
				<select name="faculty" required>
					<option selected disabled hidden>Your Faculty</option>
					<option value="1">Faculty of Business and Administration</option>
					<option value="2">Other</option>
				</select>

				<!--Faculty's Course-->
				<select name="course" required>
					<option selected disabled hidden>Your Faculty's Course</option>
					<option value="1">Bachelor of Accounting</option>
					<option value="2">Bachelor of Business Administration</option>
					<option value="3">Bachelor of Finance</option>
					<option value="4">Other</option>
				</select>

				<!--Year of Study-->
				<select id="yearstudy" name="yearstudy" required>
					<option selected disabled hidden>Year of Study</option>
					<option value="1">First Year</option>
					<option value="2">Second Year</option>
					<option value="3">Third Year</option>
					<option value="4">Fourth Year</option>
					<option value="5">Fifth Year and above</option>
				</select>

				<div class="row">
					<div class="col-45" style="float: left;">
						<!--Age-->
						<select name="age" required>
							<option selected disabled hidden>Age Group</option>
							<option value="1">Below 18 Years</option>
							<option value="2">18-21 Years</option>
							<option value="3">22-25 Years</option>
							<option value="4">Above 25 Years</option>
						</select>
					</div>

					<div class="col-45" style="float: right;">
						<!--Gender-->
						<select name="gender" required>
							<option selected disabled hidden>Gender</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-45" style="float: left;">
						<!--Ethnic-->
						<select name="ethnic" required>
							<option selected disabled hidden>Ethnic Group</option>
							<option value="1">Malay</option>
							<option value="2">Chinese</option>
							<option value="3">Indian</option>
							<option value="4">Other</option>
						</select>
					</div>

					<div class="col-45" style="float: right;">
						<!--Nationality-->
						<select name="nation" required>
							<option selected disabled hidden>Nationality</option>
							<option value="1">Malaysian</option>
							<option value="2">Chinese (China)</option>
							<option value="3">Indonesian</option>
							<option value="4">Pakistani</option>
							<option value="5">Other</option>
						</select>
					</div>
				</div>
			</div>

			<!-- Past/last year’s examination results -->
			<div id="PY" class="tab"> 
				<h3>Past/last year’s examination results</h3>

				<!-- Year of Examination -->
				<select id="PYYear" name="PYYear" required>
					<option selected disabled hidden>Year of Examination</option>
				</select>

				<!-- Semester -->
				<select name="PYSem" required>
					<option selected disabled hidden>Semester</option>
					<option value="1">First</option>
					<option value="2">Second</option>
				</select>

				<!-- Courses -->
				<fieldset id="PYCourse1">
					<legend>Course 1</legend>
					<div class="row">
						<div class="col-15left">
							<input type="button" class="courseAddBtn"value="+" onclick="courseAddRow()">
							<input type="button" class="courseRemoveBtn"value="&times;" onclick="courseRemoveRow(1)">
						</div>
						<div class="col-65">
							<input type="text"placeholder="Course Code" name="PYCC1">
							<input type="text" placeholder="Course Name" name="PYCN1">
						</div>
						<div class="col-15right">
							<select name="PYgrade1" class="grade">
								<option selected disabled hidden>Grade</option>
								<option value="A+">A+</option>
								<option value="A">A</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B">B</option>
								<option value="C+">C+</option>
								<option value="C">C</option>
								<option value="C-">C-</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset id="PYCourse2">
					<legend>Course 2</legend>
					<div class="row">
						<div class="col-15left">
							<input type="button" class="courseAddBtn"value="+" onclick="courseAddRow()">
							<input type="button" class="courseRemoveBtn"value="&times;" onclick="courseRemoveRow(2)">
						</div>
						<div class="col-65">
							<input type="text"placeholder="Course Code" name="PYCC2">
							<input type="text" placeholder="Course Name" name="PYCN2">
						</div>
						<div class="col-15right">
							<select name="PYgrade2" class="grade">
								<option selected disabled hidden>Grade</option>
								<option value="A+">A+</option>
								<option value="A">A</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B">B</option>
								<option value="C+">C+</option>
								<option value="C">C</option>
								<option value="C-">C-</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset id="PYCourse3">
					<legend>Course 3</legend>
					<div class="row">
						<div class="col-15left">
							<input type="button" class="courseAddBtn"value="+" onclick="courseAddRow()">
							<input type="button" class="courseRemoveBtn"value="&times;" onclick="courseRemoveRow(3)">
						</div>
						<div class="col-65">
							<input type="text"placeholder="Course Code" name="PYCC3">
							<input type="text" placeholder="Course Name" name="PYCN3">
						</div>
						<div class="col-15right">
							<select name="PYgrade3" class="grade">
								<option selected disabled hidden>Grade</option>
								<option value="A+">A+</option>
								<option value="A">A</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B">B</option>
								<option value="C+">C+</option>
								<option value="C">C</option>
								<option value="C-">C-</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
				</fieldset>

				<div class="row">
					<div class="col-45" style="float:left">
						<!--GPA-->
						<input type="text" id="PYgpa" name="PYgpa" placeholder="GPA" required>
					</div>
					<div class="col-45" style="float:right">
						<!--CGPA-->
						<input type="text" id="PYcgpa"name="PYcgpa" placeholder="CGPA" required>
					</div>
				</div>
			</div>

			<div id="TY" class="tab">
				<h3>This year’s examination results</h3>
				<!-- Year of Examination -->
				<select id="TYYear" name="TYYear" required>
					<option selected disabled hidden>Year of Examination</option>
				</select>

				<!-- Semester -->
				<select name="TYSem" required>
					<option selected disabled hidden>Semester</option>
					<option value="1">First</option>
					<option value="2">Second</option>
				</select>

				<!-- Courses -->
				<fieldset id="TYCourse1">
					<legend>Course 1</legend>
					<div class="row">
						<div class="col-15left">
							<input type="button" class="courseAddBtn"value="+" onclick="courseAddRow()">
							<input type="button" class="courseRemoveBtn"value="&times;" onclick="courseRemoveRow(1)">
						</div>
						<div class="col-65">
							<input type="text"placeholder="Course Code" name="TYCC1">
							<input type="text" placeholder="Course Name" name="TYCN1">
						</div>
						<div class="col-15right">
							<select name="TYgrade1" class="grade">
								<option selected disabled hidden>Grade</option>
								<option value="A+">A+</option>
								<option value="A">A</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B">B</option>
								<option value="C+">C+</option>
								<option value="C">C</option>
								<option value="C-">C-</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset id="TYCourse2">
					<legend>Course 2</legend>
					<div class="row">
						<div class="col-15left">
							<input type="button" class="courseAddBtn"value="+" onclick="courseAddRow()">
							<input type="button" class="courseRemoveBtn"value="&times;" onclick="courseRemoveRow(2)">
						</div>
						<div class="col-65">
							<input type="text"placeholder="Course Code" name="TYCC2">
							<input type="text" placeholder="Course Name" name="TYCN2">
						</div>
						<div class="col-15right">
							<select name="TYgrade2" class="grade">
								<option selected disabled hidden>Grade</option>
								<option value="A+">A+</option>
								<option value="A">A</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B">B</option>
								<option value="C+">C+</option>
								<option value="C">C</option>
								<option value="C-">C-</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset id="TYCourse3">
					<legend>Course 3</legend>
					<div class="row">
						<div class="col-15left">
							<input type="button" class="courseAddBtn"value="+" onclick="courseAddRow()">
							<input type="button" class="courseRemoveBtn"value="&times;" onclick="courseRemoveRow(3)">
						</div>
						<div class="col-65">
							<input type="text"placeholder="Course Code" name="TYCC3">
							<input type="text" placeholder="Course Name" name="TYCN3">
						</div>
						<div class="col-15right">
							<select name="TYgrade3" class="grade">
								<option selected disabled hidden>Grade</option>
								<option value="A+">A+</option>
								<option value="A">A</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B">B</option>
								<option value="C+">C+</option>
								<option value="C">C</option>
								<option value="C-">C-</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
				</fieldset>

				<div class="row">
					<div class="col-45" style="float:left">
						<!--GPA-->
						<input type="text" id="TYgpa" name="TYgpa" placeholder="GPA" required>
					</div>
					<div class="col-45" style="float:right">
						<!--CGPA-->
						<input type="text" id="TYcgpa"name="TYcgpa" placeholder="CGPA" required>
					</div>
				</div>
				
			</div>

			<div id="instruction" class="tab">
				<h3>Instruction</h3>
				<p>This test contains 10 questions and aims to assess the critical thinking skills (CTS) of university computer science students.</p>
				<p>This test takes about 60 minutes to finish.</p>
				<p>Press "Start" button to start your assessment.</p>
				<p><input type="checkbox" name="confirm" value="confirm" required>I agree to the <a href="Term.html" id="termlink" target="_blank">Terms and Conditions</a></p>
								
			</div>
			<div style="overflow:auto;">
				<div>
					<input type="button" id="prevBtn" class="prevBtn" onclick="nextPrev(-1)" value="Previous">
					<input type="button" id="nextBtn"class="nextBtn" onclick="nextPrev(1)" value="Next">
				</div>
			</div>
			<!-- Circles which indicates the steps of the form: -->
			<div style="text-align:center;margin-top:40px;">
				<span class="step"></span>
				<span class="step"></span>
				<span class="step"></span>
				<span class="step"></span>
			</div>
		</form>
	</div>
	
	<script type="text/javascript" src="jquery-3.4.0.js"></script>
	<script type="text/javascript" src="formJS.js">	</script>
</body>
</html>