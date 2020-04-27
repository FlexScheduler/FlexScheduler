//Course finding with Ajax

$(document).ready(function(){

    $("#departID").on("change", function(){
        var deptid = $(this).val();
		
		//console.log(deptid); //For testing

        $.ajax({
            url: 'config.php',
            type: 'post',
            data: {dept:deptid},
            dataType: 'json',
            success:function(response){

                var len = response.length;
				
				//console.log(response); //For testing

                $("#courseName").empty();
				$("#courseName").append("<option value='0'>Any</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['crseID'];
                    var name = response[i]['crseName'];
                    //value holds both course ID and name in order to for the add function to work properly
                    $("#courseName").append("<option value='"+id+","+name+"'>"+name+"</option>");

                }
            }
        });
    });
	
	$("#courseName").on("change", function(){
        var value = $(this).val();
		var course = value.split(",");
		var courseID = course[0];
		
		var deptID = $("#departID").val();

        $.ajax({
            url: 'config.php',
            type: 'post',
            data: {courseID:courseID, deptID, deptID},
            dataType: 'json',
            success:function(response){

                var len = response.length;
				
				//console.log(response); //For testing

                $("#instructor").empty();
				$("#instructor").append("<option value='Any'>Any</option>");
                for( var i = 0; i<len; i++){
                    var fName = response[i]['instrFName'];
                    var lName = response[i]['instrLName'];
                    //value holds both course ID and name in order to for the add function to work properly
                    $("#instructor").append("<option value='"+lName+","+fName+"'>"+lName+","+fName+"</option>");

                }
            }
        });
    });
	
	//Add button for courses
	$( "#courseAdd" ).on( "click", function() {
		//add info as variables
		var deptId = $("#departID").val();
		var instructor = $("#instructor").val();
		if($("#courseName").val() != 0)
		{
			var nameField = $("#courseName").val().split(',');
			var courseID = nameField[0];
			var courseName = nameField[1];
			$("#course-table-body").append('<tr><td class="pt-3-half" contenteditable="true">' + deptId + 
			'</td><td class="pt-3-half" contenteditable="true">' + courseID + "-" + courseName + 
			'</td><td class="pt-3-half" contenteditable="true">' + instructor + 
			'</td><td><span class="table-remove"><button type="button" onclick = "remClass(this);"class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span></td>');
		}
		else
		{
			$("#course-table-body").append('<tr><td class="pt-3-half" contenteditable="true">' + deptId + 
			'</td><td class="pt-3-half" contenteditable="true">Any' + 
			'</td><td class="pt-3-half" contenteditable="true">Any' + 
			'</td><td><span class="table-remove"><button type="button" onclick = "remClass(this);"class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span></td>');
		}
		
	});
	
	//Remove button for courses
	remClass = (function(row) {
		$(row).closest("tr").remove();
	});

});

