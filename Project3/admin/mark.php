<!DOCTYPE html>
<?php 
session_start();
// login failed
if(!($_SESSION['login'] || $_SESSION['username'] || $_SESSION['password'] || $_SESSION['login'] == true)){
	header('location: login.php');
}

include ('connect.php');

$sqlPage = '
SELECT 		COUNT(id) 
FROM 		message
WHERE NOT 	status =  0';
$resultPage 	= $conn->query($sqlPage);  
$rowPage 		= $resultPage->fetch_row();  
$total_records 	= $rowPage[0];  
?>
<html>
<head>
	<!-- css file -->
	<link rel="stylesheet" type="text/css" href="admin.css">

	<!-- icon -->
	<link rel="shortcut icon" href="../Brain Logo.png">
	
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	
	<title>Critical Thinking Skills (Admin)</title>
</head>

<body>
	<!-- Navigation bar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="home.php">
			<img src= "../Brain Logo.png" style="width: 50px; height: 50px">
			<span style="font-size:30px">Critical Thinking Skills (Admin)</span></a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size:20px;">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="home.php">HOME</a>
					</li>
					<li class="nav-item dropdown active">
						<a class="nav-link dropdown-toggle" href="questions.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">MARKING</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="questions.php">QUESTIONS</a>
							<a class="dropdown-item active" href="marking.php">MARKING</a>
							<span class="sr-only">(current)</span> 
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="ranking.php">RANKING</a> 
					</li>
					<li class="nav-item">
						<a class="nav-link" href="participants.php">PARTICIPANTS</a> 
					</li>
					<li class="nav-item">
						<a class="nav-link" href="users.php">USERS</a> 
					</li>
					<li class="nav-item">
						<a class="nav-link" href="message.php">INBOX <span class="badge badge-light"><?php echo $total_records; ?></span></a>
					</li>
				</ul>
				<a class="btn btn-warning" style="font-weight: bold" href="logout.php">LOG&nbspOUT</a>
			</div>
		</nav>
		
		<div class="container1">
			<?php	
				//Get mark id
				if(isset($_GET['mark'])){
						$id = $_GET['mark'];
						$sql = "SELECT type, id FROM ans WHERE quesID = '$id'";
						$result = $conn->query($sql);unset($typeID);								
						$typeID = array();
						while($row = $result->fetch_assoc()) {
							$type = $row["type"];									
							array_push($typeID, $row["id"]);
						}
				}			
			?>
			<form action = "mark.php?mark=<?php echo $id?>" method="POST" style="width: 100%">
				<table id="DynamicTable" class="table table-hover">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Matric No</th>
						<th scope="col">Answer</th>
						<th scope="col">Score</th>	 
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php					
					$testID = array();
					$sql = "SELECT id FROM test";
					$result = $conn->query($sql);	
					while($row = $result->fetch_assoc()) {
						array_push($testID, $row["id"]);
					}
					$noOfParticipant = sizeof($testID);
										
					for($i = 0; $i < $noOfParticipant; $i ++){							
					echo '<tr>';
						echo '<td>';
						//No.
							echo $i + 1;
						echo '</td>';
						echo '<td>';
						//Display matric no
							$sql = "SELECT participantid FROM test WHERE id = '$testID[$i]'";
							$result = $conn->query($sql);
							$participantid = 0;
							while($row = $result->fetch_assoc()) {
								$participantid = $row["participantid"];
							}

							$sql = "SELECT matricNo FROM participant WHERE id = '$participantid'";
							$result = $conn->query($sql);
							$matricNo = "";
							while($row = $result->fetch_assoc()) {
								$matricNo = $row["matricNo"];
							}
							echo $matricNo;
						echo '</td>';
						echo '<td  style ="text-align: left;">';
						//Display ans
						//Display ans type text
						if($type == 5){
							$typeTable = "ans_type_textbox";
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = '$typeID[0]'";
									$result = $conn->query($sql);	
									$userAns = "";
									while($row = $result->fetch_assoc()) {
										$userAns = $row["ans"];
									}
									echo $userAns;											
						}	
						//Display ans type file
						if($type == 2){
							$typeTable = "ans_type_file";
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = '$typeID[0]'";
									$result = $conn->query($sql);	
									$userAns = "";
									while($row = $result->fetch_assoc()) {
										$userAns = $row["ans"];
									}
									echo $userAns;											
						}
						//Display ans type checkbox
						if($type == 1){
								$typeTable = "ans_type_checkbox";
								for($s = 0; $s < sizeof($typeID);$s ++){
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);
								$userAns = array();							
								while($row = $result->fetch_assoc()) {
									array_push($userAns, $row["ans"]);
								}	
								$sql = "SELECT value FROM ans_type_checkbox WHERE ans = 1 AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);	
								$correctAns = array();
								while($row = $result->fetch_assoc()) {
									array_push($correctAns, $row["value"]);								
								}
								$sql = "SELECT value FROM ans_type_checkbox WHERE ansID = '$typeID[$s]'";
								$result = $conn->query($sql);
								unset($options);
								$options = array();
								while($row = $result->fetch_assoc()) {
									array_push($options, $row["value"]);
								}			
								$bool = false;
								$zz= 0;
									for($q = 0; $q < sizeof($options); $q++)
									{						
										for($z = 0; $z < sizeOf($userAns); $z ++){
											if(strcmp($options[$q], $userAns[$z]) == 0)
											{		
												$bool = true;
												$zz = $z;
												$z = sizeOf($userAns);
											}
											else{	
												$bool = false;
												$zz = $z;
											}											
										}
										if($bool){
											$sql = "SELECT value FROM ans_type_checkbox WHERE ans = 1 AND ansID = '$typeID[$s]'";
											$result = $conn->query($sql);	
											$correctAns = array();
											while($row = $result->fetch_assoc()) {
												array_push($correctAns, $row["value"]);								
											}
											$hightlight= false;
											for($c = 0; $c < sizeof($correctAns); $c ++){
												if($correctAns[$c] == $userAns[$zz]){	
													$highlight = true;
													break;													
												}
												else{		
													$highlight = false;												
												}
											}
											if($highlight){
												//Highlight answer in green if correct
												echo '<input type="checkbox" name="newCheckbox['.$typeID[$s].']['.$q.']" value="'.$userAns[$zz].'" checked="checked" disabled>'.'<span style="background-color: #cff9d5">'.$userAns[$zz].'&nbsp;&nbsp;&nbsp;&nbsp;</span><br>';
												echo '<input type= "hidden" name="checkboxID" value="'.$typeID[0].'">';
											}
											else{
												//Highlight answer in red if incorrect
												echo '<input type="checkbox" name="newCheckbox['.$typeID[$s].']['.$q.']" value="'.$userAns[$zz].'" checked="checked" disabled>'.'<span style="background-color: #fcdddb">'.$userAns[$zz].'&nbsp;&nbsp;&nbsp;&nbsp;</span><br>';
												echo '<input type= "hidden" name="checkboxID" value="'.$typeID[0].'">';
											}
										}
										else{
											echo '<input type="checkbox" name="newCheckbox['.$typeID[$s].']['.$q.']" value="'.$options[$q].'" disabled>'.$options[$q].'<br>';	
											echo '<input type= "hidden" name="checkboxID" value="'.$typeID[0].'">';
										}														
										}
									}
									echo "<br>";								
						}
						//Display ans type number
						if($type == 3){
							for($y = 0; $y < sizeof($typeID); $y ++){
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = $typeID[$y]";
								$result = $conn->query($sql);
								$row = $result->fetch_assoc();
								$userAns = $row['ans'];
									
									$sql = "SELECT ans FROM ans_type_number WHERE ansID = $typeID[$y]";
									$result = $conn->query($sql);
										$row = $result->fetch_assoc();
										$correctAns = $row['ans'];
									if($userAns == $correctAns){
										//Highlight answer in green if correct
										echo '<span style="background-color: #cff9d5">'.$userAns.'&nbsp;&nbsp;&nbsp;&nbsp;</span><br><br>';
									}
									else{
										//Highlight answer in red if incorrect
										echo '<span style="background-color: #fcdddb">'.$userAns.'&nbsp;&nbsp;&nbsp;&nbsp;</span><br><br>';
									}
							}							
						}	
						//Display ans type radiobutton
						if($type == 4){														
							for($s = 0; $s < sizeof($typeID);$s ++){								
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);
								$userAns = "";							
								while($row = $result->fetch_assoc()) {
									$userAns = $row["ans"];
								}													
								$sql = "SELECT label, value FROM ans_type_radiobutton WHERE ans = 1 AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);	
								$correctAns = "";
								$label = "";
								while($row = $result->fetch_assoc()) {
									$correctAns = $row["value"];
									$label = $row["label"];
								}
								$sql = "SELECT value FROM ans_type_radiobutton WHERE ansID = '$typeID[$s]'";
								$result = $conn->query($sql);
								unset($options);
								$options = array();
								while($row = $result->fetch_assoc()) {
									array_push($options, $row["value"]);
								}			
								
								$sql = "SELECT label, value FROM ans_type_radiobutton WHERE ans = 1 AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);	
								$correctAns = "";
								$label = "";
								while($row = $result->fetch_assoc()) {
									$correctAns = $row["value"];
									$label = $row["label"];
								}		
								$highlight = false;
								if(empty($label)){
									$label = 0;
								}
								else{
									echo '<label>'.$label.'</label><br>';
								}	
									for($q = 0; $q < sizeof($options); $q++)
									{										
										if(strcmp($options[$q], $userAns) == 0)
										{				
												if($userAns == $correctAns){
													$highlight = true;
												}
												else{
													$highlight = false;
												}												
											
											if($highlight){
												//Highlight answer in green if correct
												echo '<input type="radio" name= "newRadio['.$typeID[$s].']['.$testID[$i].']" value="'.$userAns.'" checked="checked" disabled>'.'<span style="background-color: #cff9d5">'.$userAns.'&nbsp;&nbsp;&nbsp;&nbsp;</span><br>';
											}
											else{
												//Highlight answer in red if incorrect
												echo '<input type="radio" name= "newRadio['.$typeID[$s].']['.$testID[$i].']" value="'.$userAns.'" checked="checked" disabled>'.'<span style="background-color: #fcdddb" >'.$userAns.'&nbsp;&nbsp;&nbsp;&nbsp;</span><br>';
											}
										}
										else{											
											echo '<input type="radio" name="newRadio['.$typeID[$s].']['.$testID[$i].']" value="'.$options[$q].'" disabled>'.$options[$q].'<br>';												
										}
									}									
									echo "<br>";
								}						
						}							
						echo '</td>';
						echo '<td>';
						//Display score	
						//Display score and allow updating of score for ans type text
						if($type == 5){						
							$sql = "SELECT score FROM test_answer WHERE ansID = '$typeID[0]' AND testID = '$testID[$i]'";
							$result = $conn->query($sql);	
							$initialScore = 0;
							$row = $result->fetch_assoc();
							$initialScore = $row["score"];
							echo '<input class="form-control"  type="number" min = "0" max = "5" name="newTextScore['.$testID[$i].']" style = "width: 100%" value="'.$initialScore.'">';
				
							if(isset($_POST['newTextScore'])){
								$newTextScore = $_POST['newTextScore'];
								foreach($newTextScore as $key =>$value){
										$sql = "UPDATE test_answer SET score = '$value' WHERE ansID = '$typeID[0]' AND testID = '$key'";					
										$result = $conn->query($sql);
								}		
								echo "<meta http-equiv='refresh' content='0;url=mark.php?mark=".$id."'>";					
							}								
						}
						//Display score and allow updating of score for ans type file
						if($type == 2){						
							$sql = "SELECT score FROM test_answer WHERE ansID = '$typeID[0]' AND testID = '$testID[$i]'";
							$result = $conn->query($sql);	
							$initialScore = 0;
							$row = $result->fetch_assoc();
							$initialScore = $row["score"];
							echo '<input class="form-control"  type="number" min = "0" max = "5" name="newFileScore['.$testID[$i].']" style = "width: 100%" value="'.$initialScore.'">';
							if(isset($_POST['newFileScore'])){
								$newFileScore = $_POST['newFileScore'];
								foreach($newFileScore as $key =>$value){
										$sql = "UPDATE test_answer SET score = '$value' WHERE ansID = '$typeID[0]' AND testID = '$key'";					
										$result = $conn->query($sql);
								}		
								echo "<meta http-equiv='refresh' content='0;url=mark.php?mark=".$id."'>";					
							}								
						}
						//Display score ans type checkbox
						if($type == 1){
							$score = 0;
								$typeTable = "ans_type_checkbox";
								for($s = 0; $s < sizeof($typeID);$s ++){
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);
								$userAns = array();							
								while($row = $result->fetch_assoc()) {
									array_push($userAns, $row["ans"]);
								}	
								$sql = "SELECT value FROM ans_type_checkbox WHERE ans = 1 AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);	
								$correctAns = array();
								while($row = $result->fetch_assoc()) {
									array_push($correctAns, $row["value"]);								
								}
								$sql = "SELECT value FROM ans_type_checkbox WHERE ansID = '$typeID[$s]'";
								$result = $conn->query($sql);
								unset($options);
								$options = array();
								while($row = $result->fetch_assoc()) {
									array_push($options, $row["value"]);
								}			
								$bool = false;
								$zz= 0;
									for($z = 0; $z < sizeof($userAns); $z++)
									{						
										for($q = 0; $q < sizeOf($correctAns); $q ++){
											if(strcmp($correctAns[$q], $userAns[$z]) == 0)
											{		
												$bool = true;
												$zz = $z;
												$sql = "UPDATE test_answer SET score = 5 WHERE ansID = '$typeID[$s]' AND testID = '$testID[$i]' AND ans = '$correctAns[$q]'";
												$result = $conn->query($sql);											
												$score = $score + 5;												
											}
											else{	
												$bool = false;
												$zz = $z;									
											}											
										}
									}
									echo $score;
									echo "<br>";
								}
						}
						//Display score ans type number
						if($type == 3){
							$score = 0;
							for($y = 0; $y < sizeof($typeID); $y ++){
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = $typeID[$y]";
								$result = $conn->query($sql);								
								$ans = 0;
									$row = $result->fetch_assoc();
									$ans = $row['ans'];
									$sql = "SELECT ans FROM ans_type_number WHERE ansID = $typeID[$y]";
									$result = $conn->query($sql);
										$row = $result->fetch_assoc();
										$correctAns = $row['ans'];
										
										if($ans == $correctAns){
											$sql = "UPDATE test_answer SET score = 5 WHERE ansID = $typeID[$y] AND testID = '$testID[$i]'";
											$result = $conn->query($sql);
											$score = 5;
										}
								echo $score."<br>";
							}		
						}
						//Display score ans type radiobutton
						if($type == 4){
							$score = 0;
							$s = 0;
							for($s = 0; $s < sizeof($typeID);$s ++){
								$sql = "SELECT ans FROM test_answer WHERE testID = '$testID[$i]' AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);	
								$userAns = "";							
								while($row = $result->fetch_assoc()) {
									$userAns = $row["ans"];
								}									
								$sql = "SELECT label, value FROM ans_type_radiobutton WHERE ans = 1 AND ansID = '$typeID[$s]'";
								$result = $conn->query($sql);	
								$correctAns = "";
								$label = "";
								while($row = $result->fetch_assoc()) {
									$correctAns = $row["value"];
									$label = $row["label"];
								}
								$sql = "SELECT value FROM ans_type_radiobutton WHERE ansID = '$typeID[$s]'";
								$result = $conn->query($sql);
								unset($options);
								$options = array();
								while($row = $result->fetch_assoc()) {
									array_push($options, $row["value"]);
								}			
								if(empty($label)){
									$label = 0;
								}	
									for($q = 0; $q < sizeof($options); $q++)
									{										
										if(strcmp($correctAns, $userAns) == 0)
										{											
											$sql = "UPDATE test_answer SET score = 5 WHERE ansID = '$typeID[$s]' AND testID = '$testID[$i]'";
											$result = $conn->query($sql);
											$score = 5;
										}
										else{											
											$sql = "UPDATE test_answer SET score = 0 WHERE ansID = '$typeID[$s]' AND testID = '$testID[$i]'";
											$result = $conn->query($sql);
											$score = 0;		
										}										
									}
								}								
								$displayScore = 0;
								for($m = 0; $m < sizeOf($typeID); $m ++){
									$sql = "SELECT score FROM test_answer WHERE ansID = '$typeID[$m]' AND testID = '$testID[$i]'";
									$result = $conn->query($sql);
									while($row = $result->fetch_assoc()) {
										$displayScore = $displayScore + $row["score"];
									}
								}
								echo $displayScore."<br>";							
						}							
						echo'</td>';
						echo '<td>';
						//action	
						//Allow update of score if ans are type text or file
						if($type == 5 OR $type == 2){
							echo '<input class="btn btn-success" type="submit" value="Update"><br><br>';
						}
						//Cancel button
						echo"<input class='btn btn-secondary' type=\"button\" name=\"cancel\" value=\"Cancel\" onclick=\"window.location='marking.php'\">";
						echo '</td>';
					echo '</tr>';
					
					//Calculate total score for each participant after marking
					$sql = "SELECT score FROM test_answer WHERE testID = '$testID[$i]'";
					$result = $conn->query($sql);
						$ts = array();
					$total = 0;						
					while($row = $result->fetch_assoc()){
						array_push($ts, $row["score"]);
						$total = $total + $row["score"];
					}							
					$sql = "UPDATE test SET totalScore = '$total' WHERE id = '$testID[$i]'";
					$result = $conn->query($sql);
					}					
					?>
				</tbody>
			</table>
			</form>
			
		</div>

		<!--Here the footer-->
		<footer style=" position: fixed">
			&copy 2019 - CREATIVEBRAIN
		</footer>

		<!--JS Files-->
		<script>
			$('#DyanmicTable').SetEditable({ $addButton: $('#addNewRow')});
		</script>
		<script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
		<script src="bootstable.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-	q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"	crossorigin="anonymous"></script>
		<script	src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-	JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"crossorigin="anonymous"></script>
	</body>
	</html>









