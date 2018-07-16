<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotelroommanagement');
if(!$conn){
	echo "error: ".mysql_connect_error();
	exit();
}
?>