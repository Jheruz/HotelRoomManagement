<?php
session_start();
if (isset($_SESSION['name'])){
	include("config.php");
	$id = $_GET['id'];
	$rooms = mysqli_query($conn, "SELECT * FROM login_log where log_ID=$id");
	while($res=mysqli_fetch_assoc($rooms)){
		$rnum = $res['log_ID'];
	}
	mysqli_query($conn, "DELETE FROM login_log where log_ID=$id");
	header('location:index.php#table');
}
else{
	header('location:login.php');
}
?>