<?php
require 'config.php';

$onlineCheck = $_POST['online'];
$departmentCheck = $_POST['deptCheck'];
$courseCheck = $_POST['courseCheck'];
$instrucCheck = $_POST['instrucCheck'];
$breakCheck = $_POST['breakCheck'];
$campus = $_POST['campus'];
$deptID = $_POST['deptId'];
$crseID = $_POST['courseId'];
$term = $_POST['term'];
$rowCount = $_POST['rowCount'];
$instrFName; $instrLName; $strtTime; $endTime; $day; $secID;

/*Either need to make a semester tag or run a query to get the
  end date and use that to judge semesters, online options will have
  to run both queries in order to get all results*/

/*A loop will run across this whole query list and each query gets put in an array of arrays
The finished array will be put in an array of arrays of arrays to be echoed back to the javascript file*/
$result = array();

for($i = 0; $i < $rowCount; $i++)
{
	$sql;
	$rowResult = array();
	
	$depart = $deptID[$i];
	$course = $crseID[$i];

  if ($term == "Fall"){
  //Online classes are wanted
  if($onlineCheck == True){
    //Department is SELECTed
    if($departmentCheck == True){
      //Course is SELECTed
      if($courseCheck == True){
        //Teacher is SELECTed
        if($instrucCheck == True){
          //Breaks entered
          if($breakCheck == True){
            /*In Class Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
             INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
             strtTime,endTime) Where sessions.deptID = "$deptID" AND
             sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
             instrLName = "$instrLName" AND sessions.strtTime NOT BETWEEN
             '$strtTime' AND '$endTime' AND dayID != '$day' AND campus = $campus;

             Online Query
             SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
              INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
              sections.deptID = "$deptID" AND crseID = $crseID AND instrFName =
              "$instrFName" AND instrLName = "$instrLName";
             */
          }
          //Breaks not entered
          else{
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND
            sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
            instrLName = "$instrLName" AND campus = $campus;

            Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID AND instrFName =
             "$instrFName" AND instrLName = "$instrLName"; */
          }
        }
        //Teacher not SELECTed
        else{
          //Breaks entered
          if($breakCheck == True){
            /*Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND sessions.crseID
            = "$crseID" AND sessions.strtTime NOT BETWEEN '$strtTime' AND '$endTime'
            AND dayID != '$day' AND campus = $campus;

            //Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID;*/
          }
          //No breaks entered
          else{
            /*Query
            crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum,campus From Sessions I
            nner Join Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = "$deptID" AND sessions.crseID = "$crseID" AND
            campus = $campus;

            //Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID;*/
          }
        }//Teacher not SELECTed
      }//Course SELECTed
      //Course is not SELECTed
      else{
        //Breaks entered
        if($breakCheck == True){
          /*Query
          SELECT secID, crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,campus
          From S INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
          sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
          Where sessions.deptID = "$deptID" AND sessions.strtTime NOT BETWEEN
          $strtTime AND $endTime AND dayID != '$day' AND campus = $campus;

          Online Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = "$deptID";*/
        }
        //Break not entered
        else{
          /*Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          campus FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = "$deptID" AND campus =
          $campus;

          Online Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = "$deptID";
          */
        }
      }//Course not entered
    }//Department Check
  }//Online SELECTed
  //No online
  else{
    //Department is SELECTed
    if($departmentCheck == True){
      //Course is SELECTed
      if($courseCheck == True){
        //Teacher is SELECTed
        if($instrucCheck == True){
          //Breaks entered
          if($breakCheck == True){
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
             INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
             strtTime,endTime) Where sessions.deptID = "$deptID" AND
             sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
             instrLName = "$instrLName" AND sessions.strtTime NOT BETWEEN
             '$strtTime' AND '$endTime' AND dayID != '$day' AND campus = $campus;*/
          }
          //Breaks not entered
          else{
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND
            sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
            instrLName = "$instrLName" AND campus = $campus;*/
          }
        }
        //Teacher not SELECTed
        else{
          //Breaks entered
          if($breakCheck == True){
            /*Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND sessions.crseID
            = "$crseID" AND sessions.strtTime NOT BETWEEN '$strtTime' AND '$endTime'
            AND dayID != '$day' AND campus = $campus;*/
          }
          //No breaks entered
          else{
            /*Query
            crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum,campus From Sessions I
            nner Join Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = "$deptID" AND sessions.crseID = "$crseID" AND
            campus = $campus;*/
          }
        }//Teacher not SELECTed
      }//Course SELECTed
      //Course is not SELECTed
      else{
        //Breaks entered
        if($breakCheck == True){
          /*
          SELECT secID, crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,campus
          From S INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
          sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
          Where sessions.deptID = "$deptID" AND sessions.strtTime NOT BETWEEN
          $strtTime AND $endTime AND dayID != '$day' AND campus = $campus;*/
        }
        //Break not entered
        else{
          /*Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          campus FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = "$deptID" AND campus =
          $campus;*/
        }
      }//Course not entered
    }//Department Check
  }//No Online
}//TermCheck
  else if ($term == "Spring"){
  //Online classes are wanted
  if($onlineCheck == True){
    //Department is SELECTed
    if($departmentCheck == True){
      //Course is SELECTed
      if($courseCheck == True){
        //Teacher is SELECTed
        if($instrucCheck == True){
          //Breaks entered
          if($breakCheck == True){
            /*In Class Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
             INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
             strtTime,endTime) Where sessions.deptID = "$deptID" AND
             sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
             instrLName = "$instrLName" AND sessions.strtTime NOT BETWEEN
             '$strtTime' AND '$endTime' AND dayID != '$day' AND campus = $campus;

             Online Query
             SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
              INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
              sections.deptID = "$deptID" AND crseID = $crseID AND instrFName =
              "$instrFName" AND instrLName = "$instrLName";
             */
          }
          //Breaks not entered
          else{
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND
            sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
            instrLName = "$instrLName" AND campus = $campus;

            Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID AND instrFName =
             "$instrFName" AND instrLName = "$instrLName"; */
          }
        }
        //Teacher not SELECTed
        else{
          //Breaks entered
          if($breakCheck == True){
            /*Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND sessions.crseID
            = "$crseID" AND sessions.strtTime NOT BETWEEN '$strtTime' AND '$endTime'
            AND dayID != '$day' AND campus = $campus;

            //Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID;*/
          }
          //No breaks entered
          else{
            /*Query
            crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum,campus From Sessions I
            nner Join Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = "$deptID" AND sessions.crseID = "$crseID" AND
            campus = $campus;

            //Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID;*/
          }
        }//Teacher not SELECTed
      }//Course SELECTed
      //Course is not SELECTed
      else{
        //Breaks entered
        if($breakCheck == True){
          /*Query
          SELECT secID, crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,campus
          From S INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
          sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
          Where sessions.deptID = "$deptID" AND sessions.strtTime NOT BETWEEN
          $strtTime AND $endTime AND dayID != '$day' AND campus = $campus;

          Online Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = "$deptID";*/
        }
        //Break not entered
        else{
          /*Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          campus FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = "$deptID" AND campus =
          $campus;

          Online Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = "$deptID";
          */
        }
      }//Course not entered
    }//Department Check
  }//Online SELECTed
  //No online
  else{
    //Department is SELECTed
    if($departmentCheck == True){
      //Course is SELECTed
      if($courseCheck == True){
        //Teacher is SELECTed
        if($instrucCheck == True){
          //Breaks entered
          if($breakCheck == True){
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
             INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
             strtTime,endTime) Where sessions.deptID = "$deptID" AND
             sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
             instrLName = "$instrLName" AND sessions.strtTime NOT BETWEEN
             '$strtTime' AND '$endTime' AND dayID != '$day' AND campus = $campus;*/
          }
          //Breaks not entered
          else{
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND
            sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
            instrLName = "$instrLName" AND campus = $campus;*/
          }
        }
        //Teacher not SELECTed
        else{
          //Breaks entered
          if($breakCheck == True){
            /*Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND sessions.crseID
            = "$crseID" AND sessions.strtTime NOT BETWEEN '$strtTime' AND '$endTime'
            AND dayID != '$day' AND campus = $campus;*/
          }
          //No breaks entered
          else{
            //Query
            $sql = "SELECT crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum, secID From sessions
            INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = '$depart' AND sessions.crseID = '$course' AND
            campus = '$campus'";
          }
        }//Teacher not SELECTed
      }//Course SELECTed
      //Course is not SELECTed
      else{
        //Breaks entered
        if($breakCheck == True){
          /*
          SELECT secID, crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,campus
          From S INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
          sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
          Where sessions.deptID = "$deptID" AND sessions.strtTime NOT BETWEEN
          $strtTime AND $endTime AND dayID != '$day' AND campus = $campus;*/
        }
        //Break not entered
        else{
          /*Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          campus FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = "$deptID" AND campus =
          $campus;*/
        }
      }//Course not entered
    }//Department Check
  }//No Online
  }//TermCheck
  if ($term == "Summer"){
  //Online classes are wanted
  if($onlineCheck == True){
    //Department is SELECTed
    if($departmentCheck == True){
      //Course is SELECTed
      if($courseCheck == True){
        //Teacher is SELECTed
        if($instrucCheck == True){
          //Breaks entered
          if($breakCheck == True){
            /*In Class Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
             INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
             strtTime,endTime) Where sessions.deptID = "$deptID" AND
             sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
             instrLName = "$instrLName" AND sessions.strtTime NOT BETWEEN
             '$strtTime' AND '$endTime' AND dayID != '$day' AND campus = $campus;

             Online Query
             SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
              INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
              sections.deptID = "$deptID" AND crseID = $crseID AND instrFName =
              "$instrFName" AND instrLName = "$instrLName";
             */
          }
          //Breaks not entered
          else{
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND
            sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
            instrLName = "$instrLName" AND campus = $campus;

            Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID AND instrFName =
             "$instrFName" AND instrLName = "$instrLName"; */
          }
        }
        //Teacher not SELECTed
        else{
          //Breaks entered
          if($breakCheck == True){
            /*Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND sessions.crseID
            = "$crseID" AND sessions.strtTime NOT BETWEEN '$strtTime' AND '$endTime'
            AND dayID != '$day' AND campus = $campus;

            //Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID;*/
          }
          //No breaks entered
          else{
            /*Query
            crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum,campus From Sessions I
            nner Join Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = "$deptID" AND sessions.crseID = "$crseID" AND
            campus = $campus;

            //Online Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
             INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
             sections.deptID = "$deptID" AND crseID = $crseID;*/
          }
        }//Teacher not SELECTed
      }//Course SELECTed
      //Course is not SELECTed
      else{
        //Breaks entered
        if($breakCheck == True){
          /*Query
          SELECT secID, crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,campus
          From S INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
          sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
          Where sessions.deptID = "$deptID" AND sessions.strtTime NOT BETWEEN
          $strtTime AND $endTime AND dayID != '$day' AND campus = $campus;

          Online Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = "$deptID";*/
        }
        //Break not entered
        else{
          /*Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          campus FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = "$deptID" AND campus =
          $campus;

          Online Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate From Sections
          INNER JOIN arrangedInstructors USING(deptID,crseID,secID)  Where
          sections.deptID = "$deptID";
          */
        }
      }//Course not entered
    }//Department Check
  }//Online SELECTed
  //No online
  else{
    //Department is SELECTed
    if($departmentCheck == True){
      //Course is SELECTed
      if($courseCheck == True){
        //Teacher is SELECTed
        if($instrucCheck == True){
          //Breaks entered
          if($breakCheck == True){
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
             INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
             strtTime,endTime) Where sessions.deptID = "$deptID" AND
             sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
             instrLName = "$instrLName" AND sessions.strtTime NOT BETWEEN
             '$strtTime' AND '$endTime' AND dayID != '$day' AND campus = $campus;*/
          }
          //Breaks not entered
          else{
            /*
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND
            sessions.crseID = "$crseID" AND instrFName = "$instrFName" AND
            instrLName = "$instrLName" AND campus = $campus;*/
          }
        }
        //Teacher not SELECTed
        else{
          //Breaks entered
          if($breakCheck == True){
            /*Query
            SELECT crseName,instrFName,instrLName,strtDate,endDate,
            sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
            campus From Sessions INNER JOIN Sections USING (deptID,crseID,secID)
            INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
            strtTime,endTime) Where sessions.deptID = "$deptID" AND sessions.crseID
            = "$crseID" AND sessions.strtTime NOT BETWEEN '$strtTime' AND '$endTime'
            AND dayID != '$day' AND campus = $campus;*/
          }
          //No breaks entered
          else{
            /*Query
            crseName,instrFName,instrLName,strtDate,endDate,sessions.strtTime,
            sessions.endTime,sessions.dayID,bldgID,rmNum,campus From Sessions I
            nner Join Sections USING (deptID,crseID,secID) INNER JOIN
            sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
            Where sessions.deptID = "$deptID" AND sessions.crseID = "$crseID" AND
            campus = $campus;*/
          }
        }//Teacher not SELECTed
      }//Course SELECTed
      //Course is not SELECTed
      else{
        //Breaks entered
        if($breakCheck == True){
          /*
          SELECT secID, crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,campus
          From S INNER JOIN Sections USING (deptID,crseID,secID) INNER JOIN
          sessionInstructors Using(deptID,crseID,secID,dayID,strtTime,endTime)
          Where sessions.deptID = "$deptID" AND sessions.strtTime NOT BETWEEN
          $strtTime AND $endTime AND dayID != '$day' AND campus = $campus;*/
        }
        //Break not entered
        else{
          /*Query
          SELECT crseName,instrFName,instrLName,strtDate,endDate,
          sessions.strtTime,sessions.endTime,sessions.dayID,bldgID,rmNum,
          campus FROM Sessions INNER JOIN Sections USING (deptID,crseID,secID)
          INNER JOIN sessionInstructors Using(deptID,crseID,secID,dayID,
          strtTime,endTime) WHERE sessions.deptID = "$deptID" AND campus =
          $campus;*/
        }
      }//Course not entered
    }//Department Check
  }//No Online
  }//TermCheck

  //This is a test query to makes sure queries in general work
  //$sql = "SELECT crseName FROM sections WHERE deptID = '$depart' AND crseID = '$course'";

	//Logic
	$queryResult = mysqli_query($con,$sql);
	
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
	
	//Put array of results into the final array
	$result[] = $rowResult;
}//for loop

//echo final result
echo json_encode($result);
?>
