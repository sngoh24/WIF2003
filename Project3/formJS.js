// Current tab is set to be the first tab (0)
var currentTab = 0; 

$(document).ready(function(){
	addYearOfExam("PY");
	addYearOfExam("TY");

	// hide all the tab in form.php
	$(".tab").hide();
	// Display the current tab
	showTab(currentTab);
});

//Update Year of Examination
function addYearOfExam (year){
	var d = new Date();
	var curYear = d.getFullYear();	

	var selectValues = [curYear, curYear - 1, curYear - 2, curYear - 3];
	var $mySelect = $('#' + year +'Year');

	$.each(selectValues, function(key, value) {
		var $option = $("<option/>", {
			value: value,
			text: value
		});
		$mySelect.append($option);
	});
}

function showTab(n) {
	// This function will display the specified tab of the form...
	var xn = $(".tab:eq("+ n +")");
	xn.show();
	xn.css('display', 'block');
	//... and fix the Previous/Next buttons:
	if (n < 1) {
		$(".prevBtn").hide();
	} else {
		$(".prevBtn").show();
		$(".prevBtn").css('display', "inline");
	}
	if (n == ($(".tab").length - 1)) {
		$(".nextBtn").attr({
			"value": "Start",
			"type": "submit",
			"onclick": ""});
	} else {
		$(".nextBtn").attr({
			"value": "Next",
			"type": "button",
			"onclick": "nextPrev(1)"});
	}
	//... and run a function that will display the correct step indicator:
	fixStepIndicator(n)
}

// view prev/ next page in form.php
function nextPrev(n) {
	// This function will figure out which tab to display
	var x = $(".tab");
	// Exit the function if any field in the current tab is invalid:
	if (n == 1 && !validateForm()) return false;
	// Hide the current tab:
	$(".tab:eq(" + currentTab + ")").hide();
	// Increase or decrease the current tab by 1:
	/*if ($("#yearstudy").val() == 1){
		if(n == 1){
			currentTab = currentTab + n + 1;
		}else {
			currentTab = currentTab + n - 1;
		}
	}else {
		currentTab = currentTab + n;
	}
	*/
	currentTab = currentTab + n;
	// if you have reached the end of the form...
	if (currentTab < x.length + 1) {
		showTab(currentTab);
	}
}

//validate form in form.php
function validateForm() {
	var str = "Please correct the following field(s):\n";
	var valid = true;
	//Check input in Personal Detail
	if(currentTab == 0){
		if(!/[a-z0-9]{9}/g.test($("#matricNo").val())) {
			str = str + "Matriculation Number\n";
			valid = false;
			$("#matricNo").attr('class', 'invalid');
		} else {
			$("#matricNo").removeClass();
		}
		if(!/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test($("#email").val())){
			str = str + "GPA\n";
			valid = false;
			$("#email").attr('class', 'invalid');
		} else {
			$("#email").removeClass();
		}
	}//Check input in Past Year Result
	else if (currentTab == 1){
		if(!/^([0-9]+(\.?[0-9]?[0-9]?)?)/g.test($("#PYgpa").val())) {
			str = str + "GPA\n";
			valid = false;
			$("#PYgpa").attr('class', 'invalid');
		} else {
			$("#PYgpa").removeClass();		
		}
		if(!/^([0-9]+(\.?[0-9]?[0-9]?)?)/g.test($("#PYcgpa").val())) {
			str = str + "CGPA\n";
			valid = false;
			$("#PYcgpa").attr('class', 'invalid');
		} else {
			$("#PYcgpa").removeClass();
		}
	}//Check input in This Year Result
	else if (currentTab == 2){
		if(!/^([0-9]+(\.?[0-9]?[0-9]?)?)/g.test($("#TYgpa").val())) {
			str = str + "GPA\n";
			valid = false;
			$("#TYgpa").attr('class', 'invalid');
		} else {
			$("#TYgpa").removeClass();
		}
		if(!/^([0-9]+(\.?[0-9]?[0-9]?)?)/g.test($("#TYcgpa").val())) {
			str = str + "CGPA\n";
			valid = false;
			$("#TYcgpa").attr('class', 'invalid');
		} else {
			$("#TYcgpa").removeClass();
		}
	}
	
	//Check select in form
	var select = $(".tab:eq(" + currentTab + ") select");
	for(var i = 0; i < select.length; i++){
		var selindex = $(".tab:eq(" + currentTab + ") select:eq(" + i + ")");
		if(selindex.find(":selected").index() == ""){
			str = str + selindex.children("option:selected").val() + "\n";
			valid = false;
			selindex.attr('class', 'invalid');
		} else {
			selindex.removeClass();
		}
	}
	
	if(valid){
		validStep = $(".step:eq("+ currentTab + ")");
		ori = validStep.attr("class");
		validStep.attr("class", ori + " finish");
	} else {
		//Alert user
		//alert(str);
	}
	return valid;
}	

