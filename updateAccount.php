<?php
session_start();
if (isset($_SESSION['name']))
{
	include_once('config.php');
	$id = $_POST['id'];
	$fName = $_POST['fn'];
	$lName = $_POST['ln'];
	$address = $_POST['add'];
	$user = $_POST['un'];
	$pass = $_POST['pass'];
	$add = "UPDATE staff,person SET person.First_Name='$fName',person.Last_Name='$lName',person.Address='$address',staff.Username='$user',staff.Password='$pass' WHERE staff.Staff_ID=$id";
	mysql_query($add) or
	die('Query "' . $add . '" failed: ' . mysql_error());
	
	echo"<script>location.href = 'maccount.php';</script>";
}
else{
	header('location:login.php');
}
?>