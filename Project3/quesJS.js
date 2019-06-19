$(document).ready(function(){
	// time taken for the test
	timedCount();
});

var c = 0;
var t;
//to count time taken
function timedCount(){	
	var hours = parseInt( c / 3600 ) % 24;
	var minutes = parseInt( c / 60 ) % 60;
	var seconds = c % 60;
	var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds :seconds);            
	$('#iTimeShow').attr('value', result);
	//increase time by 1
	c = c + 1;
	t = setTimeout(function()
	{
		timedCount()
	}, 1000); // for every 1 second
}

// submit question
function submitQues() {
	var con = confirm("Press okay to submit your answers!");
	if(con == true) {
		submit();
	}
}


//get answer chosen based on type
function ansTypeVal(id, name, type){
	switch(type){
		case 'checkbox':
		return $(id +' input[type=' + type + ']:checked').val();
		break;
		case 'file':
		$('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            alert('The file "' + fileName +  '" has been selected.');
        });
		return 0;
		break;
		case 'number':
		return $('input[name=' + name + ']').val();
		break;
		case 'radio':
		return $('input[name=' + name + ']:checked').val();
		break;
		case 'text':
		return $('input[name=' + name + ']').val();
		break;
		default:
		break;
	}
}

/*
// show answer value from local storage
function showAns(){
	var temp = $('#formQ input:eq(0)');
	var name = temp.attr("name");
	var type = temp.attr("type");
	var item = sessionStorage.getItem(name);
	showAnsType(name, type, item);

	for(var i = 1; i < $('#formQ input').length; i++){
		temp = $('#formQ input:eq(' + i + ')');
		if(name != temp.attr("name")){
			name = temp.attr("name");
			type = temp.attr("type");
			item = sessionStorage.getItem(name);
			console.log(item);
			showAnsType(name, type, item);
		}
	}
}

function showAnsType(name, type, value){
	switch(type){
		case 'checkbox':
		$('input[name=' + name + '][value="' + value + '"]').prop('checked', true);
		break;
		case 'file':
		//$('input[type="file"]').files[0].val(value);
		break;
		case 'number':
		$('input[name=' + name + ']').val(value);
		break;
		case 'radio':
		$('input[name=' + name + '][value="' + value + '"]').prop('checked', true);
		break;
		case 'text':
		$('input[name=' + name + ']').val(value);
		break;
		default:
		break;
	}
}

*/


// current question num
var currentQues = 1;

function showQues(num){
	var nav 	= $("#page" + currentQues);
	var curid	= "#A" + currentQues;
	var curAns 	= $(curid);
	var curAnsChild = $(curid + " input");
	var complete = true;

	var name = curAnsChild.attr("name");	
	var type = curAnsChild.attr("type");
	// save local
	sessionStorage.setItem(name, ansTypeVal(curid,name, type));
	// check empty input value 
	if(ansTypeVal(curid, name, type) == '' || typeof ansTypeVal(curid, name, type) === 'undefined'){
		complete = false;
	}

	// check and save value of the input in local storage
	for(var i = 1; i < curAnsChild.length; i++){
		// get i-th input in #A+currentQues
		var temp = $(curid + " input:eq(" + i + ")");
		if(name != temp.attr("name")){
			// get name and type of the input
			name = temp.attr("name");
			type = temp.attr("type");
			// save local
			sessionStorage.setItem(name, ansTypeVal(curid, name, type));
			// check empty input value 
			if(ansTypeVal(curid, name, type) == '' || typeof ansTypeVal(curid, name, type) === 'undefined'){
				complete = false;
			}
		}
	}

	if(complete){
		nav.attr('class', 'quesSuccess');
	} else {
		nav.attr('class', 'quesWarning');
	}
	$("#Q" + currentQues).css('display', 'none');
	$("#A" + currentQues).css('display', 'none');
	$("#I" + currentQues).css('display', 'none');

	currentQues = num;
	nav = $("#page" + num);
	$("#Q" + currentQues).css('display', 'block');
	$("#A" + currentQues).css('display', 'block');
	$("#I" + currentQues).css('display', 'block');
	nav.attr('class', 'quesActive');

}