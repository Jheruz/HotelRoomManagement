<?php
session_start();
if (isset($_SESSION['name']))
{
	date_default_timezone_set('Asia/Manila');
	include_once('config.php');
	$rnum = $_POST['rnum'];
	$rtype = $_POST['rtype'];
	$c3hr = $_POST['c3hr'];
	$c12hr = $_POST['c12hr'];
	$c24hr = $_POST['c24hr'];
	$status = "AVAILABLE";
	$add = "INSERT INTO rooms (Room_Number,Room_Type,Cost_per_3hr,Cost_per_12hr,Cost_per_24hr,status) VALUES ('$rnum','$rtype','$c3hr','$c12hr','$c24hr','$status')";
	mysqli_query($conn,$add) or
	die('Query "' . $add . '" failed: ' . mysql_error());
						
	$date = date('m/d/Y');
	$time = date('h:i:sA');
	$name = $_SESSION['name'];
	$act = "You Added Room $rnum";
	$loglist = "INSERT INTO login_log (Staff_ID,Date,Time,Activity) VALUES (1,'$date','$time','$act')";
	mysqli_query($conn,$loglist) or
	die('Query "' . $loglist . '" failed: ' . mysql_error());
	header('location:rooms.php#table');
}
else{
	header('location:login.php');
}
?>