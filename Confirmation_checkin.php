<?php
session_start();
if(isset($_SESSION['name'])){
include_once('config.php');
		date_default_timezone_set('Asia/Manila');
		$rid = $_POST['rid'];
		$rnum = $_POST['rnum'];
		$name = $_POST['cname'];
		$indate = $_POST['indate'];
		$intime = $_POST['intime'];
		$formatedDate = $_POST['outdate'];
		$outdate = date('m/d/Y',strtotime($formatedDate));
		$outtime = $_POST['outtime'];
		$twoFourFormat = date('G:i:s',strtotime($outtime));
		$ctype = $_POST['ctype'];
		$max = $_POST['max'];
		$cost = $_POST['cost'];
		$payment = $_POST['pay'];
		$change = $payment - $cost;
								
		$result = "INSERT INTO transaction (`Staff_ID`,`Checkin_Date`,`Checkin_Time`,`Checkout_Date`,`Checkout_Time`,`Client_Name`,`Room_ID`,`Checkin_Type`,`Max`,`Cost`,`Payment`,`Change`) VALUES ('1','$indate','$intime','$outdate','$twoFourFormat','$name','$rid','$ctype','$max','$cost','$payment','$change')";
		mysqli_query($conn,$result) or
		die('Query "' . $result . '" failed: ' . mysqli_error());
		$changeColor = mysqli_query($conn,"SELECT * FROM Rooms");
		while($res=mysqli_fetch_array($changeColor)){
			$rn = $res['Room_Number'];
			if($rn == $rnum){
				$query = "UPDATE Rooms SET Status='OCCUPIED' WHERE Room_Number='$rn'";
				mysqli_query($conn,$query) or  die('Query "' . $query . '" failed: ' . mysqli_error());
			}
		}
								
		$date = date('m/d/Y');
		$time = date('h:i:sA');
		$name = $_SESSION['name'];
		$act = "Client Checkin at Room $rnum";
		$loglist = "INSERT INTO login_log (Staff_ID,Date,Time,Activity) VALUES (1,'$date','$time','$act')";
		mysqli_query($conn,$loglist) or
		die('Query "' . $loglist . '" failed: ' . mysqli_error());
}
else{
	header('location:login.php');
}
?>
<script>
location.href="checkin.php";
</script>