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
				$number = 0;
				$notifNumber = mysql_query("SELECT * FROM notification WHERE Status = 0");
				if(mysql_num_rows($notifNumber) > 0){
					echo mysql_num_rows($notifNumber);
				}
				else{
					echo $number = "";
				}
				?>
				</span>
			</div>
			
			<div id='notifPanel' class='notifView'>
			<label>Notifications</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='#'>Mark All as Read</a><br>
			<hr>
			<?php
			$notifLog = mysql_query("SELECT notification.Id,notification.Status,rooms.Room_Number,notification.Details,rooms.Room_Type,notification.Date,notification.Time FROM notification,rooms WHERE notification.Room_ID = rooms.Room_ID ORDER BY id DESC LIMIT 5");
			if(mysql_num_rows($notifLog) > 0){
				while($notif = mysql_fetch_array($notifLog)){
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
	<img src = 'Hroom Pic/ribon1_maccount.jpg'>
	<br><br>
	<center>
		<div id=bodycontent><br>
			<?php
				include_once('config.php');
				$data = mysql_query("SELECT staff.Staff_ID,person.First_Name,person.Last_Name,person.Address,staff.Username,staff.Password FROM staff,person WHERE person.Person_ID = staff.Person_ID");
				while($result = mysql_fetch_array($data)){
					$id = $result['Staff_ID'];
					$fn = $result['First_Name'];
					$ln = $result['Last_Name'];
					$add = $result['Address'];
					$un = $result['Username'];
					$pass = $result['Password'];
				}
			?>
			
			<center>
			<font size="6px"><span>Account Information</font><br><br>
				<form id="myForm" method="POST" action="updateAccount.php">
					<table>
						<input type="hidden" name="id" value = "<?php echo $id ?>">
						<tr>
							<td><label>First name</label></td>
							<td><input type="text" id="fn" name="fn" value = "<?php echo $fn ?>" required></td>
						</tr>
						<tr>
							<td><label>Last name</label></td>
							<td><input type="text" id="ln" name="ln" value = "<?php echo $ln ?>" required></td>
						</tr>
						<tr>
							<td><label>Address</label></td>
							<td><input type="text" id="add" name="add" value = "<?php echo $add ?>" required></td>
						</tr>
						<tr>
							<td><label>Username</label></td>
							<td><input type="text" id="un" name="un" value = "<?php echo $un ?>" required></td>
						</tr>
						<tr>
							<td><label>Password</label></td>
							<td><input type="password" id="pass" name="pass" value = "<?php echo $pass ?>" required></td>
						</tr>
						<tr>
							<td></td>
							<td><input type='button' value = 'Update Now' onClick='update()'></td>
						</tr>
					</table>
				</form>
			</center><br>
		</div><br>
	</center>
</center>
<div class='infoOfReport'>
<?php
	$checking = mysql_query('SELECT rooms.Room_Number,transaction.Checkout_Date,transaction.Checkout_Time FROM transaction,rooms WHERE transaction.Room_ID = rooms.Room_ID AND Notif_Status = 0;');
	while($check = mysql_fetch_assoc($checking)){
		echo"<span class='reportRoomNumber'>".$check['Room_Number']."</span>&nbsp";
		echo"<span class='dateValue'>".$check['Checkout_Date']."</span>&nbsp";
		echo"<span class='timeValue'>".$check['Checkout_Time']."</span><br>";
	}
?>
</div>
<script>
function update(){
	var fname = document.getElementById("fn").value;
	var lname = document.getElementById("ln").value;
	var add = document.getElementById("add").value;
	var uname = document.getElementById("un").value;
	var password = document.getElementById("pass").value;
	
	if(fname == ""){
		swal("EMPTY!", "First Name field cannot be empty!", "warning")
	}
	else if(lname == ""){
		swal("EMPTY!", "Last Name field cannot be empty!", "warning")
	}
	else if(add == ""){
		swal("EMPTY!", "Address field cannot be empty!", "warning")
	}
	else if(uname == ""){
		swal("EMPTY!", "Username field cannot be empty!", "warning")
	}
	else if(password == ""){
		swal("EMPTY!", "Password field cannot be empty!", "warning")
	}
	else{
		swal({
		title: "Are you sure?",
		text: "You can change your information anytime",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "green",
		confirmButtonText: "Yes, update it!",
		closeOnConfirm: false,
		},
			function(isConfirm){  
				if (isConfirm) {
					swal("Success!", "Your account successfully updated.", "success");
					redirect();
				}
			}
		);
	}
}
function redirect(){
	setTimeout(function redirect(){
		location.href="updateAccount.php";
		document.getElementById("myForm").submit();
	} , 1500);
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
	dNow = month+"/"+date+"/"+year;
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
				location.href="index.php?notif="+counter+strageRRN;
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
		$createNotifRoomQuery = mysql_query("SELECT * FROM rooms WHERE Room_Number = '$roomNumber'");
		while($resultCreateNotif = mysql_fetch_assoc($createNotifRoomQuery)){
			$rid = $resultCreateNotif['Room_ID'];
			$des = "Time Out";
			$currentDate = date('m/d/Y');
			$currentTime = date('h:i:sA');
			
			$addNotifQuery = mysql_query("INSERT INTO notification (Staff_ID,Room_ID,Details,Date,Time) VALUES (1,'$rid','$des','$currentDate','$currentTime')");
		}
	}
	mysql_query("UPDATE transaction SET Notif_Status = 1");
	echo"<script>location.href='maccount.php?#';</script>";
}
if(isset($_GET['roomNumber'])){
	createNotif();
}
////////////////////////////////NOTIFICATION PHP END///////////////////////////////////////////////
?>
<?php
	}
	else{
		header('login.php');
	}
?>
</body>
</html>