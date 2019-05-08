<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
$score1 = $_POST['score1'];
$score2 = $_POST['score2'];
$score3 = $_POST['score3'];
$score4 = $_POST['score4'];
$score5 = $_POST['score5'];
$score6 = $_POST['score6'];

$scores = array($score1, $score2, $score3,$score4, $score5, $score6);

$avg = 0;

echo "Average Scores for [";
foreach($scores as $num){
	$avg = $avg + $num;
	echo $num . " ";
}
$avg = $avg / count($scores);
echo "] is " . 
	round($avg, 1) . 
	"<br>Average grade is " . 
	checkGrage($avg) . "<br>";
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