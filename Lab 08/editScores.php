
<?php
try 
{
	if(isset($_POST["update"])){
		include("config.php");

		$id 		= $_POST["ScoreID"];
		$studentID 	= $_POST['StudentID'];
		$score1 	= $_POST['score1'];
		$score2 	= $_POST['score2'];
		$score3 	= $_POST['score3'];
		$score4 	= $_POST['score4'];
		$score5 	= $_POST['score5'];
		$score6 	= $_POST['score6'];

		$scores 	= array($score1, $score2, $score3, $score4, $score5, $score6);
		$avg 	= calcAvg($scores);
		$grade 	= checkGrage($avg);

		$sql 	= "
		UPDATE scores
		SET Score1 	= '$score1', 
		Score2 	= '$score2', 
		Score3 	= '$score3', 
		Score4 	= '$score4', 
		Score5 	= '$score5', 
		Score6 	= '$score6', 
		Average = '$avg', 
		Grade 	= '$grade'
		WHERE ScoreID = $id;
		";
		$stmt 	= $conn->prepare($sql);
		$stmt->execute();

		echo 'Record updated successfully for ' . $studentID;
		echo '<br><a href="addScores.php">Add New Scores</a><br><br>';
	}
	elseif(isset($_POST['delete'])){
		include("config.php");
		$id 		= $_POST["ScoreID"];
		$sql 	= "
		DELETE FROM scores
		WHERE ScoreID = $id";
		$stmt 	= $conn->prepare($sql);
		$stmt->execute();

		echo 'Record deleted successfully';
		echo '<br><a href="addScores.php">Add New Scores</a><br><br>';
	}

}
catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}
$conn = null;
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
