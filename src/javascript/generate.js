//Generate schedule logic

$(document).ready(function(){
	
	$( "#generate" ).on( "click", function() {
		var scheduleNo = 1;
		
		//Once varaibles are in place, create the appropriate number of schedules
		$("#table-list").append('<li><h5 class="my-0 font-weight-normal">Schedule #' + scheduleNo + '</h5></li>' +
			'<li><div id="table" class="table-editable">' +
			'<span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i' +
			'class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>' +
			'<table class="table table-bordered table-responsive-md table-striped text-center"><thead><tr>' +
			'<th class="text-center">Department</th>' +
            '<th class="text-center">Course ID</th>' +
            '<th class="text-center">Type</th>' +
            '<th class="text-center">Section</th>' +
			'<th class="text-center">Course Name</th>' +
			'<th class="text-center">Instructor</th>' +
			'<th class="text-center">Days</th>' +
			'<th class="text-center">Room</th>' +
			'<th class="text-center">Date</th>' +
			'<th class="text-center">Time</th>' +
			'</tr></thead>' +
			//logic here
			'<tbody><tr>' +
			'<td class="pt-3-half" contenteditable="true">CSC</td>' +
			'<td class="pt-3-half" contenteditable="true">14400</td>' +
			'<td class="pt-3-half" contenteditable="true">Online</td>' +
			'<td class="pt-3-half" contenteditable="true">Ol0 1</td>' +
			'<td class="pt-3-half" contenteditable="true">Computer Science 1</td>' +
            '<td class="pt-3-half" contenteditable="true">Blythe</td>' +
			'<td class="pt-3-half" contenteditable="true">MWF</td>' +
			'<td class="pt-3-half" contenteditable="true">Online</td>' +
			'<td class="pt-3-half" contenteditable="true">1/20/2020 - 5/11/2020</td>' +
			'<td class="pt-3-half" contenteditable="true">ARR</td>' +
			'</tr></table></div></li>');
	});
});