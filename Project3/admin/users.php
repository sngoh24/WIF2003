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
					<li class="nav-item">
						<a class="nav-link" href="participants.php">PARTICIPANTS</a> 
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="users.php">USERS</a> 
						<span class="sr-only">(current)</span> 
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
				<form action = "users.php" method="get" style="float: left; width: 500px !important; margin-bottom: 10px">
					<input class="form-control" type="text"  style="float: right" name="id" placeholder="Search for username.." dir="ltr">
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
			SELECT 	user.id AS id,
			user.username AS username, user.password AS password, user.lastloggedin AS lastloggedin, user.lastloggedout AS lastloggedout, user.createdOn AS createdOn, user.createdBy AS createdBy, status.name AS status
			FROM 	
			user, status
			WHERE 
			status.id 	= user.status AND
			username $getid
			ORDER BY username, status
			LIMIT 	$start_from, $limit
			";  
			$result = $conn->query($sql) or die($conn->error);  
			?> 

			<div style="float: right; padding-bottom: 10px">
				<input type="button" class="btn btn-primary" value="Add" data-toggle="modal" data-target="#modalAdd">
			</div>

			<!-- Modal -->
			<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddNew" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modal">New User</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form id="addNew" action="processUser.php" method="POST">
							<div class="modal-body">
								<div class="form-group row">
									<label class="col-3 col-form-label">USERNAME</label>
									<div class="col-8">
										<input type="text" name="username" class="form-control" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">PASSWORD</label>
									<div class="col-8">
										<input type="password" name="password" class="form-control" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">CONFIRM PASSWORD</label>
									<div class="col-8">
										<input type="password" name="rpassword" class="form-control" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">CREATED BY</label>
									<div class="col-8">
										<input type="text" name="createdBy" value='<?php echo $_SESSION["username"] ?>' class="form-control" disabled="">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">STATUS</label>
									<div class="col-8">
										<select name="status" class="form-control">
											<option value="1">Active</option>
											<option value="2">Inactive</option>
										</select>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<input type="submit" class="btn btn-primary" value="Add" name="add">
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<!-- Users Table -->
			<table class="table table-hover table-responsive">
				<thead>  
					<tr>  
						<th scope="col">USERNAME</th>
						<th scope="col">PASSWORD</th>
						<th scope="col">LAST LOGGED IN</th>
						<th scope="col">LAST LOGGED OUT</th>
						<th scope="col">CREATED ON</th>
						<th scope="col">CREATED BY</th>
						<th scope="col">STATUS</th> 
						<th scope="col">ACTION</th>
					</tr>  
				</thead>  
				<tbody>  
					<?php
					while ($row = $result->fetch_assoc()) {
						echo 
						'<tr>' . 
						'<td>' . $row['username'] . '</td>' .
						'<td><input type="password" readonly disabled class="form-control-plaintext" style="width: 89px" value="' . substr($row["password"], 0, 8) . '"></td>' .
						'<td>' . $row['lastloggedin'] . '</td>' .
						'<td>' . $row['lastloggedout'] . '</td>' .
						'<td>' . $row['createdOn'] . '</td>' .
						'<td>' . $row['createdBy'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
						'<td>
							<div class="btn-group">
							<input type="button" class="btn btn-primary" value="Edit" data-toggle="modal" data-target="#modal'. $row['id'] .'">
							<input type="button" class="btn btn-warning" value="Inactive" data-toggle="modal" data-target="#modalDel'. $row['id'] .'">
							</div>
						</td>' .
						'</tr> ';
						echo 
						'<!-- Modal -->
						<div class="modal fade" id="modal'. $row['id'] .'" tabindex="-1" role="dialog" aria-labelledby="modalTitle'. $row['id'] .'" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
						<div class="modal-header">
						<h5 class="modal-title" id="modal' . $row['id'] .'">' . $row['username'] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div>
						<form id="edit" action="processUser.php" method="POST">
						<input type="hidden" name="tempid" value=' . $row['id'] . '>
						<div class="modal-body">
						<div class="form-group row">
						<label class="col-3 col-form-label">PASSWORD</label>
						<div class="col-8">
						<input type="password" name="password" readonly disabled class="form-control-plaintext" value="' . substr($row["password"], 0, 8) . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">NEW PASSWORD</label>
						<div class="col-8">
						<input type="password" class="form-control">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">CONFIRM PASSWORD</label>
						<div class="col-8">
						<input type="password" class="form-control">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-3 col-form-label">STATUS</label>
						<div class="col-8">
						<select name="editStatus" class="form-control">
						<option value = 1>Active</option>
						<option value = 2>Inactive</option>
						</select>
						</div>
						</div>
						</div>';
						echo 
						'<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" value="Save" name="editSubmit">
						</div>
						</form>
						</div>
						</div>
						</div>
						<!-- Modal Inactive -->
						<div class="modal fade" id="modalDel'. $row['id'] .'" tabindex="-1" role="dialog" aria-labelledby="modalTitleDel'. $row['id'] .'" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
						<div class="modal-header">
						<h5 class="modal-title" id="modalDel' . $row['id'] .'">' . $row['username'] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div>
						<form id="inactive" action="processUser.php" method="POST">
						<input type="hidden" name="tempid1" value=' . $row['id'] . '>
						<div class="modal-body">
						<div class="form-group row">
						<label class="col-10 col-form-label">Are you sure you want to inactivate this user?</label>
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<input type="submit" class="btn btn-warning" value="Inactive" name="inactiveSubmit">
						</div>
						</form>
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
				FROM 		user';
				$resultPage 	= $conn->query($sqlPage);  
				$rowPage 		= $resultPage->fetch_row();  
				$total_records 	= $rowPage[0];  
				$total_pages = ceil($total_records / $limit);  
				$pagLink = '<ul class="pagination">';
					//print page numbers
				for ($i = 1; $i <= $total_pages; $i++) {
					if($page == $i){
						$pagLink .= 
						'<li class="page-item active"><a class="page-link" href="users.php?page=' . $i . '">' . $i . '</a></li>';  
					} else {
						$pagLink .= 
						'<li class="page-item"><a class="page-link" href="users.php?page=' . $i . '">' . $i . '</a></li>';  
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
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"	crossorigin="anonymous"></script>
	<script	src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"crossorigin="anonymous"></script>
</body>
</html>