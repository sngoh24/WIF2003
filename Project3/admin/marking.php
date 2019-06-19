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
			<!-- Search questions -->
			<form action = "searchMarking.php" method="get" style="float: left; width: 500px !important">
				<input class="form-control"  type="text"  style="float: right" name = "q" placeholder="Search for questions.." dir="ltr"><br>
			</form>

			<!-- Questions Table -->
			<table id="DynamicTable" class="table table-hover">
				<thead>
					<tr>
						<th scope="col">Answers</th>
						<th scope="col">Questions</th>
						<th scope="col">Correct Answers</th>
						<th scope="col">Score</th> 	 
						<th scope="col">Status</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT COUNT(*)AS num FROM question";
					$result = $conn->query($sql);
					while($row = $result->fetch_assoc()) {
						$num = $row["num"];
					}
					$ii = 0;
							//To display row for each question
					for($i = 1; $i <= $num; $i++){
						$ii = $i;
						echo '<tr>';
						echo '<td>';
						echo $i;
						echo '</td>';
						echo '<td class="text-left">';								
						$sql = "SELECT title FROM question WHERE id = ".$i;
						$result = $conn->query($sql);
						while($row = $result->fetch_assoc()) {
							echo $row["title"];
						}
						echo "</td><td>";

						$sql = "SELECT type, id FROM ans WHERE quesID = ".$i;
						$result = $conn->query($sql);
						unset($typeID);								
						$typeID = array();
						while($row = $result->fetch_assoc()) {
							$type = $row["type"];									
							array_push($typeID, $row["id"]);
						}
						if($type == 1){
							$typeTable = "ans_type_checkbox";
						}
						if($type == 2){
							$typeTable = "ans_type_file";
						}
						if($type == 3){
							$typeTable = "ans_type_number";
						}
						if($type == 4){
							$typeTable = "ans_type_radiobutton";
						}
						if($type == 5){
							$typeTable = "ans_type_textbox";
						}			
						for($y = 0; $y < sizeof($typeID); $y ++){
							if($type == 4){
								$sql = "SELECT label, value FROM ". $typeTable." WHERE ans = 1 AND ansID = ".$typeID[$y];
								$result = $conn->query($sql);
								while($row = $result->fetch_assoc()) {
									echo $row["label"].": ".$row["value"]."<br/>";
								}
							}
							else if($type == 1){
								$sql = "SELECT value FROM ". $typeTable." WHERE ans = 1 AND ansID = ".$typeID[$y];
								$result = $conn->query($sql);
								while($row = $result->fetch_assoc()) {
									echo $row["value"]."<br/>";
								}
							}
							else{
								$sql = "SELECT ans FROM ". $typeTable." WHERE ansID = ".$typeID[$y];
								$result = $conn->query($sql);
								while($row = $result->fetch_assoc()) {
									echo $row["ans"]."<br/>";
								}
							}
						}
						echo "</td><td>";

						$sql = "SELECT question.score AS score, status.name AS status
						FROM question, status
						WHERE question.id = $i AND 
						question.status = status.id";
						$result = $conn->query($sql);
						while($row = $result->fetch_assoc()) {
							echo $row["score"];
							echo "</td><td>";
							echo $row["status"];
						}
						echo '</td>';
						echo '<td name="buttons">';
						echo '<a class="btn btn-primary" href="mark.php?mark='.$i.'">Mark</a>';				
						echo '</td></tr>';						
					}
					?>										
				</tbody>
			</table>
		</div>

		<!--Here the footer-->
		<footer>
			&copy 2019 - CREATIVEBRAIN
		</footer>

		<!--JS Files-->
		<script>
			$('#DyanmicTable').SetEditable({ $addButton: $('#addNewRow')});
		</script>
		<script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
		<script src="bootstable.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"	crossorigin="anonymous"></script>
		<script	src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"crossorigin="anonymous"></script>
	</body>
	</html>









