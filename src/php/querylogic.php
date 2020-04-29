<?php
require 'config.php';

$onlineCheck = $_POST['online'];
$departmentCheck = $_POST['deptCheck'];
$campus = $_POST['campus'];
$deptID = $_POST['deptId'];
$crseID = $_POST['courseId'];
$term = $_POST['term'];
$rowCount = $_POST['rowCount'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$secID;

/*A loop will run across this whole query list and each query gets put in an array of objects
The finished array will be put in an array of arrays of objects to be echoed back to the javascript file*/
$result = array();

for($i = 0; $i < $rowCount; $i++)
{
	$sql;
	$rowResult = array();
	
	$depart = $deptID[$i];
	$course = $crseID[$i];
	
	if($course == "Any")
		$courseCheck = False;
	else
		$courseCheck = True;

	if($lastName[$i] == "Any")
		$instrucCheck = False;
	else
	{
		$instrFName = $firstName[$i];
		$instrLName = $lastName[$i];
		$instrucCheck = True;
	}

  if ($term == "Fall"){
    //Online classes are wanted
  if($onlineCheck == True){
    //Department is selected
    if($departmentCheck == True){
      //Course is selected
      if($courseCheck == True){
        //Teacher is selected
        if($instrucCheck == True){
           
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            secID From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = '$depart' AND
            sessions.crseID = '$course' AND instrFName = '$instrFName' AND
            instrLName = '$instrLName' AND campus = '$campus'";

            //Online Query
            $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = '$depart' AND crseID = '$course' AND instrFName =
             '$instrFName' AND instrLName = '$instrLName'";
        }
        //Teacher not selected
        else{
            //Query
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum, secID From sessions
            INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = '$depart' AND sessions.crseID = '$course' AND
            campus = '$campus'";

            //Online Query
            $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = '$depart' AND crseID = '$course'";
        }//Teacher not selected
      }//Course selected
      //Course is not selected
      else{
          //Query
          $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          secID, crseID FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = '$depart' AND campus =
          '$campus'";

          //Online Query
          $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID, crseID From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = '$depart'";
      }//Course not entered
    }//Department Check
  }//Online selected
  //No online
  else{
    //Department is selected
    if($departmentCheck == True){
      //Course is selected
      if($courseCheck == True){
        //Teacher is selected
        if($instrucCheck == True){
            
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            secID From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = '$depart' AND
            sessions.crseID = '$course' AND instrFName = '$instrFName' AND
            instrLName = '$instrLName' AND campus = '$campus'";
        }
        //Teacher not selected
        else{
            //Query
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum, secID From sessions
            INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = '$depart' AND sessions.crseID = '$course' AND
            campus = '$campus'";
        }//Teacher not selected
      }//Course selected
      //Course is not selected
      else{
          //Query
          $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          secID, crseID FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = '$depart' AND campus =
          '$campus'";
      }//Course not entered
    }//Department Check
  }//No Online
}//TermCheck
  else if ($term == "Spring"){
  //Online classes are wanted
  if($onlineCheck == True){
    //Department is selected
    if($departmentCheck == True){
      //Course is selected
      if($courseCheck == True){
        //Teacher is selected
        if($instrucCheck == True){
           
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            secID From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = '$depart' AND
            sessions.crseID = '$course' AND instrFName = '$instrFName' AND
            instrLName = '$instrLName' AND campus = '$campus'";

            //Online Query
            $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = '$depart' AND crseID = '$course' AND instrFName =
             '$instrFName' AND instrLName = '$instrLName'";
        }
        //Teacher not selected
        else{
            //Query
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum, secID From sessions
            INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = '$depart' AND sessions.crseID = '$course' AND
            campus = '$campus'";

            //Online Query
            $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = '$depart' AND crseID = '$course'";
        }//Teacher not selected
      }//Course selected
      //Course is not selected
      else{
          //Query
          $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          secID, crseID FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = '$depart' AND campus =
          '$campus'";

          //Online Query
          $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID, crseID From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = '$depart'";
      }//Course not entered
    }//Department Check
  }//Online selected
  //No online
  else{
    //Department is selected
    if($departmentCheck == True){
      //Course is selected
      if($courseCheck == True){
        //Teacher is selected
        if($instrucCheck == True){
            
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            secID From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = '$depart' AND
            sessions.crseID = '$course' AND instrFName = '$instrFName' AND
            instrLName = '$instrLName' AND campus = '$campus'";
        }
        //Teacher not selected
        else{
            //Query
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum, secID From sessions
            INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = '$depart' AND sessions.crseID = '$course' AND
            campus = '$campus'";
        }//Teacher not selected
      }//Course selected
      //Course is not selected
      else{
          //Query
          $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          secID, crseID FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = '$depart' AND campus =
          '$campus'";
      }//Course not entered
    }//Department Check
  }//No Online
  }//TermCheck
  if ($term == "Summer"){
    //Online classes are wanted
  if($onlineCheck == True){
    //Department is selected
    if($departmentCheck == True){
      //Course is selected
      if($courseCheck == True){
        //Teacher is selected
        if($instrucCheck == True){
           
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            secID From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = '$depart' AND
            sessions.crseID = '$course' AND instrFName = '$instrFName' AND
            instrLName = '$instrLName' AND campus = '$campus'";

            //Online Query
            $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = '$depart' AND crseID = '$course' AND instrFName =
             '$instrFName' AND instrLName = '$instrLName'";
        }
        //Teacher not selected
        else{
            //Query
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum, secID From sessions
            INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = '$depart' AND sessions.crseID = '$course' AND
            campus = '$campus'";

            //Online Query
            $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = '$depart' AND crseID = '$course'";
        }//Teacher not selected
      }//Course selected
      //Course is not selected
      else{
          //Query
          $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          secID, crseID FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = '$depart' AND campus =
          '$campus'";

          //Online Query
          $sqlOnline = "SELECT crseName,instrFName,instrLName,strtDate,endDate, secID, crseID From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = '$depart'";
      }//Course not entered
    }//Department Check
  }//Online selected
  //No online
  else{
    //Department is selected
    if($departmentCheck == True){
      //Course is selected
      if($courseCheck == True){
        //Teacher is selected
        if($instrucCheck == True){
            
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            secID From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = '$depart' AND
            sessions.crseID = '$course' AND instrFName = '$instrFName' AND
            instrLName = '$instrLName' AND campus = '$campus'";
        }
        //Teacher not selected
        else{
            //Query
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum, secID From sessions
            INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = '$depart' AND sessions.crseID = '$course' AND
            campus = '$campus'";
        }//Teacher not selected
      }//Course selected
      //Course is not selected
      else{
          //Query
          $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          secID, crseID FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = '$depart' AND campus =
          '$campus'";
      }//Course not entered
    }//Department Check
  }//No Online
  }//TermCheck

  //This is a test query to makes sure queries in general work
  //$sql = "SELECT crseName FROM sections WHERE deptID = '$depart' AND crseID = '$course'";
	
	$queryResult = mysqli_query($con,$sql);
	
	//Check for empty query
	if(mysqli_num_rows($queryResult) > 0)
	{
	
	  while( $row = mysqli_fetch_array($queryResult) ){
		$crseName = $row['crseName'];
		$fName = $row['instrFName'];
		$lName = $row['instrLName'];
		$strtDate = $row['strtDate'];
		$endDate = $row['endDate'];
		$strtTime = $row['strtTime'];
        $endTime = $row['endTime'];
		$dayID = $row['dayID'];
		$bldgID = $row['bldgID'];
		$rmNum = $row['rmNum'];
		$secID = $row['secID'];
		
		//Add course ID in case it was not specified
		if($courseCheck == False)
			$course = $row['crseID'];
		
		//flag to check if the course is new or if the dayID needs to be updated
		$new = 1;
		
		//if course is already in array, add the new day and set flag to not re-add the course
		for($j = 0; $j < count($rowResult); $j++)
		{
			if($rowResult[$j]['crseName'] == $crseName && $rowResult[$j]['secID'] == $secID
				&& $rowResult[$j]['strtTime'] == $strtTime && $rowResult[$j]['endTime'] == $endTime)
			{
				$rowResult[$j]['dayID'] .= $dayID;
				$new = 0;
			}
		}
		//If this is a new course (as opposed to just updating dayID), add to array
		if($new == 1)
		{
			$rowResult[] = array("crseName" => $crseName, "instrFName" => $fName, "instrLName" => $lName, "strtDate" => $strtDate,
				"endDate" => $endDate, "strtTime" => $strtTime, "endTime" => $endTime, "dayID" => $dayID, "bldgID" => $bldgID,
				"rmNum" => $rmNum, "secID" => $secID, "deptID" => $depart, "crseID" => $course);
		}
		else
			$new = 1;
	  }
	}
	  //if online was selected, run the second query and append
	  if($onlineCheck == True)
	  {
		$onlineQuery = mysqli_query($con, $sqlOnline);
		
		if(mysqli_num_rows($onlineQuery) > 0)
		{
		
		  while($row = mysqli_fetch_array($onlineQuery) ){
			$crseName = $row['crseName'];
			$fName = $row['instrFName'];
			$lName = $row['instrLName'];
			$strtDate = $row['strtDate'];
			$endDate = $row['endDate'];
			$secID = $row['secID'];
			
			//Add course ID in case it was not specified
			if($courseCheck == False)
				$course = $row['crseID'];
			
			$rowResult[] = array("crseName" => $crseName, "instrFName" => $fName, "instrLName" => $lName, "strtDate" => $strtDate,
				"endDate" => $endDate, "secID" => $secID, "deptID" => $depart, "crseID" => $course);
		  }
		}
	  }
	
	  //Put array of results into the final array
	  $result[] = $rowResult;
}//for loop

//echo final result
echo json_encode($result);
?>
