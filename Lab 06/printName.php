<!DOCTYPE html>
<html>
<body>


<?php
	function printName($name, $num){
		for($count = 0; $count < $num; $count++){
			echo $name . " <br>";
		}
		return 0;
	}
	printName("A", 10);
?>

</body>
</html>