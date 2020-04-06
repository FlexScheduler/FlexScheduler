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
                for( var i = 0; i<len; i++){
                    var id = response[i]['crseID'];
                    var name = response[i]['crseName'];
                    //value holds both course ID and name in order to for the add function to work properly
                    $("#courseName").append("<option value='"+deptid+id+","+name+"'>"+name+"</option>");

                }
            }
        });
    });
	
	//Add button for courses
	$( "#courseAdd" ).on( "click", function() {
		//add info as variables
		var nameField = $("#courseName").val().split(',');
		var courseID = nameField[0];
		var courseName = nameField[1];
		var instructor = "Any"; //temporarily defaults to any
		
		$("#course-table-body").append('<tr><td class="pt-3-half" contenteditable="true">' + courseID + '</td><td class="pt-3-half" contenteditable="true">' + courseName + '</td><td class="pt-3-half" contenteditable="true">' + instructor + '</td><td><span class="table-remove"><button type="button" onclick = "remClass(this);"class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span></td>');
	});
	
	//Remove button for courses
	remClass = (function(row) {
		$(row).closest("tr").remove();
	});

});

