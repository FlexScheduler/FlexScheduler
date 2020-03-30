<?php
$con = mysqli_connect("localhost", "root", "", "senprojtest");

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['dept'])) {
	
	$departid = $_POST['dept'];
    
	$courseName = array();
	
	$sql = "SELECT crseID,crseName FROM sections WHERE deptID=".$departid;

	$result = mysqli_query($con,$sql);
	
	while( $row = mysqli_fetch_array($result) ){
    $crseID = $row['crseID'];
    $name = $row['crseName'];

    $courseName[] = array("crseID" => $crseID, "crseName" => $name);
}
    

	// encoding array to json format
	echo json_encode($courseName);
}
?>