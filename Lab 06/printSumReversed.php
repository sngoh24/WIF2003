<!DOCTYPE html>
<html>
<body>

<?php
	$num1 = $_POST["num1"];
	$num2 = $_POST["num2"];
	echo "Original values are " . $num1 . ", " . $num2 . "<br>";

	//reversed the values
	function reverseInteger($num){
		return strrev($num);
	}

	function computeReverseSum($num1, $num2){
		return ($num1 + $num2);
	}

	//compute the values
	echo "Sum of the reversed numbers are ";
	$sum = computeReverseSum(reverseInteger($num1), reverseInteger($num2));
	echo $sum;
?>

</body>
</html>