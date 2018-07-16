<html>
<head>
<title>Hotel Room Management System</title>
<link href="Index.css" rel="stylesheet" type="text/css"/>
<script src="sweetalert-master/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
</head>
<body bgcolor=#e9e9e9>
<?php
	session_start();
	if (isset($_SESSION['name']))
	{
		include('config.php');
?>
<div id = 'headeragainWhite'>
	<div class = kaliwa>
		<center><a href='index.php'>Homepage</a> &nbsp; &nbsp;  <a href='rooms.php'>Rooms</a></center>
	</div>
	
	<div class = kanan>
		<center><a href='report.php'>Report</a> &nbsp; &nbsp; <a href='contactus.php'>Contact Us</a></center>
	</div>
</div>
<center>
<?php ////////////////////////////////////////////NOTIFICATION BEGIN/////////////////////////////////////////////////// ?>
			<div id='notifPic' class='notif' title='Notifications'>
				<img src='Hroom Pic/notifRoom.png' id='notif1' onClick='hideShow()'>
				<span id='notifCount' onClick='hideShow()'>
				<?php
				$notifNumber = mysqli_query($conn, "SELECT *FROM notification WHERE Status = 0");
				if(mysqli_num_rows($notifNumber) > 0){
					echo mysqli_num_rows($notifNumber);
				}
				else{
					echo $number = "";
				}
				?>
				</span>
			</div>
			
			<div id='notifPanel' class='notifView'>
			<label>Notifications</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='?clear=true'>Mark All as Read</a><br>
			<hr>
			<?php
			$notifLog = mysqli_query($conn, "SELECT notification.Id,notification.Status,rooms.Room_Number,notification.Details,rooms.Room_Type,notification.Date,notification.Time FROM notification,rooms WHERE notification.Room_ID = rooms.Room_ID ORDER BY id DESC LIMIT 5");
			if(mysqli_num_rows($notifLog) > 0){
				while($notif = mysqli_fetch_array($notifLog)){
					$uniqID = $notif['Id'];
					$a = $notif['Room_Number'];
					$stats = $notif['Status'];
					if($stats == 0){echo "<center><div class='notifViewdata'><a href='rooms.php?notifID=$uniqID&rn=$a#$a' id='link'><table width='100%'>";}
					else{echo "<center><div class='notifdata'><a href='rooms.php?notifID=$uniqID&rn=$a#$a' id='link'><table width='100%'>";}
						echo"<tr><td width='20%' align='center'><font size='5'>".$notif['Room_Number']."</font></td>";
						echo"<td align='center' width='30%'><font size='4'>".$notif['Details']."</font></td></center>";
						echo"<td align='right' width='60%'><font size='2'><b>Room Type:</b> ".$notif['Room_Type']."</font></td></tr>";
						echo"<tr><td colspan='3' height='30%' align='center'><font size='2'><b>Date: </b>".$notif['Date']." &nbsp &nbsp &nbsp<b>Time: </b>".$notif['Time']."</font></td></tr>";
						echo"</table></a></div></center>";
				}
			}
			else{
				echo"<center>No New Notification</center>";
			}
			if(isset($_GET['clear'])){
				mysqli_query($conn, "UPDATE notification set Status = 1");
				echo"<script>location.href='report.php';</script>";
			}
			?>
			<hr>
				<center><a href='seeall.php'>See All</a></center>
			</div>
<?php ////////////////////////////////////////////NOTIFICATION END/////////////////////////////////////////////////// ?>
	<div id=rooms>
		<img src = 'Hroom Pic/report.jpg' width = 90% height=100%>
	</div>
	<div><br>
		<hr>
		<b><font size='6'>Room reports</font></b>
		<hr>
		<table>
			<tr>
				<td align='right'><form action='#table'><button type='submit' name='delete' onClick='myfunction(); return false;'>Delete All</button></form></td>
				<td>
					<form method="POST" action='#table'>
						<button type='submit' onClick="viewAll()">View All</button>
					</form>
				</td>
				<td align='right'>
					<form method="POST" action='#table'>
						<button type='submit' name='today'>View Today</button>
					</form>
				</td>
				<td align='center'>
					<form method="POST" action='#table'>
						<button type='submit' name='vby'>View By</button>
						<select name="month">
							<option value="">Month</option>
							<option value="01">January</option>
							<option value="02">February</option>
							<option value="03">March</option>
							<option value="04">April</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">August</option>
							<option value="09">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
						<select name="year">
							<option value="">Year</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
							<option value="2025">2025</option>
							<option value="2026">2026</option>
							<option value="2027">2027</option>
							<option value="2028">2028</option>
							<option value="2029">2029</option>
							<option value="2030">2030</option>
						</select>
					</form>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td align='center'>
					<form id='printForm' method = "POST" Action="print.php">
						<input type='button' value='Print' onClick="printFunc()">
						<input type='date' name='bdate'>
						<label>to</label>
						<input type='date' name='edate'>
					</form>
				</td>
			</tr>
		</table>
		<?php
		function viewAll(){
			include('config.php');
			$result = mysqli_query($conn, "SELECT * FROM transaction");
			echo"<center><span class = footer>";
			echo "<table width='100%' class='roomData' id='table'>";
				echo "<tr bgcolor='black'>";
				echo "<th align='center'>  <font color='#646363' size=5>Report ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Staff_ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Date</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Time</font> </thth>";
				echo "<th align='center'> <font color='#646363' size=5>Checkout Date</font></th>";
				echo "<th align='center'> <font color='#646363' size=5>Checkout Time</font></th>";
				echo "<th align='center'>  <font color='#646363' size=5>Client Name</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Room ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Type</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Cost</font> </th>";
				echo "<th align='center'> <font color='#646363' size=5>Payment</font></th>";
				echo "<th align='center'> <font color='#646363' size=5>Change</font></th>";
				echo "</tr>";
			if(mysqli_num_rows($result) > 0){							
			while($res=mysqli_fetch_array($result))
				{
					$zz = $res['Checkout_Time'];
					echo "<tr>";
					echo "<td align='center'>".$res['Report_ID']."</td>";
					echo "<td align='center'>".$res['Staff_ID']."</td>";
					echo "<td align='center'>".$res['Checkin_Date']."</td>";
					echo "<td align='center'>".$res['Checkin_Time']."</td>";
					echo "<td align='center'>".$res['Checkout_Date']."</td>";
					echo "<td align='center'>".date('h:i:sA',strtotime($zz))."</td>";
					echo "<td align='center'>".$res['Client_Name']."</td>";
					echo "<td align='center'>".$res['Room_ID']."</td>";
					echo "<td align='center'>".$res['Checkin_Type']."</td>";
					echo "<td align='center'>".$res['Cost']."</td>";
					echo "<td align='center'>".$res['Payment']."</td>";
					echo "<td align='center'>".$res['Change']."</td";
					echo "<tr>";
				}
			}
			else{
				echo"<tr><td colspan='13' align='center'>No Data To Display</td></tr>";
			}
			echo "</table></span></center>";
		}
		if(isset($_POST['vby'])){
			$month = $_POST['month'];
			$year = $_POST['year'];
			if($month == ""){
				$result = mysqli_query($conn, "SELECT * FROM transaction WHERE Checkin_Date LIKE '%/$year'");
			}
			else if($year == ""){
				$result = mysqli_query($conn, "SELECT * FROM transaction WHERE Checkin_Date LIKE '$month/%'");
			}
			else{
				$result = mysqli_query($conn, "SELECT * FROM transaction WHERE Checkin_Date LIKE '$month/%' AND Checkin_Date LIKE '%/$year'");
			}
			echo"<center><span class = footer>";
			echo "<table width='100%' class='roomData'>";
				echo "<tr bgcolor='black'>";
				echo "<th align='center'>  <font color='#646363' size=5>Report ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Staff_ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Date</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Time</font> </thth>";
				echo "<th align='center'> <font color='#646363' size=5>Checkout Date</font></th>";
				echo "<th align='center'> <font color='#646363' size=5>Checkout Time</font></th>";
				echo "<th align='center'>  <font color='#646363' size=5>Client Name</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Room ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Type</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Cost</font> </th>";
				echo "<th align='center'> <font color='#646363' size=5>Payment</font></th>";
				echo "<th align='center'> <font color='#646363' size=5>Change</font></th>";
				echo "</tr>";
			if(mysqli_num_rows($result) > 0){							
				while($res=mysqli_fetch_array($result))
				{
					$zz = $res['Checkout_Time'];
					echo "<tr>";
					echo "<td align='center'>".$res['Report_ID']."</td>";
					echo "<td align='center'>".$res['Staff_ID']."</td>";
					echo "<td align='center'>".$res['Checkin_Date']."</td>";
					echo "<td align='center'>".$res['Checkin_Time']."</td>";
					echo "<td align='center'>".$res['Checkout_Date']."</td>";
					echo "<td align='center'>".date('h:i:sA',strtotime($zz))."</td>";
					echo "<td align='center'>".$res['Client_Name']."</td>";
					echo "<td align='center'>".$res['Room_ID']."</td>";
					echo "<td align='center'>".$res['Checkin_Type']."</td>";
					echo "<td align='center'>".$res['Cost']."</td>";
					echo "<td align='center'>".$res['Payment']."</td>";
					echo "<td align='center'>".$res['Change']."</td";
					echo "<tr>";
				}
			}
			else{
				echo"<tr><td colspan='13' align='center'>No Data To Display</td></tr>";
			}
			echo "</table></span></center>";
		}
		else if(isset($_POST['today'])){
			$date = date('m/d/Y');
			$result = mysqli_query($conn, "SELECT * FROM transaction WHERE Checkin_Date LIKE '$date'");
			echo"<center><span class = footer>";
			echo "<table width='100%' class='roomData'>";
				echo "<tr bgcolor='black'>";
				echo "<th align='center'>  <font color='#646363' size=5>Report ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Staff_ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Date</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Time</font> </thth>";
				echo "<th align='center'> <font color='#646363' size=5>Checkout Date</font></th>";
				echo "<th align='center'> <font color='#646363' size=5>Checkout Time</font></th>";
				echo "<th align='center'>  <font color='#646363' size=5>Client Name</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Room ID</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Checkin Type</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Cost</font> </th>";
				echo "<th align='center'> <font color='#646363' size=5>Payment</font></th>";
				echo "<th align='center'> <font color='#646363' size=5>Change</font></th>";
				echo "</tr>";
			if(mysqli_num_rows($result) > 0){						
				while($res=mysqli_fetch_array($result))
				{
					$zz = $res['Checkout_Time'];
					echo "<tr>";
					echo "<td align='center'>".$res['Report_ID']."</td>";
					echo "<td align='center'>".$res['Staff_ID']."</td>";
					echo "<td align='center'>".$res['Checkin_Date']."</td>";
					echo "<td align='center'>".$res['Checkin_Time']."</td>";
					echo "<td align='center'>".$res['Checkout_Date']."</td>";
					echo "<td align='center'>".date('h:i:sA',strtotime($zz))."</td>";
					echo "<td align='center'>".$res['Client_Name']."</td>";
					echo "<td align='center'>".$res['Room_ID']."</td>";
					echo "<td align='center'>".$res['Checkin_Type']."</td>";
					echo "<td align='center'>".$res['Cost']."</td>";
					echo "<td align='center'>".$res['Payment']."</td>";
					echo "<td align='center'>".$res['Change']."</td";
					echo "<tr>";
				}
			}
			else{
				echo"<tr><td colspan='13' align='center'>No Data To Display</td></tr>";
			}
			echo "</table></span></center>";
		}
		else{
			viewAll();
		}
		?>
	</div>
	<br><br>
	<hr>
	<span class = footer>
			<a href='index.php'>Activity Log</a> <font color=blue>l </font>
			<a href='checkin.php'>Check in</a> <font color=blue>l </font>
			<a href='maccount.php'>Manage Account</a> <font color=blue>l </font>
			<a href='logout.php'>Log out</a>
	</span>
	<hr>
</center>
<div class='infoOfReport'>
<?php
	$checking = mysqli_query($conn, 'SELECT rooms.Room_Number,transaction.Checkout_Date,transaction.Checkout_Time FROM transaction,rooms WHERE transaction.Room_ID = rooms.Room_ID AND Notif_Status = 0;');
	while($check = mysqli_fetch_assoc($checking)){
		echo"<span class='reportRoomNumber'>".$check['Room_Number']."</span>&nbsp";
		echo"<span class='dateValue'>".$check['Checkout_Date']."</span>&nbsp";
		echo"<span class='timeValue'>".$check['Checkout_Time']."</span><br>";
	}
?>
</div>
<script>
////////////////////////////////NOTIFICATION JAVASCRIPT BEGIN///////////////////////////////////////////////
var x = "Hroom Pic/notifRoom.png";
var y = "none";
function hideShow(){
	var notifView = document.getElementById('notifPanel');
	if(x == "Hroom Pic/notifRoom.png"){
		document.getElementById('notif1').src='Hroom Pic/notifW.png';
		notifView.style.display = "block";
		x = "Hroom Pic/notifW.png";
		y = "block";
	}
	else{
		document.getElementById('notif1').src='Hroom Pic/notifRoom.png';
		notifView.style.display = "none";
		x = "Hroom Pic/notifRoom.png";
		y = "none";
	}
}
var strageRRN = "";
setInterval(func, 1000);
function func(){
	var reportRN = document.getElementsByClassName("reportRoomNumber");
	var dbdate = document.getElementsByClassName("dateValue");
	var dbtime = document.getElementsByClassName("timeValue");
	var dNow = new Date();
	var date = dNow.getDate();
	var month = dNow.getUTCMonth()+1;
	var year = dNow.getUTCFullYear();
	if(date < 10){
		date = "0"+date;
	}
	if(month < 10){
		month = "0"+month;
	}
	dNow = date+"/"+month+"/"+year;
	var tNow = new Date();
	var t = tNow.getHours();
	var m = tNow.getMinutes();
	var s = tNow.getSeconds();
	if(tNow.getHours() <= 12){
		if(t < 10){
			t = "0"+t;
		}
		if(m < 10){
			m = "0"+m;
		}
		if(s < 10){
			s = "0"+s;
		}
		tNow = t+":"+m+":"+s+"am";
	}
	else{
		if(t >= 12){
			t = t-12;
		}
		if(t < 10){
			t = "0"+t;
		}
		if(m < 10){
			m = "0"+m;
		}
		if(s < 10){
			s = "0"+s;
		}
		tNow = t+":"+m+":"+s+"pm";
	}
	var counter=0;
	var x = 0;
	for (var i = 0; i < dbdate.length; i++) {
		var rrn = reportRN[i].innerText;
		var dDate = dbdate[i].innerText;
		var dTime = dbtime[i].innerText;
		x++;
		var dateAndTimeOfdb = new Date(dDate + " " +dTime)*1;
		var toCompare = new Date()*1;
		if(dateAndTimeOfdb < toCompare){
			counter++;
			strageRRN = strageRRN + "&roomNumber[]="+rrn;
			if(x == dbdate.length){
				location.href="report.php?notif="+counter+strageRRN;
			}
		}
	}
}
</script>

<?php
////////////////PHP pra mag add ung notification sa database//////////////
function createNotif(){
	for($i = 0;$i < count($_GET['roomNumber']);$i++){
		$notifCount = $_GET['notif'];
		$roomNumber = $_GET['roomNumber'][$i];
		$createNotifRoomQuery = mysqli_query($conn, "SELECT * FROM rooms WHERE Room_Number = '$roomNumber'");
		while($resultCreateNotif = mysqli_fetch_assoc($createNotifRoomQuery)){
			$rid = $resultCreateNotif['Room_ID'];
			$des = "Time Out";
			$currentDate = date('m/d/Y');
			$currentTime = date('h:i:sA');
			
			$addNotifQuery = mysqli_query($conn, "INSERT INTO notification (Room_ID,Details,Date,Time) VALUES ('$rid','$des','$currentDate','$currentTime')");
			mysqli_query($conn, "UPDATE transaction SET Notif_Status = 1 WHERE Room_ID = $rid");
		}
	}
	echo"<script>location.href='report.php?#';</script>";
}
if(isset($_GET['roomNumber'])){
	createNotif();
}
////////////////////////////////NOTIFICATION PHP END///////////////////////////////////////////////
?>
<?php
	}
	else
	{
		header('location:login.php');
	}
?>
<script>
function myfunction(){
	swal({
	title: "Are you sure?",
	text: "You will not be able to recover this!",
	type: "warning",
	showCancelButton: true,
	confirmButtonColor: "#DD6B55",
	confirmButtonText: "Yes, delete it!",
	closeOnConfirm: false,
	},
	
		function(isConfirm){  
			if (isConfirm) {
				swal("Deleted!", "Your report has been deleted.", "success");
				redirect();
			}
		}	
	);
}
function redirect(){
	setTimeout(function redirect(){location.href="deleteReport.php"} , 1500);
}

function printFunc(){
	document.getElementById("printForm").submit();
}
</script>
</body>
</html>