//show the step indicator in form.php
function fixStepIndicator(n) {
	// This function removes the "active" class of all steps...
	var i, x = $(".step");
	for (i = 0; i < x.length; i++) {
		$(".step:eq(" + i + ")").attr('class', x[i].className.replace(" active", ""));
	}
	//adds the "active" class to the current step:
	x[n].className += " active";
}

//add new row
function courseAddRow() {
	var curYear;
	if(currentTab == 1){
		curYear = "PY";
	} else if(currentTab == 2) {
		curYear = "TY";
	}
	var curCourse = $("#" + curYear + " fieldset").length;
	var addCourse = $("#" + curYear + "Course" + curCourse + " .courseAddBtn");
	$(addCourse).click(newRow(curYear, curCourse));
}

//add new row for course
function newRow(curYear, curCourse){
	var newCourse = curCourse + 1;
	$("#" + curYear + "Course" + curCourse).after(
		'<fieldset id="' + curYear + 'Course' + newCourse + '"><legend>Course ' + newCourse + '</legend><div class="row"><div class="col-15left"><input type="button" class="courseAddBtn" value="+" onclick="courseAddRow()"><input type="button" class="courseRemoveBtn" value="&times;" onclick="courseRemoveRow(' + newCourse + ')"></div><div class="col-65"><input type="text" placeholder="Course Code" name="' + curYear + 'CC' + newCourse + '"><input type="text" placeholder="Course Name" name="' + curYear + 'CN' + newCourse + '"></div><div class="col-15right"><select name="' + curYear + 'grade' + newCourse + '" class="grade"><option selected disabled hidden>Grade</option><option value="A+">A+</option><option value="A">A</option><option value="A-">A-</option><option value="B+">B+</option><option value="B">B</option>	<option value="C+">C+</option><option value="C">C</option><option value="C-">C-</option><option value="D">D</option><option value="E">E</option><option value="F">F</option></select></div></div></fieldset>'
		);
}

//remove course row
function courseRemoveRow(curCourse) {
	var curYear;
	if(currentTab == 1){
		curYear = "PY";
	} else if(currentTab == 2) {
		curYear = "TY";
	}
	$("#" + curYear + "Course" + curCourse).remove();
	if($(curCourse != "#" + curYear + " fieldset").length){
		rearrageNum(curYear);
	}
}

//rearrage courses in PY/ TY
function rearrageNum(curYear){
	var i;
	var allfs = $("#" + curYear + " fieldset");
	for(i = 0; i < allfs.length; i++){
		var j = i + 1;
		//i-th fieldset
		var curFS = $("#" + curYear + " fieldset:eq(" + i + ")");
		//i-th fieldset id
		var curfsID = curFS.attr("id");
		//correct fieldset id
		var fsID = (curYear + "Course" + j);

		//if i-th fieldset id != correct fieldset id
		if(curfsID != fsID){
			//change i-th fieldset id 
			curFS.attr("id", fsID);

			//change legend
			$("#" + curYear + " fieldset:eq(" + i + ") legend").text("Course " + j);

			//change remove button
			$("#" + curYear + " fieldset:eq(" + i + ") .courseRemoveBtn").attr(
				"onclick", "courseRemoveRow(" + j + ")");

			//change course code's name
			$(".col-65:nth-child(0)").attr(
				"name", (curYear + "CC" + j));

			//change course name's name
			$(".col-65:nth-child(1)").attr(
				"name", (curYear + "CN" + j));

			//change grade's name
			$(".col-15right:nth-child(0)").attr(
				"name", (curYear + "grade" + j));	
		}
	}
}