<?php

session_start();
if (isset($_SESSION['name']))
{
	date_default_timezone_set('Asia/Manila');
	include_once('config.php');
	$id=$_GET['id'];
	$query = "UPDATE Rooms SET Status='AVAILABLE' WHERE Room_ID=$id";
	mysqli_query($conn, $query) or  die('Query "' . $query . '" failed: ' . mysqli_error());
	
	$result = mysqli_query($conn, "SELECT * FROM rooms where Room_ID = $id");
	while($res=mysqli_fetch_array($result)){
		$rn = $res['Room_Number'];
	}
	$date = date('m/d/Y');
	$time = date('h:i:sA');	
	$name = $_SESSION['name'];	
	$act = "Your Client at Room $rn Left the hotel";
	$loglist = "INSERT INTO login_log (Staff_ID,Date,Time,Activity) VALUES (1,'$date','$time','$act')";
	mysqli_query($conn, $loglist) or
	die('Query "' . $query . '" failed: ' . mysqli_error());
	
	header('location:rooms.php#table');
}
else{
	header('location:login.php');
}
?>