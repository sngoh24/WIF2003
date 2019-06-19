<?php 
session_start();

include_once('connect.php');

if(isset($_POST["matricNo"])){
	//personal details
	$matricNo 	= $_POST["matricNo"];
	$university	= $_POST["university"];
	$faculty 	= $_POST["faculty"];
	$course 	= $_POST["course"];
	$yearstudy 	= $_POST["yearstudy"];
	$gender 	= $_POST["gender"];
	$age 		= $_POST["age"];
	$ethnic 	= $_POST["ethnic"];
	$nation 	= $_POST["nation"];
	$email 		= $_POST["email"];

			//insert personal detail into partipant db
	$sql = "
	INSERT INTO participant (matricNo, university, faculty, course, yearofStudy, gender, age, ethnic, nationality, email) 
	VALUES ('$matricNo', '$university', '$faculty', '$course','$yearstudy','$gender','$age','$ethnic','$nation','$email')
	";
	$result = $conn->query($sql);
	$id = $conn->insert_id;

			//insert past year examination result into result db
	if(isset($_POST["PYYear"])){
		insertResult($id, "PY");
	}

			//insert this year examination result into result db
	if(isset($_POST["TYYear"])){
		insertResult($id, "TY");		
	}
	
			// if matric no not yet registred
	$_SESSION['login'] 		= true;
	$_SESSION['id'] 		= $id;
	$_SESSION['matricNo'] 	= $matricNo;
	header('Location: questions.php?action=success#Q1');
}

function insertResult($id, $yr){
	include('connect.php');
	//insert  result into result db
	$id	= $id;
	if($yr == 'PY') {
		$yrInt = 1;
	} else {
		$yrInt = 2;
	}
	$Year 	= $_POST[$yr . "Year"];
	$Sem 	= $_POST[$yr . "Sem"];
	$GPA 	= $_POST[$yr . "gpa"];
	$CGPA 	= $_POST[$yr . "cgpa"];

	$sql = "
	INSERT INTO participant_result (participantid, type, year, sem, GPA, CGPA) 
	VALUES ('$id', '$yrInt', '$Year', '$Sem', '$GPA', '$CGPA')";
	$conn->query($sql) or die($conn->error);

	for($i = 1; $i < 10; $i++) {
		//insert course into participant_result db
		if(isset($_POST[$yr . "CC" . $i])){
			$CC 	= $_POST[$yr . "CC" . $i];
			$CN 	= $_POST[$yr . "CN" . $i];
			$grade 	= $_POST[$yr . "grade" . $i];

			$sql = "INSERT INTO participant_result_course (participantid, type, year, sem, courseCode, courseName, grade) VALUES ('$id', '$yrInt', '$Year', '$Sem', '$CC', '$CN', '$grade')";
			$conn->query($sql);
		}
	}
}
?>