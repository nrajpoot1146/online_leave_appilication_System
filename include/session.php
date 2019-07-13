
<?php
include_once("config.php");
session_start();
	if($_SERVER['PHP_SELF']=='/blk/blkcaphax/clg/action.php' && isset($_GET['id']) && isset($_GET['ky']) && isset($_GET['c'])){
		   
	   }
   elseif(!isset($_SESSION['recUsername'])){
	   if($_SERVER['PHP_SELF']!=HOSTDIR.'/index.php'){
		   header("location: ".host);
		   exit();
	   }
   }else{
	   if($_SERVER['PHP_SELF']==HOSTDIR.'/action.php' && isset($_POST['t'])){
		   
	   }
	   elseif(substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],"/"))==HOSTDIR){
		   if($_SESSION['recAdmin']){
			   header('location: '.adminPage);
			   exit();
		   }else{
			   header('location: '.userPage);
			   exit();
		   }
	   }
	   elseif(!$_SESSION['recAdmin']&&$_SERVER['PHP_SELF']!=HOSTDIR.'/user/index.php'){
		   if(substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],"/"))==ADMIN_PAGE_FOLDER){
			   header("location: ".host."/user/");
			   exit();
		   }
	   }
	   elseif($_SESSION['recAdmin']&&$_SERVER['PHP_SELF']!=HOSTDIR.'/admin/index.php'){
		   if(substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],"/"))==USER_PAGE_FOLDER){
			   header("location: ".host."/admin/");
			   exit();
		   }
	   }
	   $login_user = new nr_std($_SESSION['recUsername']);
   }

