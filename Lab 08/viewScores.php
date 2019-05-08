<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	try 
	{
		include("config.php");
		echo '<a href="addScores.php">Add New Scores</a><br><br>';
		$id 	= $_GET['id'];

		$sql 	= "
		SELECT * 
		FROM scores
		WHERE ScoreID = $id;
		";
		$stmt 	= $conn->query($sql);
		$row 	= $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	?>

	<form method="post" action="editScores.php">
		Score 1 <input type="text" name="score1" value="<?php echo $row['Score1'];?>"><br>
		Score 2 <input type="text" name="score2" value="<?php echo $row['Score2'];?>"><br>
		Score 3 <input type="text" name="score3" value="<?php echo $row['Score3'];?>"><br>
		Score 4 <input type="text" name="score4" value="<?php echo $row['Score4'];?>"><br>
		Score 5 <input type="text" name="score5" value="<?php echo $row['Score5'];?>"><br>
		Score 6 <input type="text" name="score6" value="<?php echo $row['Score6'];?>"><br>

		<input type="hidden" name="ScoreID" value="<?php echo $row['ScoreID'];?>"><br>
		<input type="hidden" name="StudentID"  value="<?php echo $row['StudentID'];?>"><br>
		<br>
		<input type="submit" name="update" value="Update">
		<input type="submit" name="delete" value="Delete" onClick="return confirm('Are you sure you want to delete?')">
	</form>
</body>
</html>

