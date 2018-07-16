<?php
	include_once('config.php');
	date_default_timezone_set('Asia/Manila');
?>
<html>
<head>
<title>Hotel Room Management System</title>
<link href="Index.css" rel="stylesheet" type="text/css"/>
<link href="popup.css" rel="stylesheet" type="text/css"/>
<script src="sweetalert-master/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
</head>
<body>
<div id = 'headeragain'>
	<div class = kaliwa>
		<center><a href='index.php'>Homepage</a> &nbsp; &nbsp;  <a href='rooms.php'>Rooms</a></center>
	</div>
	
	<div class = kanan>
		<center><a href='report.php'>Report</a> &nbsp; &nbsp; <a href='contactus.php'>Contact Us</a></center>
	</div>
</div>
		<div id = 'content'><br>
<?php ////////////////////////////////////////////NOTIFICATION BEGIN/////////////////////////////////////////////////// ?>
			<div id='notifPic' class='notif' title='Notifications'>
				<img src='Hroom Pic/notif.png' id='notif1' onClick='hideShow()'>
				<span id='notifCount' onClick='hideShow()'>
				<?php
				$notifNumber = mysql_query("SELECT *FROM notification WHERE Status = 0");
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
			$notif_login_error = mysql_query("SELECT * FROM notif_login");
			if(mysql_num_rows($notifLog) > 0){
				while($notif = mysql_fetch_array($notifLog)){
					$uniqID = $notif['Id'];
					$a = $notif['Room_Number'];
					$stats = $notif['Status'];
					if($stats == 0){echo "<center><div class='notifViewdata'><a href='#' id='link' onclick='logninFirst()'><table width='100%'>";}
					else{echo "<center><div class='notifdata'><a href='#' id='link' onclick='logninFirst()'><table width='100%'>";}
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
			
			<span class=greet>SND Hotel Room Management System</span><br>
			<span class = submenu>
				Km. 76 National Highway Brgy. Banca Banca, Victoria, Laguna
			</span>
			<hr width = 52%>
			<img src = 'Hroom Pic/ribon1_login.jpg'><br><br>
	<center>
			<div id=bodycontent><br><br>
				<font face ="Brandon Grotesque" size = "100px"><b>Login Form</b></font>
				<center>
				<?php
					if (isset($_POST['login']))
					{
						$pid = 0;
						$admin = $_POST['admin'];
						$pass = $_POST['pass'];
						$result = mysql_query("SELECT * FROM staff where Username = '$admin' and Password = '$pass'");
						while($res = mysql_fetch_array($result))
						{
							$id = $res['Staff_ID'];
							$pid = $res['Person_ID'];
						}
						$selectingName = mysql_query("SELECT * FROM person WHERE Person_ID = $pid");
						while($resultQuery = mysql_fetch_assoc($selectingName)){
							$fn = $resultQuery['First_Name'];
							$ln = $resultQuery['Last_Name'];
							$fullname = "$fn $ln";
						}
						if(!empty($id))
						{
							session_start();
							$_SESSION['name']=$fullname;
							
							$date = date('m/d/Y');
							$time = date('h:i:sA');	
							$name = $fullname;	
							$act = "Login";
							$loglist = "INSERT INTO login_log (Staff_ID,Date,Time,Activity) VALUES (1,'$date','$time','$act')";
							mysql_query($loglist) or
							die('Query "' . $query . '" failed: ' . mysql_error());
							echo "<script>location.href='index.php';</script>";
						}
						else{
							echo"<font color = red>Incorrect Username or Password!</font>";
						}
					}
				?>
					<form method = "POST">
						<table border="0">
							<tr>
								<td><label name = "admin">Admin</label></td>
								<td><input type="text" name="admin" placeholder = "Please Enter Admin name" size='30px' required></td>
							</tr>
							<tr>
								<td><label name = "admin">Password</label></td>
								<td><input type="password" name="pass" placeholder = "Please Enter Password" size='30px' required></td>
							</tr>
							<tr>
								<td></td>
								<td><button type='submit' name='login' id='login'>Login</button>
					</form>
					<?php
						$result = mysql_query("SELECT * FROM staff");
						if (mysql_num_rows($result) > 0){
						}
						else{
							echo"<button type='submit' id='myBtn'>Register</button></td>";
						}
					?>
							</tr>
						</table><br><br>
				</center>
			</div><br><br>
		</div>
	</center>
</div>

<!-- Popup Menu -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onClick='myFunction()'>&times;</span>
<center>
		<form method = "POST" id="myForm" action="createAccount.php">
			<table border="0" >
				<tr>
					<td><label>First Name</label></td>
					<td><input type="text" id="fn" name="fn" placeholder = "Please Enter First name" required></td>
				</tr>
				<tr>
					<td><label>Last Name</label></td>
					<td><input type="text" id="ln" name="ln" placeholder = "Please Enter Last Name" required></td>
				</tr>
				<tr>
					<td><label>Address</label></td>
					<td><input type="text" id="add" name="address" placeholder = "Please Enter Address" required></td>
				</tr>
				<tr>
					<td><label>Username</label></td>
					<td><input type="text" id="un" name="un" placeholder = "Please Enter Username" required></td>
				</tr>
				<tr>
					<td><label>Password</label></td>
					<td><input type="password" id="pass" name="pass" placeholder = "Please Enter Password" required></td>
				</tr>
				<tr>
					<td></td>
					<td><input type='button' name='register' value = 'Create Now' onClick='create()'></td>
				</tr>
			</table>
		</form>
</center>
</div>

<script>
var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
btn.onclick = function() {
    modal.style.display = "block";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
function myFunction(){
	modal.style.display = "none";
}

function create(){
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
	text: "You can change your account info in the Manage Account menu",
	type: "warning",
	showCancelButton: true,
	confirmButtonColor: "skyblue",
	confirmButtonText: "Yes, create it!",
	closeOnConfirm: false,
	},
		function(isConfirm){  
			if (isConfirm) {
				swal("Success!", "Your account successfully created.", "success");
				redirect();
				modal.style.display = "none";
			}
		}	
	);
	}
}
function redirect(){
	setTimeout(function redirect(){location.href="createAccount.php";
	document.getElementById("myForm").submit();
	} , 1500);
}
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
setInterval(func, 100);
function func(){
	var dbdate = document.getElementsByClassName("dateValue");
	var dbtime = document.getElementsByClassName("timeValue");
	var dNow = new Date();
	dNow = dNow.getDate()+"/0"+(dNow.getUTCMonth()+1)+"/"+dNow.getUTCFullYear();
	var tNow = new Date();
	if(tNow.getHours() == 12){
		if(tNow.getMinutes()<=9 && tNow.getSeconds()<=9){
			tNow = tNow.getHours()+":0"+tNow.getMinutes()+":0"+tNow.getSeconds()+"pm";
		}
		else if(tNow.getSeconds()<=9){
			tNow = tNow.getHours()+":"+tNow.getMinutes()+":0"+tNow.getSeconds()+"pm";
		}
		else if(tNow.getMinutes()<=9){
			tNow = tNow.getHours()+":0"+tNow.getMinutes()+":"+tNow.getSeconds()+"pm";
		}
		else{
			tNow = tNow.getHours()+":"+tNow.getMinutes()+":"+tNow.getSeconds()+"pm";
		}
	}
	else if(tNow.getHours() >= 12){
		if(tNow.getMinutes()<=9 && tNow.getSeconds()<=9){
			tNow = "0"+(tNow.getHours()-12)+":0"+tNow.getMinutes()+":0"+tNow.getSeconds()+"pm";
		}
		else if(tNow.getSeconds()<=9){
			tNow = "0"+(tNow.getHours()-12)+":"+tNow.getMinutes()+":0"+tNow.getSeconds()+"pm";
		}
		else if(tNow.getMinutes()<=9){
			tNow = "0"+(tNow.getHours()-12)+":0"+tNow.getMinutes()+":"+tNow.getSeconds()+"pm";
		}
		else{
			tNow = "0"+(tNow.getHours()-12)+":"+tNow.getMinutes()+":"+tNow.getSeconds()+"pm";
		}
	}
	else{
		if(tNow.getMinutes()<=9 && tNow.getSeconds()<=9){
			tNow = "0"+tNow.getHours()+":0"+tNow.getMinutes()+":0"+tNow.getSeconds()+"am";
		}
		else if(tNow.getSeconds()<=9){
			tNow = "0"+tNow.getHours()+":"+tNow.getMinutes()+":0"+tNow.getSeconds()+"am";
		}
		else if(tNow.getMinutes()<=9){
			tNow = "0"+tNow.getHours()+":0"+tNow.getMinutes()+":"+tNow.getSeconds()+"am";
		}
		else{
			tNow = "0"+tNow.getHours()+":"+tNow.getMinutes()+":"+tNow.getSeconds()+"am";
		}
	}
	var counter=0;
	for (var i = 0; i < dbdate.length; i++) {
		var dDate = dbdate[i].innerText;
		var dTime = dbtime[i].innerText;
		if(dDate == dNow && dTime == tNow){
			counter++;
			document.getElementById('notifCount').innerHTML=counter;
			document.getElementsByClassName("notifdata")[0].style.backgroundColor = "gray";
		}
	}
}
function logninFirst(){
	var notifView = document.getElementById('notifPanel');
	swal("Cannot Proceed Your Request","Please Login First!","warning");
	document.getElementById('notif1').src='Hroom Pic/notif.png';
	notifView.style.display = "none";
}
</script>
</body>
</html>