$conn = new mysqli(dbHost,dbUser,dbPass);
$res = $conn->query("SHOW DATABASES LIKE '". dbName ."'");
if(!$res->num_rows){
	$conn->query("CREATE DATABASE ".dbName);
	$conn->select_db(dbName);

	$res = $conn->query("SHOW TABLES LIKE '". recBranches ."'");
	if(!$res->num_rows){
		$q = "CREATE TABLE ". recBranches ." (
			id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			recBranchCode INT(4) UNSIGNED NOT NULL UNIQUE,
			recBranchName VARCHAR(30) NOT NULL
		)";
		$conn->query($q);
	
		$q = "INSERT INTO ". recBranches ." (recBranchCode,recBranchName) VALUES (13,'Information Technology')";
		$conn->query($q);
		$q = "INSERT INTO ". recBranches ." (recBranchCode,recBranchName) VALUES (20,'Electrical Engineering')";
		$conn->query($q);
		$q = "INSERT INTO ". recBranches ." (recBranchCode,recBranchName) VALUES (40,'Mechanical Engineering')";
		$conn->query($q);
	}
	
	$res = $conn->query("SHOW TABLES LIKE '". recAppType ."'");
	if(!$res->num_rows){
		$q = "CREATE TABLE ". recAppType ." (
			id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			recAppCode INT(2) UNSIGNED NOT NULL UNIQUE,
			recAppName VARCHAR(30) NOT NULL
		)";
		$conn->query($q);
	
		$q = "INSERT INTO ". recAppType ." (recAppCode,recAppName) VALUES (1,'Outpass')";
		$conn->query($q);
		$q = "INSERT INTO ". recAppType ." (recAppCode,recAppName) VALUES (2,'Leave Application')";
		$conn->query($q);
	}

	$res = $conn->query("SHOW TABLES LIKE '". recHostels ."'");
	if(!$res->num_rows){
		$q = "CREATE TABLE ". recHostels ." (
			id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			recHostelCode VARCHAR(2) NOT NULL UNIQUE,
			recHostelName VARCHAR(30) NOT NULL
		)";
		$conn->query($q);
	
		$q = "INSERT INTO ". recHostels ." (recHostelCode,recHostelName) VALUES ('A','Aryabhatt Hostel')";
		$conn->query($q);
		$q = "INSERT INTO ". recHostels ." (recHostelCode,recHostelName) VALUES ('B','Ramanujan Hostel')";
		$conn->query($q);
		$q = "INSERT INTO ". recHostels ." (recHostelCode,recHostelName) VALUES ('C','C. V. Raman Hostel')";
		$conn->query($q);
		$q = "INSERT INTO ". recHostels ." (recHostelCode,recHostelName) VALUES ('G','Mandakini Hostel')";
		$conn->query($q);
	}
	
	$res = $conn->query("SHOW TABLES LIKE '". recStudentsTable ."'");
	if(!$res->num_rows){
		$q = "CREATE TABLE ". recStudentsTable ." (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			recUsername VARCHAR(50) NOT NULL UNIQUE,
			recRollNo VARCHAR(10) NOT NULL,
			recFirstname VARCHAR(30) NOT NULL,
			recLastname VARCHAR(30) NOT NULL,
			recGender VARCHAR(10) NOT NULL,
			recDateOfBirth VARCHAR(10) NOT NULL,
			recYear VARCHAR(5) NOT NULL,
			recBranch INT(4) UNSIGNED NOT NULL,
			recEmail VARCHAR(50) NOT NULL UNIQUE,
			recMobile VARCHAR(10) NOT NULL,
			recHostel VARCHAR(2) NOT NULL,
			recFloor VARCHAR(2) NOT NULL,
			recRoom VARCHAR(4) NOT NULL,
			recPass VARCHAR(100) NOT NULL,
			recAdmin INT(1) NOT NULL,
			FOREIGN KEY (recBranch) REFERENCES ". recBranches ."(recBranchCode),
			FOREIGN KEY (recHostel) REFERENCES ". recHostels ."(recHostelCode)
			)";
		$conn->query($q);
	}
	
	$q = "CREATE TABLE ". recAdminTable ."(
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		recUsername VARCHAR(50) NOT NULL UNIQUE,
		recFirstname VARCHAR(30) NOT NULL,
		recLastname VARCHAR(30) NOT NULL,
		recGender VARCHAR(10) NOT NULL,
		recDateOfBirth VARCHAR(10) NOT NULL,
		recEmail VARCHAR(50) NOT NULL UNIQUE,
		recMobile VARCHAR(10) NOT NULL,
		recHostel VARCHAR(2) NOT NULL,
		recFloor VARCHAR(2) NOT NULL,
		recRoom VARCHAR(4) NOT NULL,
		recPass VARCHAR(100) NOT NULL,
		recAdmin INT(1) NOT NULL
	)";
	$res = $conn->query($q);
	
	$res = $conn->query("SHOW TABLES LIKE '". recAppTable ."'");
	if(!$res->num_rows){
		$q = "CREATE TABLE ".recAppTable." (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			recOutpassId VARCHAR(10) NOT NULL UNIQUE,
			recUsername VARCHAR(30) NOT NULL,
			recAppliedDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			recOutDate DATE NOT NULL,
			recOutTime TIME NOT NULL,
			recInDate DATE NOT NULL,
			recInTime TIME NOT NULL,
			recPP VARCHAR(30) NOT NULL,
			recPlace VARCHAR(30) NOT NULL,
			recType INT(2) UNSIGNED NOT NULL,
			status int(2) NOT NULL,
			passCount int(200) NOT NULL,
			FOREIGN KEY (recUsername) REFERENCES ". recStudentsTable ."(recUsername),
			FOREIGN KEY (recType) REFERENCES ". recAppType ."(recAppCode)
			)";
		$conn->query($q);
	}

}else{
	$conn->select_db(dbName);
}

abstract class nr_hostel{
	protected $hostel_A = 'Aryabhatt';
	protected $hostel_B = "Ramanujan";
	protected $hostel_C = "C.V. Raman";
	protected $hostel_G = "Mandakini";
	
	protected $floor_G = "Ground";
	protected $floor_F = "First";
	protected $floor_S = "Second";
	protected $floor_T = "Third";
	
	protected $it = "Information Technology";
	protected $ee = "Electrical Engineering";
	protected $me = "Mechanical Engineering";
}

class nr_std extends nr_hostel{
	private $dbUserName = dbUser;
	private $password = dbPass;
	private $dbName = dbName;
	private $tableName = recStudentsTable;
	
	private $recFirstname;
	private $recLastname;
	private $recGender;
	private $recBranch;
	private $recYear;
	private $recMobile;
	private $recHostel;
	private $recFloor;
	private $recRoom;
	private $recDateOfBirth;
	public $recAdmin;
	
