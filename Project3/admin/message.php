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
					<li class="nav-item">
						<a class="nav-link" href="users.php">USERS</a> 
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="message.php">INBOX <span class="badge badge-light"><?php echo $total_records; ?></span></a>
						<span class="sr-only">(current)</span> 
					</li>
				</ul>

				<a class="btn btn-warning" style="font-weight: bold" href="logout.php">LOG&nbspOUT</a>
			</div>
		</nav>

		<div class="container1 clearfix">
			<div>
				<form action = "message.php" method="get" style="float: left; width: 500px !important; margin-bottom: 10px">
					<input class="form-control" type="text"  style="float: right" name = "message" placeholder="Search for message.." dir="ltr">
				</form>
			</div>
			<?php
			include('connect.php');
			if(isset($_GET['message'])){

				$getid = "LIKE '%" . $_GET['message'] . "%'";
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
			SELECT 	message.id AS id, message.name AS name, 
			message.email AS email, message.message AS message, 
			message.lastUpdatedOn AS lastUpdatedOn, 
			message.lastUpdatedBy AS lastUpdatedBy, 
			message.createdOn AS createdOn, 
			message.createdBy AS createdBy,
			message_type.name AS type, 
			message_status.name AS status
			FROM 	message, message_type, message_status
			WHERE 	(status = 1 OR status = 2) AND 
			message.type = message_type.id AND
			message.status = message_status.id AND
			message.message $getid
			ORDER BY status, lastUpdatedOn
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
							<h5 class="modal-title" id="modal">New Enquiry</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form id="addNew" action="processMsg.php" method="POST">
							<div class="modal-body">
								<div class="form-group row">
									<label class="col-2 col-form-label">ENQUIRY</label>
									<div class="col-10">
										<select name="enquiry" class="form-control">
											<?php 
												$sqlEnquiry = "SELECT * FROM message_type";
												$resultEnquiry = $conn->query($sqlEnquiry);
												while($rowEnquiry = $resultEnquiry->fetch_assoc()){
													echo '<option value = ' . $rowEnquiry["id"].'>' . $rowEnquiry["name"].'</option>';
												}
											 ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label">NAME</label>
									<div class="col-10">
										<input type="text" name="name" class="form-control" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label">EMAIL</label>
									<div class="col-10">
										<input type="email" name="email" class="form-control" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label">MESSAGE</label>
									<div class="col-10">
										<textarea type="text" id="message" name="message" rows="3" cols="40" required autocomplete="off" tabindex="5" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label">CREATED BY</label>
									<div class="col-10">
										<input type="text" name="createdBy" value='<?php echo $_SESSION["username"] ?>' class="form-control" disabled="">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label">STATUS</label>
									<div class="col-10">
										<select name="status" class="form-control" disabled="">
											<option value="1">opened</option>
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
			
			<!-- Message Table -->
			<table class="table table-hover table-responsive">
				<thead>  
					<tr>  
						<th scope="col">ENQUIRY</th>
						<th scope="col">MESSAGE</th>
						<th scope="col">NAME</th>
						<th scope="col">EMAIL</th> 
						<th scope="col">LAST UPDATED ON</th>
						<th scope="col">LAST UPDATED BY</th>
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
						'<td>' . $row['type'] . '</td>' .
						'<td>' . $row['message'] . '</td>' .
						'<td>' . $row['name'] . '</td>' .
						'<td><a href="mailto:' . $row['email'] . '" target="_top">' . $row['email'] . '</a></td>' .
						'<td>' . $row['lastUpdatedOn'] . '</td>' .
						'<td>' . $row['lastUpdatedBy'] . '</td>' .
						'<td>' . $row['createdOn'] . '</td>' .
						'<td>' . $row['createdBy'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
						'<td><input type="button" class="btn btn-warning" value=Edit data-toggle="modal" data-target="#modal'. $row['id'] .'"></td>' .
						'</tr> ';
						echo 
						'<!-- Modal -->
						<div class="modal fade" id="modal'. $row['id'] .'" tabindex="-1" role="dialog" aria-labelledby="modalTitle'. $row['id'] .'" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
						<div class="modal-header">
						<h5 class="modal-title" id="modal' . $row['id'] .'">' . $row['name'] . ' (<a href="mailto:' . $row['email'] . '" target="_top">' . $row['email'] . '</a>)</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div>
						<form id="status" action="processMsg.php" method="POST">
						<input type="hidden" name=msgid value=' . $row['id'] . '>
						<div class="modal-body">
						<div class="form-group row">
						<label class="col-2 col-form-label">TYPE</label>
						<div class="col-10">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['type'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-2 col-form-label">MESSAGE</label>
						<div class="col-10">
						<input type="text" readonly class="form-control-plaintext" value ="' . $row['message'] . '">
						</div>
						</div>
						<div class="form-group row">
						<label class="col-2 col-form-label">STATUS</label>
						<div class="col-10">
						<select name="editstatus" class="form-control">
						<option value = 0>closed</option>
						<option value = 1>opened</option>
						<option value = 2>pending</option>
						</select>
						</div>
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" value="Save" name="submit">
						</div>
						</form>
						</div>
						</div>
						</div>';
					};  
					?>
				</tbody>  
			</table>  

			<!-- Paging -->
			<div id="paging" style="float:right">
				<?php
				$total_pages = ceil($total_records / $limit);  
				$pagLink = '<ul class="pagination">';
					//print page numbers
				for ($i = 1; $i <= $total_pages; $i++) {
					if($page == $i){
						$pagLink .= 
						'<li class="page-item active"><a class="page-link" href="message.php?page=' . $i . '">' . $i . '</a></li>';  
					} else {
						$pagLink .= 
						'<li class="page-item"><a class="page-link" href="message.php?page=' . $i . '">' . $i . '</a></li>';  
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

		<!--JS Files-->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"	crossorigin="anonymous"></script>
		<script	src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"crossorigin="anonymous"></script>
	</body>
	</html>









