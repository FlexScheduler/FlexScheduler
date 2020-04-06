<?php
//Will give an error if the database has not yet been made
$con = mysqli_connect("localhost", "root", "", "senprojtest");

//Acts upon AJAX sending request
if (isset($_POST['dept'])) {
	
	$departid = $_POST['dept'];
	$courseName = array();
	
	$sql = "SELECT DISTINCT crseID,crseName FROM sections WHERE deptID='$departid'";
	$result = mysqli_query($con,$sql);
	
	while( $row = mysqli_fetch_array($result) ){
		$crseID = $row['crseID'];
		$name = $row['crseName'];

		$courseName[] = array("crseID" => $crseID, "crseName" => $name);
	}
    
	//AJAX accepts json format
	echo json_encode($courseName);
}
?>