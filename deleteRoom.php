<?php
session_start();
if (isset($_SESSION['name'])){
	date_default_timezone_set('Asia/Manila');
	include("config.php");
	$id = $_GET['id'];
	$rooms = mysqli_query($conn, "SELECT * FROM rooms where Room_ID=$id");
	while($res=mysqli_fetch_array($rooms)){
		$rnum = $res['Room_Number'];
	}
	$result=mysqli_query($conn, "DELETE FROM Rooms where Room_ID=$id");
	
	$date = date('m/d/Y');
	$time = date('h:i:sA');
	$name = $_SESSION['name'];
	$act = "You Deleted Room $rnum";
	$loglist = "INSERT INTO login_log (Staff_ID,Date,Time,Activity) VALUES (1,'$date','$time','$act')";
	mysqli_query($conn, $loglist) or
	die('Query "' . $loglist . '" failed: ' . mysqli_error());
	header('location:rooms.php#table');
}
else{
	header('location:login.php');
}
?>
