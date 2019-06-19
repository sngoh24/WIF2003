<!DOCTYPE html>
<html>
<head>
	<!-- CSS File -->
	<link rel="stylesheet" type="text/css" href="indexCSS.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!-- icon -->
	<link rel="shortcut icon" href="Brain Logo.png">

	<!-- Title -->
	<title>Critical Thinking Skills</title>
	
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<form action="processAns.php" method="POST" id="formQ" enctype="multipart/form-data" novalidate>
	<table id="QuesNavTable">
		<tbody>
			<tr>
				<td class="td20"><img src="Brain Logo.png" alt="Brain Logo" class="logo"></td>
				<!-- time used -->
				<td id="timeUsed" class="td60">
					<h2>Total Time Used : 					
						<input type="text" id="iTimeShow" name="duration" readonly>
					</h2>
				</td>
				<td class="td20">
					<input type="submit" name="submit" value="Submit" onclick="return confirm('Press okay to submit your test!');">
				</td>
			</tr>
		</tbody>
	</table>
	<table id="quesTable">
		<tbody>
			<tr>
				<!-- Page Numbers -->
				<td rowspan="2" id="pageNum" class="td15">
					<?php 
					session_start();
					//connect to db
					include_once('connect.php');

					if (isset($_SESSION['login']) && 
					isset($_SESSION['id']) &&
					isset($_SESSION['matricNo']) &&
					$_SESSION['login'] == true){

					$id = $_SESSION['id'];
					//get total number of question from db
					$sql			= '
					SELECT 	COUNT(id) 
					FROM 	question
					WHERE 	status = 1';
					$result 		= $conn->query($sql); 
					$row 			= $result->fetch_row(); 
					$total_records 	= $row[0];  
					$total_pages 	= ceil($total_records);
					$pagLink 		= '';

					//print page numbers
					for ($i = 1; $i <= $total_pages; $i++) {
						if($i == 1){
							$pagLink .= '<a href="#Q' . $i . '" id="page' . $i . '" class="quesActive" onclick="showQues(' . $i . ')"><li>' . $i . '</li></a>';
						} else{
						$pagLink .= 
						'<a href="#Q' . $i . '" id="page' . $i . '" class="quesInactive" onclick="showQues(' . $i . ')"><li>' . $i . '</li></a>'; 
						} 
					}
					echo $pagLink . '';  
					?>
				</td>
				<!-- Question Field -->
				<td class="td55">
					<div id=ques>
						<h3>
							<?php
							// print all the questions 
							$sqlQ = "
							SELECT 	title
							FROM	question
							WHERE 	status 		= 1
							";  
							$resultQ = $conn->query($sqlQ);

							$quesNum = array();
							$rowQ = $resultQ->fetch_assoc();
							// first question
							echo '<div id="Q1" class="unhide">' . $rowQ['title'] . '</div>';
							$i = 2;
							// questions
							while($rowQ = $resultQ->fetch_assoc()){
								echo '<div id="Q' . $i .'" class="hide">' . $rowQ['title'] . '</div>';
								$i++;
							}
							?>
						</h3>
					</div>
				</td>
				<!-- Image Field -->
				<td rowspan="2" class="td30">
					<?php
					// print all the questions 
					$sqlI = "
					SELECT 	image
					FROM	question
					WHERE 	status 		= 1
					";  
					$resultI = $conn->query($sqlI);

					$quesNum = array();
					$rowI = $resultI->fetch_assoc();
					// image of first question
					echo '<div id="I1" class="unhide"><img src="QuesImg/' . $rowI['image'] . '"></div>';
					$i = 2;
					// images of questions
					while($rowI = $resultI->fetch_assoc()){
						echo '<div id=I' . $i .' class="hide"><img src="QuesImg/' . $rowI['image'] . '"></div>';
						$i++;
					}
					?>
				</td>
			</tr>
			<tr>
				<!-- Answer Field -->
				<td class="td50">
						<?php
						//get input type number
						$sqlT = "
						SELECT 	id, type, quesID
						FROM	ans
						WHERE 	quesID IN 
						(SELECT id
						FROM	question
						WHERE 	status 	= 1)
						";  
						$resultT = $conn->query($sqlT)  or die($conn->error); 
						$i = 1;
						$prevQues = '';
						while($rowT = $resultT->fetch_assoc()){
							if($rowT['quesID'] != $prevQues && $prevQues != ''){
								$i++;
								echo '</div><div id="A'. $i . '" class="hide">';
							} elseif($i == 1){
								echo '<div id="A1" class="unhide">';
							}
							$typenum 	= $rowT['type'];
							$ansid 		= $rowT['id'];

							//get input type 
							$sqlIT = "
							SELECT 	type
							FROM	ans_type
							WHERE 	id = $typenum 
							AND 	id IN 
							(SELECT type
							FROM	ans
							WHERE 	quesID IN 
							(SELECT id
							FROM	question
							WHERE 	status 	= 1))
							";  
							$resultIT = $conn->query($sqlIT)  or die($conn->error);
							$rowIT 	= $resultIT->fetch_assoc();
							$typename = $rowIT['type'];

							switch ($typenum){
								//checkbox
								case 1:
								//get input type 
								$sqlCB = "
								SELECT 	label, name, value, noOfAns
								FROM	ans_type_checkbox
								WHERE 	ansID = $ansid 
								AND 	ansID IN 
								(SELECT id 
								FROM 	ans
								WHERE 	quesID IN 
								(SELECT id
								FROM	question
								WHERE 	status 	= 1))
								";  
								$resultCB = $conn->query($sqlCB)  or die($conn->error);
								$rowCB = $resultCB->fetch_assoc();
								if(!is_null($rowCB['label'])){
									echo '<label>' . $rowCB['label'] . ': </label>';
								}
								echo '<label><input type="' . $typename . 
								'" name="' . $rowCB['name']. '"' . 
								'" value="' . $rowCB['value']. '">' . 
								$rowCB['value'] . '</label>';
								while($rowCB = $resultCB->fetch_assoc()){
									echo '<label><input type="' . $typename . 
									'" name="' . $rowCB['name']. '"' . 
									'" value="' . $rowCB['value']. '">' . 
									$rowCB['value'] . "</label>";
								}
								break;

								//file
								case 2:
								//get input type 
								$sqlF = "
								SELECT 	label, type, noOfFile, size, name
								FROM	ans_type_file
								WHERE 	ansID = $ansid 
								AND 	ansID IN 
								(SELECT id 
								FROM 	ans
								WHERE 	quesID IN 
								(SELECT id
								FROM	question
								WHERE 	status 	= 1))
								";  
								$resultF = $conn->query($sqlF)  or die($conn->error);
								$rowF = $resultF->fetch_assoc();
								if(!is_null($rowF['label'])){
									echo '<label>' . $rowF['label'] . ': </label>';
								}
								echo '<input type="' . $typename . 
								'" name="' . $rowF['name']. '">'
								;
								while($rowF = $resultF->fetch_assoc()){
									'<input type="' . $typename . 
									'" name="' . $rowF['name']. '">'
									;
								} 
								break;

								//num
								case 3: 
								//get input type 
								$sqlN = "
								SELECT 	label, minlength, maxlength, step, name
								FROM	ans_type_number
								WHERE 	ansID = $ansid 
								AND 	ansID IN 
								(SELECT id 
								FROM 	ans
								WHERE 	quesID IN 
								(SELECT id
								FROM	question
								WHERE 	status 	= 1))
								";  
								$resultN = $conn->query($sqlN)  or die($conn->error);
								$rowN = $resultN->fetch_assoc();
								if(!is_null($rowN['label'])){
									echo '<label>' . $rowN['label'] . ': </label>';
								}
								echo '<input type="' . $typename . 
								'" name="' . $rowN['name']. '"' .
								'" min="' . $rowN['minlength']. '"' .
								'" max="' . $rowN['maxlength']. '">';
								while($rowN = $resultN->fetch_assoc()){
									echo '<input type="' . $typename . 
									'" name="' . $rowN['name']. '"' .
									'" min="' . $rowN['minlength']. '"' .
									'" max="' . $rowN['maxlength']. '">';
								}
								break;

								//radio
								case 4: 
								//get input type 
								$sqlR = "
								SELECT 	label, value, name
								FROM	ans_type_radiobutton
								WHERE 	ansID = $ansid 
								AND 	ansID IN 
								(SELECT id 
								FROM 	ans
								WHERE 	quesID IN 
								(SELECT id
								FROM	question
								WHERE 	status 	= 1))
								";  
								$resultR = $conn->query($sqlR)  or die($conn->error);
								$rowR = $resultR->fetch_assoc();
								if(!is_null($rowR['label'])){
									echo '<label>' . $rowR['label'] . ': </label>';
								}
								echo 
								'<label><input type="' . $typename . 
								'" name="' . $rowR['name']. '"' .
								'" value="' . $rowR['value']. '">' . 
								$rowR['value'] . '</label>';

								while($rowR = $resultR->fetch_assoc()){
									echo 
									'<label><input type="' . $typename . 
									'" name="' . $rowR['name']. '"' .
									'" value="' . $rowR['value']. '">' . 
									$rowR['value'] . '</label>';
								}
								echo '<br>';
								break;

								//text
								case 5: 
								//get input type 
								$sqlTe = "
								SELECT 	label, length, name
								FROM	ans_type_textbox
								WHERE 	ansID = $ansid 
								AND 	ansID IN 
								(SELECT id 
								FROM 	ans
								WHERE 	quesID IN 
								(SELECT id
								FROM	question
								WHERE 	status 	= 1))
								";  
								$resultTe = $conn->query($sqlTe)  or die($conn->error);
								$rowTe = $resultTe->fetch_assoc();
								if(!is_null($rowTe['label'])){
									echo '<label>' . $rowTe['label'] . ': </label>';
								}
								echo '<input type="' . $typename . 
									'" name="' . $rowTe['name']. '"' .
									'" maxlength="' . $rowTe['length']. '">';

								while($rowTe = $resultTe->fetch_assoc()){
									echo $rowTe['label'] .
									'<input type="' . $typename . 
									'" name="' . $rowTe['name']. '"' .
									'" maxlength="' . $rowTe['length']. '">';
								}
								break;

								default: 
								break;
							}
							$prevQues = $rowT['quesID'];
						}
						echo '</div>';
					} else {
						header('location: form.php?action="login_failed"');
					}
					?>
				</td>
			</tr>

		</tbody>
		<tfoot>
			<td colspan="3">&copy 2019 - CREATIVEBRAIN</td>
		</tfoot>
	</table>
	</form>

	<!-- JS File -->
	<script type="text/javascript" src="jquery-3.4.0.js"></script>
	<script type="text/javascript" src="quesJS.js"></script>
</body>
</html>