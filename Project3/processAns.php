<?php
session_start();
//connect to db
include_once('connect.php');

if (isset($_SESSION['login']) && 
	isset($_SESSION['id']) &&
	isset($_SESSION['matricNo']) &&
	$_SESSION['login'] == true){

	$partID 	= $_SESSION['id'];
	$duration 	= $_POST['duration'];
	$duration 	= explode(":", $duration);
	$hour 		= $duration[0];
	$minutes	= $duration[1];
	$second		= $duration[2];
	$totalMin 	= ($hour) * 60 + $minutes + ($second / 60);
	$totalMin 	= round($totalMin, 2);
	$_SESSION['totalMin'] = $totalMin;	

	// get submission date and time
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$ts = time();
	$date = new DateTime;
	$date->setTimestamp($ts); 
	$date = $date->format('Y-m-d H:i:s');

	$sqlTest = "
	INSERT INTO test (participantid, duration, createdOn)
	VALUES ('$partID', '$totalMin', '$date')";
	$resultTest = $conn->query($sqlTest) or die($conn->error);
	$testID = $conn->insert_id;

	echo $_POST['submit'];
	if(isset($_POST['submit'])){
			// get all names from the questions
		$sqlName = "
		SELECT ansID AS ansID, name AS name 	
		FROM ans_type_textbox
		WHERE ansID 		IN (
		SELECT id 			FROM ans
		WHERE quesID 		IN (
		SELECT id 			FROM question
		WHERE status = 1))
		UNION
		SELECT ansID, name 	FROM ans_type_checkbox
		WHERE ansID 		IN (
		SELECT id 			FROM ans
		WHERE quesID 		IN (
		SELECT id 			FROM question
		WHERE status = 1))
		UNION
		SELECT ansID, name 	FROM ans_type_radiobutton
		WHERE ansID 		IN (
		SELECT id 			FROM ans
		WHERE quesID 		IN (
		SELECT id 			FROM question
		WHERE status = 1))
		UNION
		SELECT ansID, name 	FROM ans_type_number
		WHERE ansID 		IN (
		SELECT id 			FROM ans
		WHERE quesID 		IN (
		SELECT id 			FROM question
		WHERE status = 1))
		ORDER BY ansID
		";

		$resultName = $conn->query($sqlName) or die($conn->error);

		while($rowName = $resultName->fetch_row()){
			$ansID 	= $rowName[0];
			$name 	= $rowName[1];
			if(isset($_POST[$name])){
				$ans 	= $_POST[$name];
				$sqlAns = "INSERT INTO test_answer
				(testID, ansID, ans, createdOn)
				VALUES ('$testID', '$ansID', '$ans', '$date')";
				$resultAns = $conn->query($sqlAns) or die($conn->error);
			}
		}

		$sqlFile = "
		SELECT ansID, name 	FROM ans_type_file
		WHERE ansID 		IN (
		SELECT id 			FROM ans
		WHERE quesID 		IN (
		SELECT id 			FROM question
		WHERE status = 1))";

		$resultFile = $conn->query($sqlFile) or die($conn->error);

		while($rowFile = $resultFile->fetch_row()){
			$ansID 	= $rowFile[0];
			$name 	= $rowFile[1];
			if(isset($_FILES["$name"]["name"])){
				// target file
				$target_dir = 'uploads/';
				// file name
				$filename 	= $_FILES[$name]["name"];
				$currfile 	= $_FILES[$name]['tmp_name'];
				$filetype 	= $_FILES[$name]["type"];
				$filesize 	= $_FILES[$name]["size"];
				$fileerror 	= $_FILES[$name]['error'];

				// target file name
				$target_file = $target_dir . basename($_FILES[$name]["name"]);
				if (file_exists($target_file)) {
			    	echo "Sorry, file already exists.";
				} elseif(move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)){
					// upload file
					echo "The file ". basename($_FILES[$name]["name"]). " has been uploaded.";
					$sqlFile = "
					INSERT INTO file (name, type, size, error)
					VALUES ('$filename', '$filetype', '$filesize', '$fileerror')";
					$conn->query($sqlFile) or die($conn->error);
					$fileid = $conn->insert_id;

					$sqlAns = "INSERT INTO test_answer
					(testID, ansID, ans, createdOn)
					VALUES ('$testID', '$ansID', '$fileid', '$date')";
					$conn->query($sqlAns) or die($conn->error);
					
				} else {
					echo "Possible file upload attack!\n";
				}
			}
		}
	}
	header('Location: result.php');
} else {
	header('Location: form.php');
}
?>



