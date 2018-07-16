<?php
	include_once('config.php');
	$fName = $_POST['fn'];
	$lName = $_POST['ln'];
	$address = $_POST['address'];
	$user = $_POST['un'];
	$pass = $_POST['pass'];
						
	$addToStaff = mysqli_query($conn, "INSERT INTO staff (Person_ID,Username,Password) VALUES ('1','$user','$pass')");
	$addToPerson = mysqli_query($conn, "INSERT INTO person (First_Name,Last_Name,Address) VALUES ('$fName','$lName','$address')");
?>
<script>
location.href = "login.php";
</script>