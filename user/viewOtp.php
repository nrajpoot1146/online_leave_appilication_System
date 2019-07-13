<?php
include('../include/session.php');
if(isset($_GET['id'])){
	$outpassid = $_GET['id'];
	$conn = new mysqli(dbHost,dbUser,dbPass,dbName);
	$nrmt=$conn->prepare("SELECT * FROM ".recAppTable." WHERE recOutpassId= ? AND recUsername= ?");
	$nrmt->bind_param("ss",$outpassid,$_SESSION['recUsername']);
	$nrmt->execute();
	$res=$nrmt->get_result();
	$nrmt->close();
	$conn->close();
	if($res->num_rows>0){
		$row = $res->fetch_assoc();
	}else{
		echo("<center><h1>invalid request..</h1><center>");
		exit();
	}
}else{
	echo("<center><h1>invalid request..</h1><center>");
	exit();
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo "Application Id : ".$outpassid;?></title>
<link href="../style.css" rel="stylesheet" type="text/css">
<style>
	#viewPass{
		width: 80%;
		margin: 30px auto;
		padding: 0px;
	}
	#viewPass table{
		width: 100%;
	}
	td:nth-child(odd){
		font-weight: bold;
		margin: 0px;
	}
	.header img{
		float: left;
	}
</style>
</head>
<body>
	<div style="width: 90%; margin: 0px auto;">
		<div style="overflow: auto;" class="header">
			<img src="../image/about_logo (1).png" width="100px"/>
			<div style="padding: 20px; font-size: 40px; text-align: center;">
				Rajkiya Engineering College, Banda-210201
			</div>
		</div>
		<div style="overflow: auto; margin: 30px; font-weight: bold;">
			<div style="float: left">
				Outpass ID : <?php echo $row['recOutpassId'];?>
			</div>
			<div style="float: right">
				Applied Time : <?php echo $row['recAppliedDate'];?>
			</div>
		</div>
		<table id="viewPass">
			<tr>
				<td>Name :</td><td><?php echo $login_user->get_fullname();?></td>
			</tr>
			<tr>
				<td>Roll No. :</td><td><?php echo $login_user->get_rollno();?></td>
			</tr>
			<tr>
				<td>Hostel :</td><td><?php echo $login_user->get_hostel();?></td>
			</tr>
			<tr>
				<td>Room No. :</td><td><?php echo $login_user->get_FRoomno();?></td>
			</tr>
			<tr>
				<td>Hostel :</td><td><?php echo $login_user->get_hostel();?></td>
			</tr>
			<tr>
				<td>Exit Date :</td><td><?php echo dateFormat($row['recOutDate'])?></td>
			</tr>
			<tr>
				<td>Exit Time :</td><td><?php echo $row['recOutTime'];?></td>
			</tr>
			<tr>
				<td>Entry Date :</td><td><?php echo dateFormat($row['recInDate'])?></td>
			</tr>
			<tr>
				<td>Entry Time :</td><td><?php echo $row['recInTime'];?></td>
			</tr>
			<tr>
				<td>Status :</td><td><?php
					echo(getStatus($row['status']));
				?>
				</td>
			</tr>
		</table>
		<div style="text-align: center;"><button onClick="window.print();">Print</button></div>
	</div>
</body>
</html>