	function nr_std($user_check){
		$conn = new mysqli("",$this->dbUserName,$this->password,$this->dbName);
		$q = "SELECT s.recFirstname,
					 s.recLastname,
					 s.recGender,
					 s.recDateOfBirth,
					 s.recYear,
					 b.recBranchName,
					 h.recHostelName,
					 s.recEmail,
					 s.recMobile,
					 s.recFloor,
					 s.recHostel,
					 s.recPass,
					 s.recRoom,
					 s.recAdmin
			 FROM $this->tableName s
					 JOIN 
					 	recbranches b 
					 ON 
					 	b.recBranchCode=s.recBranch
					 JOIN
					 	rechostels h
					 ON 
					 	h.recHostelCode = s.recHostel
			 WHERE s.recUsername = '$user_check'";
		
		if($res = $conn->query($q)){
			$row = $res->fetch_array(MYSQLI_BOTH);
			
			$this->recFirstname = $row['recFirstname'];
			$this->recLastname = $row['recLastname'];
			$this->recGender = $row['recGender'];
			
			if(isset($row['recYear']))
				$this->recYear = $row['recYear'];
			if(isset($row['recBranchName']))
				$this->recBranch = $row['recBranchName'];
			
			$this->recMobile = $row['recMobile'];
			$this->recHostel = $row['recHostel'];
			$this->recFloor = $row['recFloor'];
			$this->recRoom = $row['recRoom'];
			$this->recDateOfBirth = $row['recDateOfBirth'];
			$this->recAdmin = $row['recAdmin'];
		}
		$conn->close();
	}
	
	public function get_email(){
		return $_SESSION['recEmail'];
	}
	public function getUsername(){
		return $_SESSION['recUsername'];
	}
	public function get_rollno(){
		return $_SESSION['recRoll'];
	}
	
	public function get_fullname(){
		return $this->recFirstname." ".$this->recLastname;
	}
	
	public function get_firstname(){
		return $this->recFirstname;
	}
	public function get_lastname(){
		return $this->recLasttname;
	}
	
	public function get_gender(){
		return $this->recGender;
	}
	
	public function get_year(){
		return $this->recYear;
	}
	
	public function get_branch(){
		return($this->recBranch);
	}
	
	public function get_mobile_no(){
		return $this->recMobile;
	}
	
	public function get_dateOfBirth(){
		return $this->recDateOfBirth;
	}
	
	public function get_hostel(){
		if($this->recHostel=='A')
			return $this->hostel_A;
		else if($this->recHostel=='B')
			return $this->hostel_B;
		else if($this->recHostel=='C')
			return $this->hostel_C;
		else
			return $this->hostel_G;
	}
	
	public function get_floor(){
		if($this->recFloor=='G')
			return $this->floor_G;
		else if($this->recFloor=='F')
			return $this->floor_F;
		else if($this->recFloor=='S')
			return $this->floor_S;
		else
			return $this->floor_T;
	}
	
	public function get_roomno(){
		return $this->recRoom;
	}
	
	public function get_FRoomno(){
		if($this->recRoom<10)
			return $this->recHostel.$this->recFloor.'-'.$this->recRoom;
		else
			return $this->recHostel.$this->recFloor.'-'.$this->recRoom;
	}
}

function pageRedirect(){
	if($_SESSION['recAdmin']){
		header('location: '.adminPage);
		exit();
	}else{
		header('location: '.userPage);
		exit();
	}
}

function dateFormat($date){
	$date=date_create($date);
	$date=date_format($date,"d/m/Y");
	return($date);
}
function timeFormat($time){
	$time = date_create($time);
	$time = date_format($time,"h:s");
	return($time);
}
function getStatus($s){
	if($s==0){
		return("<span style='color: brown; font-weight: bold;'>Waitting</span>..");
	}
	elseif($s==1){
		return("<span style='color: green; font-weight: bold;'>Confirmed..</span>");
	}
	else{
		return("<span style='color: Red; font-weight: bold;'>Rejected..</span>");
	}
}

class student {
	private $username;
	private $days;
	function student($user){
		$this->username=$user;
		$days = "{'sunday':0,'monday':1,'tuesday':2,'wednesday':3,'thursday':4,'friday':5,'saturday':6}";
		$days = json_decode($days);
	}
	function getNumberCurrentWeak(){
		$day = date('l');
		$day = $days[$day];
	}
}
?>