//Generate schedule logic

//treeNode class
class Node {
	constructor(value = 0, children = [], ID = 0, parentID = 0) {
		this.value = value;
		this.children = children;
		this.ID = ID;
		this.parentID = parentID;
	}
	
	addChild(childVal, it) {
		this.children[it] = new Node(childVal, [], maxID, this.ID);
		maxID++;
		return this;
	}
	
}

//ensure every Node has a unique ID
var maxID = 1;
//flag for schedules with time conflicts
var timeCol = false;


$(document).ready(function(){
	
	$( "#generate" ).on( "click", function() {
		//To order generated schedules
		var scheduleNo = 1;
		
		//Get variables to run correct query
		var term = $("#term").val();
		var online = 0;
		if($("#online").is(":checked"))
			online = 1;
		var campus = $("#campus").val();
		//We can deal with min and max credit later
		//Same for 8 week courses
		
		var breakCheck = 1;
		if(noBreaks == 0) {
			breakCheck = 0;
		}
		
		//Static for now
		var deptCheck = 1;
		var courseCheck = 1;
		var instrucCheck = 0;
		
		/*console.log(term);
		console.log(online);
		console.log(campus);
		console.log(breakCheck);*/
		
		//Get course info
		var courseTable = $("#course-table-body");
		var deptId = new Array();
		var courseId = new Array();
		var instructor = new Array();
		//Keep track of how many rows to account for
		var rowCount = 0;
		//Temp variables
		var dept, course, inst;
		
		courseTable.find('tr').each(function (i, el) {
        var $row = $(this).find('td'),
            dept = $row.eq(0).text(),
            course = $row.eq(1).text(),
            inst = $row.eq(2).text();
			//Get rid of course name as it is unnecessary
			var arr = course.split('-');
        //Add to array to use outside of loop
			deptId.push(dept);
			courseId.push(arr[0]);
			instructor.push(inst);
			rowCount++;
			
			/*console.log(deptId[i]);
			console.log(courseId[i]);
			console.log(instructor[i]);*/
		});
		
		//Send to php file
		$.ajax({
            url: 'querylogic.php',
            type: 'post',
            data: {term:term, online:online, campus:campus, breakCheck:breakCheck, deptCheck:deptCheck, rowCount:rowCount,
				courseCheck:courseCheck, instrucCheck:instrucCheck, deptId:deptId, courseId:courseId},
            dataType: 'json',
            success:function(response){
				//console.log(response);
				
				$("#table-list").empty();
				
				//array for previous course orderings
				var allSchedules = new Array();
				
				//array for course info
				var coursesToPrint = new Array();
				//convert 2d array to tree
				var tree = toTree(response);
				//keeps track of taken leaf nodes
				var takenIDs = new Array();
				
				var scheduleNo = 0;
				var loopFlag = true;

				//loop until the function runs out of leaf nodes
				while(loopFlag == true)
				{
					//create a dictionary for each day of the week
					var week = {};
					week['monStart'] = new Array();
					week['monEnd'] = new Array();
					week['tuesStart'] = new Array();
					week['tuesEnd'] = new Array();
					week['wedStart'] = new Array();
					week['wedEnd'] = new Array();
					week['thursStart'] = new Array();
					week['thursEnd'] = new Array();
					week['friStart'] = new Array();
					week['friEnd'] = new Array();
					
					loopFlag = getSchedule(coursesToPrint, tree.children[0], takenIDs, week);
					
					if(timeCol == false && loopFlag == true)
					{
						scheduleNo++;

						//To put the schedules into html
						var intohtml;
		
						intohtml = '<li><h5 class="my-0 font-weight-normal">Schedule #' + scheduleNo + '</h5></li>' +
						'<li><div id="table" class="table-editable">' +
						'<span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i' +
						'class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>' +
						'<table class="table table-bordered table-responsive-md table-striped text-center"><thead><tr>' +
						'<th class="text-center">Department</th>' +
						'<th class="text-center">Course ID</th>' +
						'<th class="text-center">Section</th>' +
						'<th class="text-center">Course Name</th>' +
						'<th class="text-center">Instructor</th>' +
						'<th class="text-center">Days</th>' +
						'<th class="text-center">Room</th>' +
						'<th class="text-center">Date</th>' +
						'<th class="text-center">Time</th>' +
						'</tr></thead><tbody>';
						for(var i=0; i < coursesToPrint.length; i++)
						{
							intohtml += '<tr>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['deptID'] +'</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['crseID'] +'</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['secID'] +'</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['crseName'] +'</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['instrFName'] + ' '+ coursesToPrint[i]['instrLName'] + '</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['dayID'] +'</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['bldgID'] + coursesToPrint[i]['rmNum'] +'</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['strtDate'] + ' - ' + coursesToPrint[i]['endDate'] +'</td>' +
							'<td class="pt-3-half">'+ coursesToPrint[i]['strtTime'] + ' - ' + coursesToPrint[i]['endTime'] +'</td></tr>';
						}
						intohtml += '</tbody></table></div></li>';
		
						$("#table-list").append(intohtml);
					
					}
					//Reset variables for next schedule
					coursesToPrint = [];
					timeCol = false;
				}
		
			},
			error:function(response, stat, err){
				console.log(err);
			}
		
        });
	});
	
	//Returns false if there is no time conflict, otherwise returns true
	function checkDays(section, dict) {
		//split day into a character array
		var day = section['dayID'].split("");
		//convert time format to minutes
		var startTime = section['strtTime'].split(':');
		var startHour = startTime[0];
		var startMin = startTime[1];
		var endTime = section['endTime'].split(':');
		var endHour = endTime[0];
		var endMin = endTime[1];
			
		var overlap = false;
			
		//checks for conflict one day at a time
		for(var j=0; j < day.length; j++)
		{
			var currentDayS, currentDayE;
				
			if(day[j] == 'M')
			{
				currentDayS = "monStart";
				currentDayE = "monEnd";
			}
			else if(day[j] == 'T')
			{
				currentDayS = "tuesStart";
				currentDayE = "tuesEnd";
			}
			else if(day[j] == 'W')
			{
				currentDayS = "wedStart";
				currentDayE = "wedEnd";
			}
			else if(day[j] == 'R')
			{
				currentDayS = "thursStart";
				currentDayE = "thursEnd";
			}
			else if(day[j] == 'F')
			{
				currentDayS = "friStart";
				currentDayE = "friEnd";
			}
				
			//check dictionary to see if the start or end times are between existing start and end times
			for(var i=0; i < dict[currentDayS].length; i++){
				if(startHour == dict[currentDayS][i][0])
				{ //two classes cannot start at the same time
					if(startMin == dict[currentDayS][i][1])
					{
						overlap = true;
					}
				}
				if(endHour == dict[currentDayS][i][0])
				{ //class cannot end after another one starts
					if(endMin >= dict[currentDayS][i][1])
					{
						overlap = true;
					}
				}
				if(startHour == dict[currentDayE][i][0])
				{ //class cannot start before another one ends
					if(startMin <= dict[currentDayE][i][1])
					{
						overlap = true;
					}
				}
			}
			
			//add new times to dictionary
			dict[currentDayS].push(startTime);
			dict[currentDayE].push(endTime);
			
		}//for loop
		
		return overlap;
		
	}//checkDays function
	
	//converts PHP response variable into a tree
	function toTree(response) {
		root = new Node;
		
		for(var i=0; i < response.length; i++)
		{
			//sometimes the query doesn't return any info (such as if the user chose the wrong campus)
			//so this checks that there is actual class info
			if(response[i].length > 0)
			{
				//this adds the first level of the tree which is the courses
				root.addChild(response[i][0]['deptID'] + response[i][0]['crseID'], i);
				//this adds the sections where each path from first child to leaf node is a schedule
				addSections(response, root.children[i], i, 0);
			}
		}
		
		return root;
	}
	
	//adds course sections to the tree
	function addSections(response, root, cor, pos) {
		//return if we have run out of courses to add
		if(cor == response.length)
			return;
		//iterates over each possible section
		//pos keeps track of sections, and j keeps track of the current position in Node
		for(var j=0; pos < response[cor].length; j++)
		{
			root.addChild(response[cor][pos], j)
			
			if(pos+1 < response[cor].length)
			{
				//check to see if there is a second time for a class and add it as the next Node if true
				if(response[cor][pos]['secID'] == response[cor][pos+1]['secID'] &&
					response[cor][pos]['dayID'] != response[cor][pos+1]['dayID'])
					{
						pos++; //this is where pos increments differently than j
						var child = new Node;
						child = root.children[j];
						child.addChild(response[cor][pos], 0);
						addSections(response, child.children[0], cor+1, 0);
					}
				else
					addSections(response, root.children[j], cor+1, 0);
			}
			pos++;
		}
		return;
	}
	
	//builds a schedule and puts it in an array
	//also keeps track of which leaf nodes have been found already
	//also checks for time conflicts and raises flag if there is a conflict
	function getSchedule(scheduleArr, node, takenIDs, dict) {
		if(node.children.length == 0)
		{
			for(var i=0; i < takenIDs.length; i++)
				if(node.ID == takenIDs[i])
					return false;
			
			checkDays(node.value, dict);
			scheduleArr.push(node.value);
			takenIDs.push(node.ID);
			return true;
		}
		else
		{
			for (var i=0; i < node.children.length; i++)
			{
				if(getSchedule(scheduleArr, node.children[i], takenIDs, dict) == true)
				{
					if(typeof node.value == 'object')
						if(checkDays(node.value, dict) == false)
							scheduleArr.push(node.value);
						else
							timeCol = true;
					return true;
				}
			}
		}
		return false;
	}
	
});