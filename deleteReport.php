<?php
session_start();
	if (isset($_SESSION['name']))
	{
		date_default_timezone_set('Asia/Manila');
		include_once("config.php");
		mysqli_query($conn, "truncate report");
		$date = date('d-m-Y');
		$time = date('h:i:sA');
		$name = $_SESSION['name'];
		$act = "You Deleted the report";
		mysqli_query($conn, "INSERT INTO login_log (Date,Time,Name_Of_Staff,Activity) VALUES ('$date','$time','$name','$act')");
		header('location:report.php');
	}
	else
	{
		header('location:login.php');
	}
?>