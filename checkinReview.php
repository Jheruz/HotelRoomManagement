<?php
if(isset($_POST['cname']))
{
	include_once('config.php');
	date_default_timezone_set('Asia/Manila');
?>
<html>
<head>
<script src="jquery-3.1.1.min.js" type="text/javascript"></script>
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
		$name1 = $_POST['cname'];
		$indate1 = $_POST['indate'];
		$rnum1 = $_POST['rooms'];
		$ctype1 = $_POST['ctype'];
		$max1 = $_POST['max'];
		
		$checkOutHours = $_POST['checkoutHrs'];
		
		$query = mysqli_query($conn, "SELECT * FROM rooms WHERE Room_Number LIKE '$rnum1'");
		while($roomCost = mysqli_fetch_assoc($query)){
			$id = $roomCost['Room_ID'];
			$c3 = $roomCost['Cost_per_3hr'];
			$c12 = $roomCost['Cost_per_12hr'];
			$c24 = $roomCost['Cost_per_24hr'];
			
			if($checkOutHours == "3hrs"){
				$price = $roomCost['Cost_per_3hr'];
				
				$dateClient = date('d-m-Y h:i:sA');
				
				$date=date_create("$dateClient");
				date_add($date,date_interval_create_from_date_string("3 Hours"));
				
				$totalDay = date_format($date,"d-m-Y");
				$totalTime = date_format($date,"h:i:sA");
			}
			else if($checkOutHours == "12hrs"){
				$price = $roomCost['Cost_per_12hr'];
				
				$dateClient = date('d-m-Y h:i:sA');
				
				$date=date_create("$dateClient");
				date_add($date,date_interval_create_from_date_string("12 Hours"));
				
				$totalDay = date_format($date,"d-m-Y");
				$totalTime = date_format($date,"h:i:sA");
			}
			else{
				$price = $roomCost['Cost_per_24hr'] * $checkOutHours;
				
				
				$dateClient = date('d-m-Y h:i:sA');
				
				$date=date_create("$dateClient");
				date_add($date,date_interval_create_from_date_string("$checkOutHours Days"));
				
				$totalDay = date_format($date,"d-m-Y");
				$totalTime = date_format($date,"h:i:sA");
			}
		}
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
				echo"<script>location.href='checkinReview.php';</script>";
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
			<a href='repoprt.php'>Report</a> <font color=black>l </font>
			<a href='logout.php'>Log out</a>
		</span>
	<hr width = 52%>
	<img src = 'Hroom Pic/ribon1_review.jpg'>
	<br><br>
	<center>
		<div id=bodycontent><br>
			<b><label><font size='5px'>Please Check if the information is correct before proceeding</font></label><br>
			<center>
				<form id="myForm" method="POST" action='Confirmation_checkin.php' onkeypress="return event.keyCode != 13;">
					<table border="0" >
						<tr>
							<td><label>Room Number</label></td>
							<td><label><?php echo $rnum1;?></label></td>
							<td><input type='Hidden' value="<?php echo $rnum1;?>" name="rnum"><td/>
							<td><input type='Hidden' value="<?php echo $id;?>" name="rid"><td/>
						</tr>
						<tr>
							<td><label>Client Name</label></td>
							<td><label><?php echo $name1;?></label></td>
							<td><input type='Hidden' value="<?php echo $name1;?>" name="cname"><td/>
						</tr>
						<tr>
							<td><label>Check in Date</label></td>
							<td><label><?php echo $indate1; echo "<input type='hidden' name='indate' value='$indate1'>"; ?></label></td>
						</tr>
						<tr>
							<td><label>Check in Time</label></td>
							<td><label id='timeNow'></label><input type='hidden' id='intime' name='intime'></td>
						</tr>
						<tr>
							<td><label>Check out Date</label></td>
							<td><label><?php echo $totalDay; echo "<input type='hidden' name='outdate' value='$totalDay'>"; ?></label></td>
						</tr>
						<tr>
							<td><label>Check out Time</label></td>
							<td><label><?php echo $totalTime; echo "<input type='hidden' name='outtime' value='$totalTime'>"; ?></label></td>
						</tr>
						<tr>
							<td><label>Room Type</label></td>
							<td><label><?php
							$result = mysqli_query($conn, "SELECT * FROM rooms Where Room_Number LIKE '$rnum1'");
							while($res = mysqli_fetch_array($result)){
								$rt = $res['Room_Type'];
							}
							echo $rt;?></label></td>
							<td><input type='Hidden' name="rtype" value="<?php echo $rt;?>" name="rtype"><td/>
						</tr>
						<tr>
							<td><label>Checkin Type</label></td>
							<td><label><?php echo $ctype1;?></label></td>
							<td><input type='Hidden' value="<?php echo $ctype1;?>" name="ctype"><td/>
						</tr>
						<tr>
							<td><label>Person Allow</label></td>
							<td><label><?php echo $max1;?> person per room</label></td>
							<td><input type='Hidden' value="<?php echo $max1;?>" name="max"><td/>
						</tr>
						<tr>
							<td><label>Cost</label></td>
							<td><label id='costD'>Php.<?php echo $price;?></label></td>
							<td><input type='Hidden' id='cost' name="cost" value="<?php echo $price;?>"><td/>
						</tr>
						<tr>
							<td><label>Payment</label></td>
							<td><input type='number' id="payment" name='pay' placeholder='Please Enter Payment' ></td>
						</tr>
						<tr>
							<td><label>Change</label></td>
							<td><label id="change" name="change"></label></td>
						</tr>
						<script>
							$(document).ready(function() {
							$("#payment").keyup(validatePayment);
							});
							  function validatePayment() {
								var val1 = parseInt($("#cost").val());
								var val2 = parseInt($("#payment").val());
								if(val2 >= val1) {
									var result = val2 - val1;
									$("#change").html("Php."+result);
								}
								else { 
									$("#change").html("");
								}
							  }
						</script>
						<tr>
							<td></td>
							<td><input type='button' name='yes' value='Checkin' onClick="create()"></td>
						</tr>
					</table>
				</form>
			</center>
		<br><br></div>
	</center>
	<br>
</center>
</center>

<script>
function create(){
	var costRoom = document.getElementById("costD").innerText;
	var paymentUser = document.getElementById("payment").value;
	var changeUser = document.getElementById("change").innerText;
	if(paymentUser == ""){
		swal("Empty!", "Please Enter Cost Before Porceeding.", "warning");
	}
	else if(changeUser == ""){
		swal("Cannot Proceed!", "Payment Should Higher Than Cost of this Room.", "warning");
	}
	else{
		swal({
		title: "Are you sure?",
		text: "You cant change anything you input if you checkin",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "skyblue",
		confirmButtonText: "Yes, checkin!",
		closeOnConfirm: false,
		},
			function(isConfirm){  
				if (isConfirm) {
					swal("Success!", "Your Client information successfully Checkin.", "success");
					redirect();
				}
			}	
		);
	}
}
function redirect(){
	setTimeout(function redirect(){location.href="Confirmation_checkin.php";
	document.getElementById("myForm").submit();
	} , 1500);
}
</script>
<script>
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
		if(t => 12){
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
		if(dDate == dNow && dTime == tNow){
			counter++;
			strageRRN = strageRRN + "&roomNumber[]="+rrn;
			if(x == dbdate.length){
				location.href="checkin.php?notif="+counter+strageRRN;
			}
		}
	}
	document.getElementById("timeNow").innerText = tNow;
	document.getElementById("intime").value = tNow;
}
</script>
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
<?php
}
else
{
	header('location:checkin.php');
}
?>