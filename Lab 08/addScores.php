<!DOCTYPE html>
<html>
<body>
	
	<h1>Enter Scores:</h1>
	<form method="POST" action="grader.php" >
		Student<input list="students" name="studentid">
		<datalist id="students">
			<?php
			try {
				include("config.php");
				$sql = "SELECT * FROM students";
				$stmt = $conn->query($sql); 
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<option value="' . $row["StudentID"] . '">';
				}
			}
			catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
			?>
		</datalist>
		<br><br>
		Score 1 <input type="text" name="score1"><br>
		Score 2 <input type="text" name="score2"><br>
		Score 3 <input type="text" name="score3"><br>
		Score 4 <input type="text" name="score4"><br>
		Score 5 <input type="text" name="score5"><br>
		Score 6 <input type="text" name="score6"><br>
		<br>
		<input type="submit">
	</form>
</body>
</html>
