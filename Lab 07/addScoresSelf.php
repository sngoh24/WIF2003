<!DOCTYPE html>
<html>
<body>
<h1>Enter Scores:</h1>
<form method="post"
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Score 1 <input type="text" name="score1"/><br/>
Score 2 <input type="text" name="score2"/><br/>
Score 3 <input type="text" name="score3"/><br/>
Score 4 <input type="text" name="score4"/><br/>
Score 5 <input type="text" name="score5"/><br/>
Score 6 <input type="text" name="score6"/><br/><br/>
<input type="submit">
</form>
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
</body>
</html>