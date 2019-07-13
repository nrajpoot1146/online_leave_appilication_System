<?php
require_once("../include/config.php");
require_once("../include/session.php");
if($login_user->recAdmin!=1){
	//header("location: ../index.php");
	//exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome Admin</title>
<link href="../style.css" rel="stylesheet" type="text/css"/>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/rec.js"></script>
<style>
	.thumb{
		display: inline-block;
		width: 150px;
		height: 150px;
		border: 1px solid #bbb;
		box-shadow: 1px 0px 3px #bbb;
		box-sizing: padding-box;
		overflow: hidden;
		position: relative;
		top: 0px;
		left: 0px;
		padding: 1px;
	}
	.admin-dash-item{
		width: 100%;
		height: 100%;
		box-sizing: padding-box;
		position: relative;
		background: #A5A4F2;
		top: 0px;
		left: 0px;
	}
	.admin-dash-item:hover{
		cursor: pointer;
		opacity: .9;
		animation: zoomIn .2s;
		transform: scale(1.1);
	}
	.admin-dash-item-text{
		color: aliceblue;
		font-size: 20px;
		text-shadow: 0px 0px 2px white;
		-webkit-text-fill-color: none;
	}
	.admin-dash-item-text:hover{
		
	}
	@keyframes zoomIn{
		from{transform: scale(1);}
		to{transform: scale(1.1);}
	}
	tr,table{
		width: 100%;
		box-shadow: 0px 0px 2px #bbb;
	}
	td,th{
		padding: 0px 10px;
		box-sizing: padding-box;
		font-size: 14px;
	}
	th{
		background-color: #777071;
		color: white;
	}
	tr:nth-child(even){
		background: #E7E5E5;
	}
	tr:nth-child(odd){
		background: #FFFFFF;
	}
</style>
</head>

<body>
<header>
	<div align="center">
		Rajkiya Engineering College Banda<br>
		Admin Panel
	</div>
</header>
<div>
	<a href="javascript:history.go(-1)">GO BACK</a>
	<a href="../logout.php">Logout</a>
</div>
<section align="center">
	<?php
	if(isset($_GET['cmd'])&&$_GET['cmd']!=''){
		if($_GET['cmd']=='students'){
			$conn = new mysqli(dbHost,dbUser,dbPass,dbName);
			$q = "SELECT * FROM ".recStudentsTable." WHERE recAdmin=0";
			$res=$conn->query($q);
			echo("<div style='width: 90%; margin: auto;'>");
			echo("<table>");
			echo("<th>Sr No.</th><th>Roll No.</th><th>Name</th><th>Gender</th><th>Date of birth</th><th>Branch</th><th>Year</th><th>Mobile No.</th><th>Room No</th>");
			$i=0;
			while($row=$res->fetch_assoc()){
				$i++;
				echo("<tr>");
				echo("<td class=\"nr-center\">$i</td>");
				echo("<td>".$row['recUsername']."</td>");
				echo("<td>".$row['recFirstname']." ".$row['recLastname']."</td>");
				echo("<td>".$row['recGender']."</td>");
				echo("<td class='nr-center'>".dateFormat($row['recDateOfBirth'])."</td>");
				echo("<td class='nr-center'>".$row['recBranch']."</td>");
				echo("<td class='nr-center'>".$row['recYear']."Year</td>");
				echo("<td class='nr-center'>".$row['recMobile']."</td>");
				echo("<td class='nr-center'>".$row['recHostel'].$row['recFloor']."-".$row['recRoom']."</td>");
				echo("</tr>");
			}
			echo("</table>");
			echo("</div>");
			exit();
		}
		if($_GET['cmd']=='outpasses'){
			$conn = new mysqli(dbHost,dbUser,dbPass,dbName);
			$q = "SELECT * FROM ".recAppTable.";";
			$res=$conn->query($q);
			echo("<div style='width: 90%; margin: auto;'>");
			echo("<table>");
			echo("<th>Sr No.</th><th>Roll No.</th><th>Name</th><th>Gender</th><th>Date of birth</th><th>Branch</th><th>Year</th><th>Mobile No.</th><th>Room No</th>");
			$i=0;
			while($row=$res->fetch_assoc()){
				$i++;
				echo("<tr>");
				echo("<td class=\"nr-center\">$i</td>");
				echo("<td>".$row['rec']."</td>");
				echo("<td>".$row['recFirstname']." ".$row['recLastname']."</td>");
				echo("<td>".$row['recGender']."</td>");
				echo("<td class='nr-center'>".dateFormat($row['recDateOfBirth'])."</td>");
				echo("<td class='nr-center'>".$row['recBranch']."</td>");
				echo("<td class='nr-center'>".$row['recYear']."Year</td>");
				echo("<td class='nr-center'>".$row['recMobile']."</td>");
				echo("<td class='nr-center'>".$row['recBlock'].$row['recFloor']."-".$row['recRoom']."</td>");
				echo("</tr>");
			}
			echo("</table>");
			echo("</div>");
			exit();
		}elseif($_GET['cmd']=='opPref'){
			$conn = new mysqli(dbHost,dbUser,dbPass,dbName);
			$q = "CREATE TABLE recOpPref(
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				wOplimit INT(100) NOT NULL,
				wOpwithouPerm INT(10) NOT NULL,
				mornExitTime TIME NOT NULL,
				eveExitTime TIME NOT NULL
			)";
			$conn->query($q);
			$conn->close();
		}else
			echo "invalid";
		
	}
	else
		include_once('include/adminDash.php');
	?>
</section>
</body>
</html>