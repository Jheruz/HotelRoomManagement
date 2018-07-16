<?php
	include_once('config.php');
	mysqli_query($conn, "truncate login_log");
	header('Location:index.php');
?>