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
		include('config.php');
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
				echo"<script>location.href='index.php';</script>";
			}
			?>
			<hr>
				<center><a href='seeall.php'>See All</a></center>
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
	<img src = 'Hroom Pic/ribon1_act.jpg'>
	<br><br>
	<center>
		<div id=bodycontent><br><br>
		<?php
			$result = mysqli_query($conn, "SELECT * FROM login_log");
			while($res = mysqli_fetch_array($result))
				{
					$id = $res['log_ID'];
					$date = $res['Date'];
					$time= $res['Time'];
					$act = $res['Activity'];
				}
			
			echo "<center><table width='95%'>";
			echo "<tr>";
				echo "<td><span id=nameNdate><b>Name: </b>"; echo $_SESSION['name'];
				echo"<br><b>Current Date and Time:</b> <span id='displaytime&date'></span>";
				echo"</span>";
				echo"</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td align='right'><button type='submit' name='delete' onClick='myfunction()'>Delete All</button></td>";
			echo "</tr>";
			echo "</table><br>";
			
		$countRemaining = 0;
		$currentNumber = 0;
		function displayActLog(){
			include('config.php');
			$result = mysqli_query($conn, "SELECT * FROM login_log ORDER BY log_ID DESC LIMIT 20");	
			echo "<table width='95%' id='table'>";
				echo "<tr bgcolor='Black'>";
				echo "<th align='center'>  <font color='#646363' size=5>Date</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Time</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Activity</font> </th>";
				echo "<th align='center' width='12%'> <font color='#646363' size=5>Action</font></th>";
				echo "</tr>";
				
			global $countRemaining;
			global $currentNumber;
			while($res=mysqli_fetch_array($result)){
				$countRemaining = $countRemaining + 1;
				$currentNumber = $currentNumber + 1;
				echo "<tr>";
				echo "<td align='center'>".$res['Date']."</td>";
				echo "<td align='center'>".$res['Time']."</td>";
				echo "<td align='center' name=a width='50%'>".$res['Activity']."</td>";
				echo "<td align='center'><button onClick='deleteIndividual($res[log_ID])'>Delete</button></td>";
			}
		}

		function nextActLog($Next){
			include('config.php');
			$result = mysqli_query($conn, "SELECT * FROM login_log ORDER BY log_ID DESC LIMIT 20 OFFSET $Next");
			echo "<table width='95%' id='table'>";
				echo "<tr bgcolor='Black'>";
				echo "<th align='center'>  <font color='#646363' size=5>Date</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Time</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Activity</font> </th>";
				echo "<th align='center' width='12%'> <font color='#646363' size=5>Action</font></th>";
				echo "</tr>";
				
			global $countRemaining;
			global $currentNumber;
			$currentNumber = 0 + $Next;
			while($res=mysqli_fetch_array($result)){
				$countRemaining = $countRemaining + 1;
				$currentNumber = $currentNumber + 1;
				echo "<tr>";
				echo "<td align='center'>".$res['Date']."</td>";
				echo "<td align='center'>".$res['Time']."</td>";
				echo "<td align='center' name=a width='50%'>".$res['Activity']."</td>";
				echo "<td align='center'><button onClick='deleteIndividual($res[log_ID])'>Delete</button></td>";
			}
		}
		function prevActLog($Prev){
			include('config.php');
			$result = mysqli_query($conn, "SELECT * FROM login_log ORDER BY log_ID DESC LIMIT 20 OFFSET $Prev");	
			echo "<table width='95%' id='table'>";
				echo "<tr bgcolor='Black'>";
				echo "<th align='center'>  <font color='#646363' size=5>Date</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Time</font> </th>";
				echo "<th align='center'>  <font color='#646363' size=5>Activity</font> </th>";
				echo "<th align='center' width='12%'> <font color='#646363' size=5>Action</font></th>";
				echo "</tr>";
				
			global $countRemaining;
			global $currentNumber;
			$currentNumber = 0 + $Prev;
			while($res=mysqli_fetch_array($result)){
				$countRemaining = $countRemaining + 1;
				$currentNumber = $currentNumber + 1;
				echo "<tr>";
				echo "<td align='center'>".$res['Date']."</td>";
				echo "<td align='center'>".$res['Time']."</td>";
				echo "<td align='center' name=a width='50%'>".$res['Activity']."</td>";
				echo "<td align='center'><button onClick='deleteIndividual($res[log_ID])'>Delete</button></td>";
			}
		}
		$pageNumber = 0;
		if(isset($_GET['next'])){
			$nextData = $_GET['next']+20;
			$pageNumber = $nextData;
			$currentNumber = $currentNumber + 20;
			$countRemaining = $countRemaining + 20;
			nextActLog($nextData);
		}
		else if(isset($_GET['prev'])){
			if($_GET['prev'] > 20){
				$prevData = $_GET['prev'] - 20;
				$pageNumber = $prevData;
				$countRemaining = $countRemaining - 20;
				prevActLog($prevData);
			}
			else{
				displayActLog();
			}
		}
		else{
			displayActLog();
		}
		$numberOfAllData = mysqli_query($conn, "SELECT * FROM login_log");
		$dnoad = 0;
		while($displayNumberOfAllData = mysqli_fetch_assoc($numberOfAllData)){
			$dnoad = $dnoad + 1;
		}
		$query = mysqli_query($conn, "SELECT * FROM login_log");
		$numData = mysqli_num_rows($query);
			echo"<tr>";
				if($pageNumber>=20){
					echo"<td><a href='?prev=$pageNumber#table'><button>Prev</button></a></td>";
				}
				else{echo"<td><button disabled>Prev</button></td>";}
				echo"<td></td>";
				echo"<td align='right'>Displaying <b>$currentNumber</b> of <b>$dnoad</b> Data of Activity Log</td>";
				if($currentNumber != $dnoad){
					echo"<td align='right'><a href='?next=$pageNumber#table'><button>Next</button></a></td>";
				}
				else{
					echo"<td align='right'><button disabled>Next</button></td>";
				}
			echo"</tr>";
		?>
			
			</table></font></center>
		</div>
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
	</center>
	<br>
</center>
<?php
	}
	else
	{
		header('location:login.php');
	}
?>
</div>
</center>
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
				swal("Deleted!", "Your Activity log has been Completely deleted.", "success");
				redirect();
			}
		}	
	);
}
function redirect(){
	setTimeout(function redirect(){location.href="deleteActivity.php"} , 1000);
}

function deleteIndividual(id){
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
				swal("Deleted!", "Your Activity log has been deleted.", "success");
				delIndi(id);
			}
		}	
	);
}
function delIndi(aid){
	setTimeout(function redirect1(){location.href="deleteAct1v1.php?id="+aid} , 1000);
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
			if(x == counter){
				location.href="index.php?notif="+counter+strageRRN;
			}
		}
	}
	document.getElementById("displaytime&date").innerHTML = dNow+" "+tNow;
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
	echo"<script>location.href='index.php?#';</script>";
}
if(isset($_GET['roomNumber'])){
	createNotif();
}
////////////////////////////////NOTIFICATION PHP END///////////////////////////////////////////////
?>
</body>
</html>
