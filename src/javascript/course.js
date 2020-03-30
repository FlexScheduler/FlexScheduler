//Course finding with Ajax

$(document).ready(function(){

    $("#departID").change(function(){
        var deptid = $(this).val();
		
		//alert("Change!");

        $.ajax({
            url: 'config.php',
            type: 'post',
            data: {dept:deptid},
            dataType: 'json',
            success:function(response){

                var len = response.length;
				
				alert("Here");

                $("#courseName").empty();
                for( var i = 0; i<len; i++){
                    var id = response[i]['crseID'];
                    var name = response[i]['crseName'];
                    
                    $("#courseName").append("<option value='"+crseID+"'>"+crseName+"</option>");

                }
            }
        });
    });

});