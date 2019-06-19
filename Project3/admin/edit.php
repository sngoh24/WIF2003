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
						<a class="nav-link dropdown-toggle" href="questions.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">QUESTIONS</a>
						<div class="dropdown-menu">
							<a class="dropdown-item active" href="questions.php">QUESTIONS</a>
							<span class="sr-only">(current)</span> 
							<a class="dropdown-item" href="marking.php">MARKING</a>
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
			if(isset($_GET['edit'])){
					//Get edit id
				$id = $_GET['edit'];
				$sql = "SELECT * FROM question WHERE id = '$id'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$status = $row['status'];
				$score = $row['score'];
			}
				//Update question
			if(isset($_POST['newQues'])){
				$newQues = $_POST['newQues'];
				$id = $_POST['id'];
				$sql = "UPDATE question SET title = '$newQues' WHERE id = '$id'";
				$result = $conn->query($sql);				
				echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
			} 
				//Update answer type number
			if(isset($_POST['newNumber'])){
				$newNumber = $_POST['newNumber'];
				$totalScore = 0;
				foreach($newNumber as $key =>$value){
					foreach($value as $key1 => $value1){
						$sql = "UPDATE ans_type_number SET ans = '$value1' , score = 5 WHERE ansID = '$key'";					
						$result = $conn->query($sql);
						$totalScore = $totalScore + 5;
					}
				}						
				$sql = "UPDATE question SET score = '$totalScore' WHERE id = '$id'";					
				$result = $conn->query($sql);				
				echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
			}	
				//Update answer type checkbox
			if(isset($_POST['newCheckbox'])){
				$newCheckbox = $_POST['newCheckbox'];
				$checkboxID = $_POST['checkboxID'];
				$sql1 = "UPDATE ans_type_checkbox SET ans = 0, score = 0 WHERE ansID = '$checkboxID'";
				$result = $conn->query($sql1);
				$totalScore = 0;
				foreach($newCheckbox as $key =>$value){
					foreach($value as $key1 => $value1){
						$sql = "UPDATE ans_type_checkbox SET ans = 1, score = 5 WHERE ansID = '$key' AND value = '$value1'";						
						$result = $conn->query($sql);	
						$totalScore = $totalScore + 5;	
					}
				}				
				$sql = "UPDATE question SET score = '$totalScore'WHERE id = '$id'";					
				$result = $conn->query($sql);
				echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
			}
				//Update answer type radiobutton
			if(isset($_POST['newRadio'])){
				$newRadio = $_POST['newRadio'];					
				foreach($newRadio as $key =>$value){
					foreach($value as $key1 => $value1){
						$sql = "UPDATE ans_type_radiobutton SET ans = 0, score = 0 WHERE ansID = '$key1'";					
						$result = $conn->query($sql);
					}
				}	
				$totalScore = 0;
				foreach($newRadio as $key =>$value){
					foreach($value as $key1 => $value1){
						$sql = "UPDATE ans_type_radiobutton SET ans = 1, score = 5 WHERE ansID = '$key1' AND value = '$value1'";					
						$result = $conn->query($sql);
						$totalScore = $totalScore + 5;						
					}
				}		
				$sql = "UPDATE question SET score = '$totalScore'WHERE id = '$id'";					
				$result = $conn->query($sql);					
				echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
			}	
				//Update answer type text
			if(isset($_POST['newText'])){
				$newText = $_POST['newText'];
				$textID = $_POST['textID'];
				$totalScore = 0;
				$sql = "UPDATE ans_type_textbox SET ans = '$newText', score = 5 WHERE ansID = '$textID'";
				$result = $conn->query($sql);
				$totalScore = $totalScore + 5;
				$sql = "UPDATE question SET score = '$totalScore'WHERE id = '$id'";					
				$result = $conn->query($sql);
				echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
			}
				//Update answer type file
			if(isset($_POST['newFile'])){
				$newFile = $_POST['newFile'];
				$fileID = $_POST['filetID'];
				$totalScore = 0;
				$sql = "UPDATE ans_type_file SET ans = '$newFile', score = 5 WHERE ansID = '$fileID'";
				$result = $conn->query($sql);
				$totalScore = $totalScore + 5;
				$sql = "UPDATE question SET score = '$totalScore'WHERE id = '$id'";					
				$result = $conn->query($sql);
				echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
			}
				//Update status
			if(isset($_POST['newStatus'])){
				$newStatus = $_POST['newStatus'];
				$id = $_POST['id'];
				$sql = "UPDATE question SET status = '$newStatus' WHERE id = '$id'";
				$result = $conn->query($sql);
				echo "<meta http-equiv='refresh' content='0;url=questions.php'>";
			}
			?>
			<form action = "edit.php?edit=<?php echo $id ?>" method="POST">
				<table id="DynamicTable" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Questions</th>
							<th scope="col">Answers</th>
							<th scope="col">Status</th>
							<th scope="col">Score</th> 	 
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<textarea rows=10 cols=80 name="newQues"><?php echo $row['title']; ?></textarea>
								<input type= "hidden" name="id" value="<?php echo $row['id']; ?>">
							</td>
							<td style ="text-align: left;">
								<?php
								$sql = "SELECT type, id FROM ans WHERE quesID = '$id'";
								$result = $conn->query($sql);
								unset($typeID);								
								$typeID = array();
								while($row = $result->fetch_assoc()) {
									$type = $row["type"];									
									array_push($typeID, $row["id"]);
								}
							//Display initial answer for type checkbox
								if($type == 1){
									$typeTable = "ans_type_checkbox";
									for($s = 0; $s < sizeof($typeID);$s ++){
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
											for($z = 0; $z < sizeOf($correctAns); $z ++){
												if(strcmp($options[$q], $correctAns[$z]) == 0)
												{		
													$bool = true;
													$zz = $z;
													$z = sizeOf($correctAns);
												}
												else{	
													$bool = false;
													$zz = $z;
												}		
											}
											if($bool){
												echo '<input type="checkbox" name="newCheckbox['.$typeID[$s].']['.$q.']" value="'.$correctAns[$zz].'" checked="checked">'.$correctAns[$zz].'<br>';
												echo '<input type= "hidden" name="checkboxID" value="'.$typeID[0].'">';		
											}
											else{
												echo '<input type="checkbox" name="newCheckbox['.$typeID[$s].']['.$q.']" value="'.$options[$q].'">'.$options[$q].'<br>';	
												echo '<input type= "hidden" name="checkboxID" value="'.$typeID[0].'">';
											}
										}
										echo "<br>";
									}
								}
							//Display initial answer for type file
								if($type == 2){
									$typeTable = "ans_type_file";
									$sql = "SELECT ans FROM ans_type_file WHERE ansID = '$typeID[0]'";
									$result = $conn->query($sql);	
									$correctAns = "";
									while($row = $result->fetch_assoc()) {
										$correctAns = $row["ans"];
									}
									echo '<input type="file" name="newFile" style="width: 100%" value="'.$correctAns.'">';
									echo '<input type= "hidden" name="fileID" value="'.$typeID[0].'">';
								}
							//Display initial answer for type number
								if($type == 3){
									$typeTable = "ans_type_number";
									for($s = 0; $s < sizeof($typeID);$s ++){
										$sql = "SELECT label, ans FROM ans_type_number WHERE ansID = '$typeID[$s]'";
										$result = $conn->query($sql);	
										$correctAns = "";
										$label = "";
										while($row = $result->fetch_assoc()) {										
											$label = $row["label"];
											$correctAns = $row["ans"];
										}
										echo '<label>'.$label.'</label>';
										echo '<input type="number" name="newNumber['.$typeID[$s].']['.$s.']" value="'.$correctAns.'">'; 
										echo '<input type= "hidden" name="numberID['.$s.']" value="'.$typeID[$s].'">';
									}
								}
							//Display initial answer for type radiobutton
								if($type == 4){
									$typeTable = "ans_type_radiobutton";
									for($s = 0; $s < sizeof($typeID);$s ++){
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
										else{
											echo '<label>'.$label.'</label><br>';
										}	
										for($q = 0; $q < sizeof($options); $q++)
										{										
											if(strcmp($options[$q], $correctAns) == 0)
											{		
												echo '<input type="radio" name= "newRadio['.$label.']['.$typeID[$s].']" value="'.$correctAns.'" checked="checked">'.$correctAns.'<br>';	
											}
											else{	
												echo '<input type="radio" name="newRadio['.$label.']['.$typeID[$s].']" value="'.$options[$q].'">'.$options[$q].'<br>';
											}
										}
										echo "<br>";
									}
								}
							//Display initial answer for type text
								if($type == 5){
									$typeTable = "ans_type_textbox";
									$sql = "SELECT ans FROM ans_type_textbox WHERE ansID = '$typeID[0]'";
									$result = $conn->query($sql);	
									$correctAns = "";
									while($row = $result->fetch_assoc()) {
										$correctAns = $row["ans"];
									}
									echo '<textarea rows=5 cols=20 name="newText">'.$correctAns.'</textarea>';
									echo '<input type= "hidden" name="textID" value="'.$typeID[0].'">';
								}						
								?>	
							</td>
							<td>
								<!--Display initial status-->
								<input type="number" min="1" max="2" name="newStatus" value="<?php echo $status; ?>">
							</td>
							<td>
								<!--Display initial score-->
								<?php echo $score; ?>
							</td>
							<td>
								<!--Update button-->
								<input class="btn btn-success" type="submit" value="Update"><br><br>
								<!--Cancel button-->
								<input class="btn btn-secondary" type="button" name="cancel" value="Cancel" onclick="window.location='questions.php'" />
							</td>
						</tr>
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









