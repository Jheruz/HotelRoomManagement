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
		include_once('config.php');
		if(isset($_GET['notifID'])){
			$changeStats = $_GET['notifID'];
			$updateNotif = mysqli_query($conn, "UPDATE notification set Status = 1 WHERE Id = $changeStats");
		}
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
				echo"<script>location.href='rooms.php';</script>";
			}
			?>
			<hr>
				<center><a href='seeall.php'>See All</a></center>
			</div>
<?php ////////////////////////////////////////////NOTIFICATION END/////////////////////////////////////////////////// ?>
	<div id=rooms>
		<img src = 'Hroom Pic\contactus.jpg' width = 100% height=100%>
	</div>
	
	<br>
		<hr>
		<b><font size='5'>Contact Information</font></b>
		<hr>
		<table>
			<tr>
				<td width='30%'><font size='5'>Jerome B. Dela Cruz</font></td>
				<td></td>
			</tr>
			
			<tr>
				<td rowspan='2' align='right'><img src='Hroom Pic\email.jpg' width='50%' height='10%'></td>
				<td><b><font size='5'>Contact Number:&nbsp;</b>09097453925</font></td>
			</tr>
			
			<tr>
				<td><b><font size='5'>Email Address:&nbsp;</b>mrsuplado02@gmail.com</font></td>
			</tr>
		
			<tr>
				<td><font size='5'>Hannasheen Rikka Soridor</font></td>
				<td></td>
			</tr>
			
			<tr>
				<td rowspan='2' align='right'><img src='Hroom Pic\email.jpg' width='50%' height='10%'></td>
				<td><b><font size='5'>Contact Number:&nbsp;</b>09097453925</font></td>
			</tr>
			
			<tr>
				<td><b><font size='5'>Email Address:&nbsp;</b>hanna091825@gmail.com</font></td>
			</tr>
			
			<tr>
				<td><font size='5'>Joshua Virina</font></td>
				<td></td>
			</tr>
			
			<tr>
				<td rowspan='2' align='right'><img src='Hroom Pic\email.jpg' width='50%' height='10%'></td>
				<td><b><font size='5'>Contact Number:&nbsp;</b>09262597428</font></td>
			</tr>
			
			<tr>
				<td><b><font size='5'>Email Address:&nbsp;</b>Virinajoshua_123@yahoo.com</font></td>
			</tr>
		</table>
</center>
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
				location.href="contactus.php?notif="+counter+strageRRN;
			}
		}
	};
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
	echo"<script>location.href='contactus.php?#';</script>";
}
if(isset($_GET['roomNumber'])){
	createNotif();
}
////////////////////////////////NOTIFICATION PHP END///////////////////////////////////////////////
?>
<?php
	}
	else{
		header("location:login.php");
	}
?>
</body>
</html>