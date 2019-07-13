<?php
require_once("include/config.php");
$conn = new mysqli(dbHost,dbUser,dbPass);

$q = "SHOW DATABASES LIKE '". dbName ."'";

$res = $conn->query($q);
$data = array();

if($res->num_rows){
	$conn->select_db(dbName);
}
else{
	$q = "CREATE DATABASE ". dbName;
	$conn->query($q);
	$conn->select_db(dbName);
}

if(isset($_POST['username'])){
	
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $rollno = $_POST['rollno'];
    $gender = $_POST['gender'];
    $year = $_POST['year'];
    $branch = $_POST['branch'];
    $mobno = $_POST['mobnumber'];
    $email = $_POST['email'];
	
    $block = $_POST['block'];
    $floor = $_POST['floor'];
    $roomno = $_POST['roomno'];
	
    $pass = $_POST['password'];
    $dob = $_POST['dob'];
	
	$rec_hostel_id = $block.$floor.$roomno;
	$sec = localtime()[0];
		
	if($sec<10)
		$rec_hostel_id = $rec_hostel_id."0".$sec;
	else
		$rec_hostel_id = $rec_hostel_id.$sec;
	
	$res = $conn->query("SHOW TABLES LIKE 'recStudents'");
	
	if($res->num_rows!=1){
		$q = "CREATE TABLE recStudents (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				recUsername VARCHAR(50) NOT NULL UNIQUE,
				recRollNo VARCHAR(10) NOT NULL,
				recFirstname VARCHAR(30) NOT NULL,
				recLastname VARCHAR(30) NOT NULL,
				recGender VARCHAR(10) NOT NULL,
				recDateOfBirth VARCHAR(10) NOT NULL,
				recYear VARCHAR(5) NOT NULL,
				recBranch VARCHAR(5) NOT NULL,
				recEmail VARCHAR(50) NOT NULL UNIQUE,
				recMobile VARCHAR(10) NOT NULL,
				recBlock VARCHAR(2) NOT NULL,
				recFloor VARCHAR(2) NOT NULL,
				recRoom VARCHAR(4) NOT NULL,
				recPass VARCHAR(100) NOT NULL,
				recAdmin INT(1) NOT NULL
				)";
		$conn->query($q);
		$q = "CREATE TABLE recBranch (
				id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				recBranchCode INT(4) UNSIGNED NOT NULL UNIQUE,
				recBranchName VARCHAR(30) NOT NULL
		)";
		$conn->query($q);
	}
    
    $r = $conn->query("SELECT recEmail FROM recStudents WHERE recEmail='$email'");
    
    if(mysqli_num_rows($r)==0){
		
        $q = "INSERT INTO recStudents (recUsername,recRollNo,recFirstname,recLastname,recGender,recDateOfBirth,recYear,recBranch,recEmail,recMobile,recBlock,recFloor,recRoom,recPass,recAdmin) VALUES ('$username','$rollno','$firstname','$lastname','$gender','$dob','$year','$branch','$email','$mobno','$block','$floor','$roomno','$pass',0)";
		

        if($conn->query($q)){
            $data['status']= true;
            $data['responce']="Registration complete.";
            $data['id'] = "$rec_hostel_id";
			echo json_encode($data);
        }else{
			$data['status']= false;
            $data['responce']="Registration Failled.";
			echo json_encode($data);
        }
        }else{
			$data['status']= false;
            $data['responce']="Allready registered";
			echo json_encode($data);
		}
    }
	$conn->close();
?>