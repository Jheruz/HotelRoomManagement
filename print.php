<?php
session_start();
if (isset($_SESSION['name'])){
?>
<html>
<head>
<title>Hotel Room Management System</title>
<script src="jquery-3.1.1.min.js" type="text/javascript"></script>
<link href="Index.css" rel="stylesheet" type="text/css"/>
<script src="sweetalert-master/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
<style type='text/css'>
table { border: none; border-collapse: collapse; }
table td { border-left: 1px solid #000; font-size: 15px;}
table td:first-child { border-left: none; }
</style>
</head>
<body onLoad='btn()'>

<div class = "printHeaderL"><br>
	<label>Printed by: <?php echo $_SESSION['name']; ?><label> <br>
	<label>Print Date: <?php echo date('m/d/Y'); ?></label>
</div>

<center>
	<div class = "printHeaderC">
		<center>Slide n' Dive <br>
		<img src = "Hroom Pic/slidendive logo.jpg" width="20%" height></center>
	</div>
</center>
<hr>
	<?php
	$beginDate = "";
	$endDate = "";
	if(isset($_POST['bdate'])){
		$beginDate = date('m/d/Y', strtotime($_POST['bdate']));
		$endDate = date('m/d/Y', strtotime($_POST['edate']));
		echo "<label>Report Date From: $beginDate to $endDate</label> ";
	}
	else{
		echo "<label>Cannot Find The Date you Were Trying to print Please Go Back To report page and try again.</label> ";
	}
	?>
<hr>
<?php
	include_once('config.php');
	$result = mysqli_query($conn, "SELECT person.First_Name, person.Last_Name, transaction.Checkin_Date, transaction.Checkin_Time, transaction.Checkout_Date, transaction.Checkout_Time, transaction.Client_Name, transaction.Checkin_Type, transaction.Cost, transaction.Payment, transaction.Change, rooms.Room_Number, rooms.Room_Type, rooms.Room_Number
	FROM transaction,rooms,person WHERE Checkin_Date BETWEEN '$beginDate' AND '$endDate' AND rooms.Room_ID = transaction.Room_ID AND transaction.Staff_ID = person.Person_ID");

	echo"<center><span class = footer>";
	echo "<table width='100%' class='roomData'>";
		echo "<tr>";
			echo "<td align='center'> <font color='#646363' size=5>Staff Name</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Checkin Date</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Checkin Time</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Checkout Date</font></td>";
			echo "<td align='center'> <font color='#646363' size=5>Checkout Time</font></td>";
			echo "<td align='center'> <font color='#646363' size=5>Client Name</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Room Number</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Room Type</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Checkin Type</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Cost</font> </td>";
			echo "<td align='center'> <font color='#646363' size=5>Payment</font></td>";
			echo "<td align='center'> <font color='#646363' size=5>Change</font></td>";
			echo "</tr>";
			echo "<tr><td colspan='12'><hr></td></tr>";
	if(mysqli_num_rows($result) > 0){			
		while($res = mysqli_fetch_array($result)){
			echo "<tr>";
				echo "<td align='center'>".$res['First_Name']." ".$res['Last_Name']."</td>";
				echo "<td align='center'>".$res['Checkin_Date']."</td>";
				echo "<td align='center'>".$res['Checkin_Time']."</td>";
				echo "<td align='center'>".$res['Checkout_Date']."</td>";
				echo "<td align='center'>".$res['Checkout_Time']."</td>";
				echo "<td align='center'>".$res['Client_Name']."</td>";
				echo "<td align='center'>".$res['Room_Number']."</td>";
				echo "<td align='center'>".$res['Room_Type']."</td>";
				echo "<td align='center'>".$res['Checkin_Type']."</td>";
				echo "<td align='center'>".$res['Cost']."</td>";
				echo "<td align='center'>".$res['Payment']."</td>";
				echo "<td align='center'>".$res['Change']."</td>";
			echo "<tr>";
		}
	}
	else{
		echo"<tr><td colspan='12' align='center'>No Data To Display</td></tr>";
	}
	echo "</table></span></center>";
?>
<br>
	<a href="report.php"><input type="hidden" value="Back" id="back"></a>
<script>
function btn(){
	print();
	setTimeout(function myFunction(){
	$("#back").prop('type', 'button');
	} , 100);
}
</script>
</body>
</html>
<?php
}
else{
	header('location:login.php');
}
?>