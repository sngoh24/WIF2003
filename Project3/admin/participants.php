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
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="questions.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">QUESTIONS</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="questions.php">QUESTIONS</a>
							<a class="dropdown-item" href="marking.php">MARKING</a>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="ranking.php">RANKING</a> 
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="participants.php">PARTICIPANTS</a>
						<span class="sr-only">(current)</span>  
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
		
		<div class="container1 clearfix">
			<div>
				<form action = "participants.php" method="get" style="float: left; width: 500px !important; margin-bottom: 10px">
					<input class="form-control" type="text"  style="float: right" name = "id" placeholder="Search for matric no.." dir="ltr">
				</form>
			</div>
			<?php
			include('connect.php');
			if(isset($_GET['id'])){
				$getid = "LIKE '%" . $_GET['id'] . "%'";
			}else {
				$getid = "IS NOT NULL";
			}

			$limit = 5;  
			if (isset($_GET['page'])) {
				$page  = $_GET['page']; 
			} else {
				$page = 1; 
			}
			$start_from = ($page - 1) * $limit; 

			$sql = "
			SELECT 	
			part.id 		AS id,
			part.matricNo 	AS matricNo, 
			partUni.name 	AS university, 
			partFac.name 	AS faculty, 
			partCourse.name AS course, 
			partYear.name	AS year, 
			partGender.name AS gender, 
			partAge.name 	AS age, 
			partEthnic.name AS ethnic, 
			partNation.name AS nation, 
			part.email 		AS email
			FROM 	
			participant 			AS part, 
			participant_university	AS partUni, 
			participant_faculty		AS partFac, 
			participant_course 		AS partCourse,
			participant_yearstudy	AS partYear, 
			participant_gender 		AS partGender,
			participant_age 		AS partAge, 
			participant_ethnic 		AS partEthnic, 
			participant_nation 		AS partNation
			WHERE 
			part.university 	= partUni.id 	AND
			part.faculty 		= partFac.id 	AND
			part.course 		= partCourse.id AND
			part.yearOfStudy	= partYear.id 	AND
			part.gender 		= partGender.id AND
			part.age 			= partAge.id 	AND
			part.ethnic 		= partEthnic.id AND
			part.nationality	= partNation.id AND
			matricNo 			$getid
			ORDER BY matricNo
			LIMIT 	$start_from, $limit
			";  
			$result = $conn->query($sql) or die($conn->error);  
			?> 
			
			<!-- Participants Table -->
			<table class="table table-hover table-responsive">
				<thead>  
					<tr>  
						<th scope="col">MATRIC NO</th>
						<th scope="col">UNIVERSITY</th>
						<th scope="col">FACULTY</th>
						<th scope="col">COURSE</th>
						<th scope="col">YEAR OF STUDY</th> 
						<th scope="col">GENDER</th>
						<th scope="col">AGE</th>	 
						<th scope="col">ETHNIC</th> 
						<th scope="col">NATION</th>
						<th scope="col">EMAIL</th>	
						<th scope="col">ACTION</th>
					</tr>  
				</thead>  
				<tbody>  
					<?php
					while ($row = $result->fetch_assoc()) {
						echo 
						'<tr>' . 
						'<td>' . $row['matricNo'] . '</td>' .
						'<td>' . $row['university'] . '</td>' .
						'<td>' . $row['faculty'] . '</td>' .
						'<td>' . $row['course'] . '</td>' .
						'<td>' . $row['year'] . '</td>' .
						'<td>' . $row['gender'] . '</td>' .
						'<td>' . $row['age'] . '</td>' .
						'<td>' . $row['ethnic'] . '</td>' .
						'<td>' . $row['nation'] . '</td>' .
						'<td><a href="mailto:' . $row['email'] . '" target="_top">' . $row['email'] . '</a></td>' .
						'<td><input type="button" class="btn btn-info" value="View" data-toggle="modal" data-target="#modal'. $row['id'] .'"></td>' .
						'</tr> ';
						echo 
						'<!-- Modal -->
						<div class="modal fade" id="modal'. $row['id'] .'" tabindex="-1" role="dialog" aria-labelledby="modalTitle'. $row['id'] .'" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
						<div class="modal-header">
						<h5 class="modal-title" id="modal' . $row['id'] .'">' . $row['matricNo'] . ' (<a href="mailto:' . $row['email'] . '" target="_top">' . $row['email'] . '</a>)</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div>
						<input type="hidden" name="partid" value=' . $row['id'] . '>
						<div class="modal-body">
						<div class="form-group row">
						<label class="col-3 col-form-label">UNIVERSITY</label>
						<div class="col-8">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['university'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">FACULTY</label>
						<div class="col-8">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['faculty'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">COURSE</label>
						<div class="col-8">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['course'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">YEAR OF STUDY</label>
						<div class="col-8">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['year'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">AGE</label>
						<div class="col-8">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['age'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">ETHNIC</label>
						<div class="col-8">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['ethnic'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">NATIONALITY</label>
						<div class="col-8">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['nation'] . '">
						</div>
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
						</div>
						</div>
						</div>';
					}
						?>
				</tbody>  
			</table>  

			<!-- Paging -->
			<div id="paging" style="float:right">
				<?php
				$sqlPage = '
				SELECT 		COUNT(id) 
				FROM 		participant';
				$resultPage 	= $conn->query($sqlPage);  
				$rowPage 		= $resultPage->fetch_row();  
				$total_records 	= $rowPage[0];  
				$total_pages = ceil($total_records / $limit);  
				$pagLink = '<ul class="pagination">';
					//print page numbers
				for ($i = 1; $i <= $total_pages; $i++) {
					if($page == $i){
						$pagLink .= 
						'<li class="page-item active"><a class="page-link" href="participants.php?page=' . $i . '">' . $i . '</a></li>';  
					} else {
						$pagLink .= 
						'<li class="page-item"><a class="page-link" href="participants.php?page=' . $i . '">' . $i . '</a></li>';  
					}
				};
				echo $pagLink . '</ul>';
				?>
			</div>
		</div>

	<!--Here the footer-->
	<footer>
		&copy 2019 - CREATIVEBRAIN
	</footer>

	<script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
	<script src="bootstable.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"	crossorigin="anonymous"></script>
	<script	src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"crossorigin="anonymous"></script>
</body>
</html>