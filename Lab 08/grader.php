<?php
if($_SERVER["REQUEST_METHOD"] == "POST" OR $_SERVER["REQUEST_METHOD"] == "GET"){
	$studentID 	= $_REQUEST['studentid'];
	$score1 	= $_REQUEST['score1'];
	$score2 	= $_REQUEST['score2'];
	$score3 	= $_REQUEST['score3'];
	$score4 	= $_REQUEST['score4'];
	$score5 	= $_REQUEST['score5'];
	$score6 	= $_REQUEST['score6'];

	$scores 	= array($score1, $score2, $score3, $score4, $score5, $score6);

	echo "You have entered 6 scores for " . $studentID . "<br>";
	echo "Average Scores for [";
	foreach($scores as $num){
		echo $num . " ";
	}
	$avg 	= calcAvg($scores);
	$grade 	= checkGrage($avg);

	echo "] is " . $avg . "<br>Average grade is " . $grade . "<br><br>";

	try 
	{
		include("config.php");
		$sql = "
		INSERT INTO scores (StudentID, Score1, Score2, Score3, Score4, Score5, Score6, Average, Grade)
		VALUES ('$studentID', '$score1', '$score2', '$score3', '$score4', '$score5', '$score6', '$avg', '$grade')";
		$conn->exec($sql);

		$last_id = $conn->lastInsertId();
		echo "New record created successfully. Last inserted ID is: "  . $last_id . "<br>";
		
		echo '<br><a href="viewScores.php?id=' . $last_id . '">View Scores</a><br>';

		echo '<br><a href="addScores.php">Add New Scores</a><br><br>';
		$conn = null;
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

function calcAvg($arr){
	$avg = 0;
	foreach($arr as $num){
		$avg = $avg + $num;
	}
	$avg 	= $avg / count($arr);
	return round($avg, 1);
}

function checkGrage($avg){
	if($avg == 0){
		return "F";
	}else if($avg < 20){
		return "E";
	}else if($avg < 40){
		return "D";
	}else if($avg < 60){
		return "C";
	}else if($avg < 80){
		return "B";
	}else{
		return "A";
	}
}

?>