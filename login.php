<?php
include_once("include/config.php");

session_start();
if(!isset($_SESSION['recUsername'])){
	if(isset($_POST['username']) && isset($_POST['pass'])){
		$username = $_POST['username'];
		$password = $_POST['pass'];
		
		$data = array();
		
		$conn = new mysqli("",dbUser,dbPass,dbName);
		
		$q = "SELECT * FROM ". recStudentsTable ." WHERE recUsername = ? AND recPass = ?";
		$nrmt = $conn->prepare($q);
		$nrmt->bind_param("ss",$username,$password);
		$nrmt->execute();
		$res = $nrmt->get_result();
		$nrmt->close();
		$conn->close();
		
		if($res->num_rows==1){
			$row = mysqli_fetch_array($res);
			$_SESSION['recUsername'] = $username;
			$_SESSION['recRoll'] = $row['recRollNo'];
			$_SESSION['recEmail'] = $row['recEmail'];
			$_SESSION['recAdmin'] = $row['recAdmin'];
			if(isset($_POST['ajax'])&& $_POST['ajax']==true){
				$data["status"]	= true;
				if($row['recAdmin']==0)
					$data["responce"] = userPage;
				else
					$data['responce'] = adminPage;
				echo json_encode($data);
				exit();
			}else{
				if($row['recAdmin']==0)
					header('location: '. userPage);
				else
					header('location: '. adminPage);
				exit();
			}
			
		}
		else{
			if(isset($_POST['ajax'])&& $_POST['ajax']==true){
				$data["status"]	= false;
				$data["responce"] = "Wrong username or password.";
				echo json_encode($data);
				session_destroy();
			}else{
				echo "<script>alert(\"Wrong username or password\")</script>";
				echo "<a href=\"".host."\">Back to login page.</a>";
				exit();
			}
			exit();
		}
	}
	else{
		session_destroy();
		header("location: ".host);
		exit();
	}
}
else{
	header("location: ". userPage);
	exit();
}
?>
