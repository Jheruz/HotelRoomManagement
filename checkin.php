<html>
<head>
<title>Hotel Room Management System</title>
<link href="Index.css" rel="stylesheet" type="text/css"/>
<link href="popup.css" rel="stylesheet" type="text/css"/>
<script src="sweetalert-master/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
</head>
<body>
<?php
	session_start();
	if (isset($_SESSION['name']))
	{
		include_once('config.php');
		date_default_timezone_set('Asia/Manila');
?>
<div id = 'headeragain'>
	<div class = kaliwa>
		<center><a href='index.php'>Homepage</a> &nbsp; &nbsp;  <a href='rooms.php'>Rooms</a></center>
	</div>
	
	<div class = kanan>
		<center><a href='report.php'>Report</a> &nbsp; &nbsp; <a href='contactus.php'>Contact Us</a></center>
	</div>
</div>
<center>
<div id = 'content'>
	<br>
<?php ////////////////////////////////////////////NOTIFICATION BEGIN/////////////////////////////////////////////////// ?>
			<div id='notifPic' class='notif' title='Notifications'>
				<img src='Hroom Pic/notif.png' id='notif1' onClick='hideShow()'>
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
				echo"<script>location.href='checkin.php';</script>";
			}
			?>
			<hr>
				<center><a href='#'>See All</a></center>
			</div>
<?php ////////////////////////////////////////////NOTIFICATION END/////////////////////////////////////////////////// ?>
<?php
	echo"<span class=greet>Welcome ";
	echo $_SESSION['name'];
	echo "</span>";
?>
	<br>
		<span class = submenu>
			<a href='index.php'>Activity Log</a> <font color=black>l </font>
			<a href='checkin.php'>Check in</a> <font color=black>l </font>
			<a href='maccount.php'>Manage Account</a> <font color=black>l </font>
			<a href='logout.php'>Log out</a>
		</span>
	<hr width = 52%>
	<img src = 'Hroom Pic/ribon1_check.jpg'>
	<br><br>
	<center>
		<div id=bodycontent><br>
			<b><label><font size='5px'>Please Specify the Room that the client want to check in</font></label></b>
			<center>
				<form id='checkingIn' method = "POST" action="checkinReview.php#person">
					<table border="0" >
						<tr>
							<td><label id='rnum'>Room Number</label></td>
							<td>
							<select name="rooms">
								<?php
								$roomid = 0;
								$count = 0;
								$result = mysqli_query($conn, "SELECT * FROM Rooms");
								while($res=mysqli_fetch_array($result)){
									$roomId = $res['Room_ID'];
									$roomNumber = $res['Room_Number'];
									$roomType = $res['Room_Type'];
									$c3hr = $res['Cost_per_3hr'];
									$c12hr = $res['Cost_per_12hr'];
									$c24hr = $res['Cost_per_24hr'];
									$status = $res['Status'];
									if(!($status == "OCCUPIED")){
										$count = $count + 1;
										echo "<option value='$roomNumber'>Room#: $roomNumber &nbsp; &nbsp; Room Type: $roomType</option>";
									}
								}
								if($count == 0){
									echo "<option id='nr' value='noRoomAvailable'>All Rooms is Occupied No Rooms Available!</option>";
								}
								else{
									echo "<input type='hidden' id='nr' value='available'>";
								}
								?>
							</select>
							</td>
						</tr>
						<tr>
							<td><label>Client Name(Optional)</label></td>
							<td><input type="text" id='asdasd' name="cname" placeholder = "Enter Name"></td>
						</tr>
						<tr>
							<td><label>Check in Date</label></td>
							<td><label id='indate'><?php $date = date('m/d/Y'); echo $date; echo "<input type='hidden' name='indate' value='$date'>";?></label></td>
						</tr>
						<tr>
							<td><label>Check in Time</label></td>
							<td><label id='timeNow'></label><input type='hidden' id='intime' name='intime'></td>
						</tr>
						<tr>
							<td><label>Check out By</label></td>
							<td>
								<input type="radio" name="checkoutHrs" value = '3hrs' checked="checked">3 Hours
								<input type="radio" name="checkoutHrs" value='12hrs'>12 Hours<br>
								<input type="radio" name="checkoutHrs" value='' id='hDays'><input type="number" id="specify" onChange='days()'>Days
								<script>
								function days(){
									document.getElementById("hDays").value = document.getElementById("specify").value;
									if(!document.getElementById("hDays").checked.ischecked){
										document.getElementById("hDays").checked = true;
									}
								}
								</script>
							</td>
						</tr>
						<tr>
							<td><label>Checkin Type</label></td>
							<td><input type="radio" name="ctype" value = 'Family'checked="checked">Family<input type="radio" name="ctype" value='Couple'>Couple<input type="radio" name="ctype" value='Conference'>Conference</td>
						</tr>
						<tr>
							<td><label>Max person Allow</label></td>
							<td><input type="radio" name="max" value = '8' checked="checked">8 Person<input type="radio" name="max" value='12'>12 Person</td>
						</tr>
						<tr>
							<td></td>
							<td><input type='button' onClick='checkinFunction()' value='Proceed'></td>
						</tr>
					</table>
				</form>
			</center>
		<br><br></div>
	</center>
	<br>
<script>
function checkinFunction(){
	var checkinTest = document.getElementById("nr").value;
	if(checkinTest == 'noRoomAvailable'){
		swal("No Rooms Available!","All Rooms is already Occupied!","warning");
	}
	else{
		document.getElementById("checkingIn").submit();
	}	
}
////////////////////////////////NOTIFICATION JAVASCRIPT BEGIN///////////////////////////////////////////////
var x = "Hroom Pic/notif.png";
var y = "none";
function hideShow(){
	var notifView = document.getElementById('notifPanel');
	if(x == "Hroom Pic/notif.png"){
		document.getElementById('notif1').src='Hroom Pic/notifW.png';
		notifView.style.display = "block";
		x = "Hroom Pic/notifW.png";
		y = "block";
	}
	else{
		document.getElementById('notif1').src='Hroom Pic/notif.png';
		notifView.style.display = "none";
		x = "Hroom Pic/notif.png";
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
		if(dNow == dDate && tNow == dTime){
			counter++;
			strageRRN = strageRRN + "&roomNumber[]="+rrn;
			if(x == dbdate.length){
				location.href="index.php?notif="+counter+strageRRN;
			}
		}
	}
	document.getElementById("intime").value = tNow;
	document.getElementById("timeNow").innerText = tNow;
}
</script>

</center>
<?php
	}
	else
	{
		header('location:login.php');
	}
?>
</center>
</div>
</body>
</html>