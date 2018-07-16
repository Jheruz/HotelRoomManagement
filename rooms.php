<html>
<head>
<script src="jquery-3.1.1.min.js" type="text/javascript"></script>
<title>Hotel Room Management System</title>
<link href="Index.css" rel="stylesheet" type="text/css"/>
<link href="popup.css" rel="stylesheet" type="text/css"/>
<script src="sweetalert-master/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
<style type='text/css'>
.newnotif td{
	border: 2px solid red;
}
</style>
</head>
<body bgcolor=#e9e9e9>
<?php
	session_start();
	if (isset($_SESSION['name']))
	{
		include('config.php');
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
		<img src = 'Hroom Pic/rooms.jpg' width = 90% height=100%>
	</div>
	
	<br>
		<hr>
		<b><font size='6'>Room List</font></b>
		<hr>
		<center><span class = footer>
			<table width='90%' id='table'>
				<tr>
					<caption colspan="8">
						<center>
							<label>
								<font size="5px">
									Please Click The leave button if the client leave the hotel to make the room status <font color="green">AVAILABLE</font> if status is <font color="red">OCCUPIED</font>
								</font>
							</label>
						</center>
					</caption>
				</tr>
				<tr>
					<form method="POST" Action='#table'>
						<td colspan='2'>
							<button type='submit' name='filter'>Filter</button>
							<select name="status">
								<option>Filter By</option>
								<option value='AVAILABLE'>AVAILABLE</option>
								<option value='OCCUPIED'>OCCUPIED</option>
							</select>
						</td>
						<td colspan="6" align='right'>
							<a href='checkin.php'><input type='button' value='Checkin'></a>
							<input type='button' id=myBtn name='addroom' value='Add Room'>
							<a href='rooms.php#table'><button>View All</button></a>
							<button type='submit' name='searchNow'>Search</button>
							<input type='search' name='searchValue' placeholder='Search Anything here'>
						</td>
					</form>
				</tr>
				<tr bgcolor='black'>
					<th align='center' width='7%'>  <font color='#646363' size='5'>Room ID</font> </th>
					<th align='center' width='15%'>  <font color='#646363' size=5>Room Name</font> </th>
					<th align='center' width='15%'>  <font color='#646363' size=5>Room Type</font> </th>
					<th align='center' width='11%'>  <font color='#646363' size=5>Cost per 3hrs</font> </th>
					<th align='center' width='11%'>  <font color='#646363' size=5>Cost per 12hrs</font> </th>
					<th align='center' width='11%'>  <font color='#646363' size=5>Cost per 24hrs</font> </th>
					<th align='center' width='10%'>  <font color='#646363' size=5>Status</font> </th>
					<th align='center' width='15%'> <font color='#646363' size=5>Option</font></th>
				</tr>
		<?php
		function displayAllRoom(){
			include('config.php');
			$result = mysqli_query($conn, "SELECT * FROM Rooms LIMIT 10");
			if(mysqli_num_rows($result) > 0){
				while($res=mysqli_fetch_array($result))
					{
						if(isset($_GET['notifID']) && $_GET['rn'] == $res['Room_Number']){
							echo "<tr class='newnotif' id='$res[Room_Number]'>";
						}
						else{
							echo "<tr id='$res[Room_Number]'>";
						}
						echo "<td align='center'>".$res['Room_ID']."</td>";
						echo "<td align='center'>".$number = $res['Room_Number']."</td>";
						echo "<td align='center'>".$res['Room_Type']."</td>";
						echo "<td align='center'>".$res['Cost_per_3hr']."</td>";
						echo "<td align='center'>".$res['Cost_per_12hr']."</td>";
						echo "<td align='center'>".$res['Cost_per_24hr']."</td>";
						$color = $res['Status'];
						if($color == 'AVAILABLE'){
							echo "<td align='center' bgcolor='green'>".$res['Status']."</td>";
						}
						else{
							echo "<td align='center' bgcolor='red'>".$res['Status']."<br><button onClick='leave($res[Room_ID])'>LEAVE</button></td>";
						}
						echo "<td align='center'><a href='rooms.php?id=$res[Room_ID]#table'><button onClick='func($res[Room_ID])'>Edit</button></a> <button onClick='popUpDelete($res[Room_ID])'>Delete</button></td>";
					}
			}
			else{
				echo"<tr><td colspan='8' align='center'>No Data To Display</td></tr>";
			}
		}
		function searchResult(){
			include('config.php');
			$value = $_POST['searchValue'];
			if($value == ""){
				echo"<tr>
				<td colspan='8' align='center'>Please Enter Something on Searchbox to Search</td>
				</tr>";
			}
			else{
				$result = mysqli_query($conn, "SELECT * FROM rooms WHERE Room_Number LIKE '$value%' or Room_Type LIKE '$value%' or Status LIKE '$value%' LIMIT 10");
				if(mysqli_num_rows($result) > 0){
					while($res=mysqli_fetch_array($result))
						{
							
							echo "<tr>";
							echo "<td align='center'>".$res['Room_ID']."</td>";
							echo "<td align='center'>".$number = $res['Room_Number']."</td>";
							echo "<td align='center'>".$res['Room_Type']."</td>";
							echo "<td align='center'>".$res['Cost_per_3hr']."</td>";
							echo "<td align='center'>".$res['Cost_per_12hr']."</td>";
							echo "<td align='center'>".$res['Cost_per_24hr']."</td>";
							$color = $res['Status'];
							if($color == 'AVAILABLE'){
								echo "<td align='center' bgcolor='green'>".$res['Status']."</td>";
							}
							else{
								echo "<td align='center' bgcolor='red'>".$res['Status']."<br><button onClick='leave($res[Room_ID])'>LEAVE</button></td>";
							}
							echo "<td align='center'><a href='rooms.php?id=$res[Room_ID]#table'><button onClick='func($res[Room_ID])'>Edit</button></a> <button onClick='popUpDelete($res[Room_ID])'>Delete</button></td>";
						}
				}
				else{
					echo"<tr><td colspan='8' align='center'>No Result Found</td></tr>";
				}
			}
		}
		if(isset($_POST['searchNow'])){
			searchResult();
		}
		else if(isset($_POST['filter'])){
			$availOroccu = $_POST['status'];
			$roomsQuery = mysqli_query($conn, "SELECT * FROM rooms WHERE Status = '$availOroccu'");
			if(mysqli_num_rows($roomsQuery) > 0){
				while($roomRes = mysqli_fetch_assoc($roomsQuery)){
					echo "<tr>";
						echo "<td align='center'>".$roomRes['Room_ID']."</td>";
						echo "<td align='center'>".$number = $roomRes['Room_Number']."</td>";
						echo "<td align='center'>".$roomRes['Room_Type']."</td>";
						echo "<td align='center'>".$roomRes['Cost_per_3hr']."</td>";
						echo "<td align='center'>".$roomRes['Cost_per_12hr']."</td>";
						echo "<td align='center'>".$roomRes['Cost_per_24hr']."</td>";
						$color = $roomRes['Status'];
						if($color == 'AVAILABLE'){
							echo "<td align='center' bgcolor='green'>".$roomRes['Status']."</td>";
						}
						else{
							echo "<td align='center' bgcolor='red'>".$roomRes['Status']."<br><button onClick='leave($roomRes[Room_ID])'>LEAVE</button></td>";
						}
						echo "<td align='center'><a href='rooms.php?id=$roomRes[Room_ID]#table'><button onClick='func($roomRes[Room_ID])'>Edit</button></a> <button onClick='popUpDelete($roomRes[Room_ID])'>Delete</button></td>";
				}
			}
			else{
				if($availOroccu == "AVAILABLE"){
					echo "<tr>
					<td colspan='8'><center>No Rooms Available</center></td>
					</tr>";
				}
				else{
					echo "<tr>
					<td colspan='8'><center>All rooms is available</center></td>
					</tr>";
				}
			}
		}
		else{
			displayAllRoom();
		}
			echo"</tr>";
			echo "</table></span></center>";
		?>
	
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
				location.href="rooms.php?notif="+counter+strageRRN;
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
	echo"<script>location.href='rooms.php?#';</script>";
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
</body>
</html>

<?php ///////////////////////////////////////////////////////////POP UP MODAL TO CREATE ROOM////////////////////////////////////////////////////////////////// ?>
<html>
<head><title></title></head>
<body>
<!-- Popup Menu -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onClick='myFunction()'>&times;</span>
<center>
		<form id="myRoom" method = "POST" action="Confirmation_RoomAdded.php">
			<label>Please Enter The information needed to Add Room</label> <br>
			<label id="note">
			<font color='red' size='2px'>Note: You must fill all fields to display the Add Room Button</font><br>
			<span id='validationDisplay' class='hideThis'></span>
			<?php
				$displayRN=mysqli_query($conn, "SELECT * FROM rooms");
				while($RNs=mysqli_fetch_assoc($displayRN)){
					echo "<span id='hideThis' class='RoomNumbers'>".$RNs['Room_Number']."</span>";
				}
			?>
			<input type='hidden' id='hiddenValidation'>
			<script>
				function validatingRoomNumber(rn){
					var id = document.getElementsByClassName("RoomNumbers");
					for(var i=0;i<id.length;i++){
						var rnCollection = id[i].innerText;
							if(rnCollection == rn){
								document.getElementById("validationDisplay").innerText="Room Number Not Available";
								document.getElementById("hiddenValidation").value="Room Number Not Available";
								document.getElementById("validationDisplay").style.backgroundColor="red";
								break;
							}
							else{
								document.getElementById("validationDisplay").innerText="Room Number Available";
								document.getElementById("hiddenValidation").value="Room Number Available";
								document.getElementById("validationDisplay").style.backgroundColor="green";
							}
						
					}
				}
			</script>
			</label><br>
			<table border="0" >
				<tr>
					<td><label>Room Name</label></td>
					<td><input type="text" name="rnum" id="rnum" placeholder = "Please Enter Room Number" onChange="validatingRoomNumber(this.value)" required></td>
				</tr>
				<tr>
					<td><label>Room Type</label></td>
					<td>
						<input type="radio" name="rtype" id="rtype" value="AIRCON" checked>Aircon
						<input type="radio" name="rtype" id="rtype" value="REGULAR">Regular
					</td>
				</tr>
				<tr>
					<td><label>Cost per 3hrs</label></td>
					<td><input type="number" name="c3hr" id="c3hr" placeholder = "Please Enter Cost per 3hrs" required></td>
				</tr>
				<tr>
					<td><label>Cost per 12hrs</label></td>
					<td><input type="number" name="c12hr" id="c12hr" placeholder = "Please Enter Cost per 12hrs" required></td>
				</tr>
				<tr>
					<td><label>Cost per 24hrs</label></td>
					<td><input type="number" name="c24hr" id="c24hr" placeholder = "Please Enter Cost per 24hrs" required></td>
				</tr>
				<tr>
					<td></td>
					<td><input type='button' name='createRoom' value = 'Add Room' onclick='AddRoom()' ></td>
				</tr>
			</table>
		</form>
</center>
  </div>
</div>


<script>
var modalAdd = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
btn.onclick = function() {
    modalAdd.style.display = "block";
}
window.onclick = function(event) {
    if (event.target == modalEdit || event.target == modalAdd) {
        modalAdd.style.display = "none";
        modalEdit.style.display = "none";
		location.href='rooms.php#table';
    }
}
function myFunction(){
	modalAdd.style.display = "none";
	modalEdit.style.display = "none";
	location.href='rooms.php#table';
}

function leave(id){
	swal({
	title: "Are you sure?",
	text: "Did your client just leave your hotel?",
	type: "warning",
	showCancelButton: true,
	confirmButtonColor: "#DD6B55",
	confirmButtonText: "Yes, Make it Available!",
	closeOnConfirm: false,
	},
		function(isConfirm){  
			if (isConfirm) {
				swal("Success!", "This Room is now Available.", "success");
				redirect(id);
			}
		}	
	);
}
function redirect(idToLeave){
	setTimeout(function redirect(){
	location.href="makeitAvailable.php?id="+idToLeave;
	} , 1500);
}

function AddRoom(){
	var rn = document.getElementById("rnum").value;
	var c3 = document.getElementById("c3hr").value;
	var c12 = document.getElementById("c12hr").value;
	var c24 = document.getElementById("c24hr").value;
	var validationCreate = document.getElementById("hiddenValidation").value;
	if(rn == ""){
		swal("EMPTY!", "Room Number field cannot be empty!", "warning")
	}
	else if(c3 == ""){
		swal("EMPTY!", "Cost in 3hrs field cannot be empty!", "warning")
	}
	else if(c12== ""){
		swal("EMPTY!", "Cost in 12hrs field cannot be empty!", "warning")
	}
	else if(c24 == ""){
		swal("EMPTY!", "Cost in 24hrs field cannot be empty!", "warning")
	}
	else if(validationCreate == "Room Number Not Available"){
		swal("Duplicate!", "Room Number Should be different from other!", "warning")
	}
	else if(validationCreate == "Room Number Available"){
		swal({
		title: "Are you sure?",
		text: "You can change this room information anytime!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "skyblue",
		confirmButtonText: "Yes, Add this Room!",
		closeOnConfirm: false,
		},
			function(isConfirm){  
				if (isConfirm) {
					swal("Success!", "This Room is now Available.", "success");
					redirectAdd();
				}
			}	
		);
	}
	else{
		swal("WARNING!", "Please Make Change On The Room Number To Refresh! Please Don't Try To Bypass The System by using Inspect Element", "warning")
	}
}
function redirectAdd(){
	setTimeout(function redirectAdd(){
	document.getElementById("myRoom").submit();
	} , 1500);
}

function popUpDelete(id){
	swal({
	title: "Are you sure?",
	text: "You wont be able to recover this!",
	type: "warning",
	showCancelButton: true,
	confirmButtonColor: "#DD6B55",
	confirmButtonText: "Yes, Delete this Room!",
	closeOnConfirm: false,
	},
		function(isConfirm){  
			if (isConfirm) {
				swal("Success!", "Room Deleted.", "success");
				redirectDelete(id);
			}
		}	
	);
}
function redirectDelete(rid){
	setTimeout(function redirectAdd(){
	location.href="deleteRoom.php?id="+rid;
	} , 1500);
}
</script>
</body>
</html>


<?php ///////////////////////////////////////////////////////////POP UP MODAL TO UPDATE ROOM////////////////////////////////////////////////////////////////// ?>
<html>
<head><title></title></head>
<body>
<!-- Popup Menu -->
<div id="editModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onClick='myFunction()'>&times;</span>
<center>
<?php
if(isset($_GET['id'])){
	$editQuery = mysqli_query($conn, "SELECT * FROM rooms WHERE Room_ID =".$_GET['id']);
	while($edit = mysqli_fetch_assoc($editQuery)){
		$editID = $edit['Room_ID'];
		$editRN = $edit['Room_Number'];
		$editc3 = $edit['Cost_per_3hr'];
		$editc12 = $edit['Cost_per_12hr'];
		$editc24 = $edit['Cost_per_24hr'];
	}
?>
	<script>
	window.onload=function(){
		func();
	}
	</script>
<?php
}
?>
		<form id="EditRoom" method = "POST" action="Confirmation_RoomEdit.php?id=<?php echo $editID; ?>">
			<label>Please Enter The information needed to UPDATE/EDIT Room</label> <br>
			<label id="note">
			<span id='EDITvalidationDisplay'></span>
			<input type='hidden' id='defaultRoomName' value='<?php echo $editRN; ?>'>
			</label>
			<script>
				function EDITvalidatingRoomNumber(rn){
					var id = document.getElementsByClassName("RoomNumbers");
					var defRN = document.getElementById("defaultRoomName").value;
					for(var i=0;i<id.length;i++){
						var rnCollection = id[i].innerText;
						if(rn == defRN){
							document.getElementById("EDITvalidationDisplay").innerText=" ";
						}
						else if(rnCollection == rn){
							document.getElementById("EDITvalidationDisplay").innerText="Room Number Not Available";
							document.getElementById("EDITvalidationDisplay").style.backgroundColor="red";
							break;
						}
						else{
							document.getElementById("EDITvalidationDisplay").innerText="Room Number Available";
							document.getElementById("EDITvalidationDisplay").style.backgroundColor="green";
						}
					}
				}
			</script>
			<table border="0" >
				<tr>
					<input type='hidden' value='<?php echo $editID; ?>'>
					<td><label>Room Name</label></td>
					<td><input type="text" name="EDITrnum" id="EDITrnum" placeholder = "Please Enter Room Number" onChange="EDITvalidatingRoomNumber(this.value)" value='<?php echo $editRN; ?>' required></td>
				</tr>
				<tr>
					<td><label>Room Type</label></td>
					<td>
						<input type="radio" name="EDITrtype" id="EDITrtype" value="AIRCON" checked>Aircon
						<input type="radio" name="EDITrtype" id="EDITrtype" value="REGULAR">Regular
					</td>
				</tr>
				<tr>
					<td><label>Cost per 3hrs</label></td>
					<td><input type="number" name="EDITc3hr" id="EDITc3hr" placeholder = "Please Enter Cost per 3hrs" value='<?php echo $editc3; ?>' required></td>
				</tr>
				<tr>
					<td><label>Cost per 12hrs</label></td>
					<td><input type="number" name="EDITc12hr" id="EDITc12hr" placeholder = "Please Enter Cost per 12hrs" value='<?php echo $editc12; ?>' required></td>
				</tr>
				<tr>
					<td><label>Cost per 24hrs</label></td>
					<td><input type="number" name="EDITc24hr" id="EDITc24hr" placeholder = "Please Enter Cost per 24hrs" value='<?php echo $editc24; ?>' required></td>
				</tr>
				<tr>
					<td></td>
					<td><input type='button' name='EDITcreateRoom' id='EDITaroom' value = 'Add Room' onclick='UpdateRoom()' ></td>
				</tr>
			</table>
		</form>
</center>
</div>
</div>
<script>
var modalEdit = document.getElementById('editModal');
function func(){
	modalEdit.style.display = "block";
}

function UpdateRoom(){
	var rn = document.getElementById("EDITrnum").value;
	var c3 = document.getElementById("EDITc3hr").value;
	var c12 = document.getElementById("EDITc12hr").value;
	var c24 = document.getElementById("EDITc24hr").value;
	var validationUpdate = document.getElementById("EDITvalidationDisplay").innerText;
	if(rn == "" || rn == " "){
		swal("EMPTY!", "Room Number field cannot be empty!", "warning")
	}
	else if(c3 == ""){
		swal("EMPTY!", "Cost in 3hrs field cannot be empty!", "warning")
	}
	else if(c12== ""){
		swal("EMPTY!", "Cost in 12hrs field cannot be empty!", "warning")
	}
	else if(c24 == ""){
		swal("EMPTY!", "Cost in 24hrs field cannot be empty!", "warning")
	}
	else if(validationUpdate == "Room Number Not Available"){
		swal("Duplicate!", "Room Number Should be different from other!", "warning")
	}
	else{
		swal({
		title: "Are you sure?",
		text: "You can change this room information anytime!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "skyblue",
		confirmButtonText: "Yes, Add this Room!",
		closeOnConfirm: false,
		},
			function(isConfirm){  
				if (isConfirm) {
					swal("Success!", "This Room is now Available.", "success");
					redirectUpdate();
				}
			}	
		);
	}
}
function redirectUpdate(){
	setTimeout(function redirectAdd(){
	document.getElementById("EditRoom").submit();
	} , 1500);
}
</script>
</body>
</html>