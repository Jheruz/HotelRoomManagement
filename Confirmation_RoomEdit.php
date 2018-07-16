<?php
session_start();
if (isset($_SESSION['name']))
{
	if(isset($_GET['id'])){
		include_once('config.php');
		date_default_timezone_set('Asia/Manila');
		
		$rnum = $_POST['EDITrnum'];
		$rtype = $_POST['EDITrtype'];
		$c3hr = $_POST['EDITc3hr'];
		$c12hr = $_POST['EDITc12hr'];
		$c24hr = $_POST['EDITc24hr'];
		$add = "UPDATE rooms SET Room_Number = '$rnum', Room_Type = '$rtype', Cost_per_3hr = '$c3hr', Cost_per_12hr = '$c12hr', Cost_per_24hr = '$c24hr' WHERE Room_ID =".$_GET['id'];
		mysqli_query($conn,$add) or
		die('Query "' . $add . '" failed: ' . mysql_error());
		
		$date = date('m/d/Y');
		$time = date('h:i:sA');
		$name = $_SESSION['name'];
		$act = "You Edit Room $rnum";
		$loglist = "INSERT INTO login_log (Staff_ID,Date,Time,Activity) VALUES (1,'$date','$time','$act')";
		mysqli_query($conn,$loglist) or
		die('Query "' . $loglist . '" failed: ' . mysql_error());
		header('location:rooms.php#table');
	}
	else{
		header('location:login.php');
	}
}
else{
	header('location:login.php');
}
?>