<!DOCTYPE html>
<html>
<body>


<?php
	define("scores1", [
    90, 98, 89, 100, 100, 86
	]);
	define("scores2", [
    40, 65, 77, 82, 80, 54, 73, 63, 95, 49
	]);
	$avg1 = 0; $avg2 = 0;

	#Average Scores for array 1
	echo "Average Scores for [";
	foreach(scores1 as $num){
		$avg1 = $avg1 + $num;
		echo $num . " ";
	}
	$avg1 = $avg1 / count(scores1);
	echo "] is " . round($avg1, 1) . "<br>Average grade is " . checkGrage($avg1) . "<br>";

	#Average Scores for array 2
	echo "Average Scores for [";
	foreach(scores2 as $num){
		$avg2 = $avg2 + $num;
		echo $num . " ";
	}
	$avg2 = $avg2 / count(scores2);
	echo "] is " . round($avg2, 1) . "<br>Average grade is " . checkGrage($avg2) . "<br>";

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