<?php
include_once('include/session.php');
include_once('include/config.php');
$conn = new mysqli(dbHost,dbUser,dbPass);

$q = "SHOW DATABASES LIKE '". dbName ."'";

$res = $conn->query($q);
$data = array();

if($res->num_rows){
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
    
    $r = $conn->query("SELECT recEmail FROM ". recStudentsTable ." WHERE recEmail='$email'");
    
    if(mysqli_num_rows($r)==0){
		
        $q = "INSERT INTO recStudents (recUsername,recRollNo,recFirstname,recLastname,recGender,recDateOfBirth,recYear,recBranch,recEmail,recMobile,recHostel,recFloor,recRoom,recPass,recAdmin) VALUES ('$username','$rollno','$firstname','$lastname','$gender','$dob','$year','$branch','$email','$mobno','$block','$floor','$roomno','$pass',0)";
		
        if($conn->query($q)){
            $data['status']= true;
            $data['responce']="Registration complete.";
            $data['id'] = "$rec_hostel_id";
			echo json_encode($data);
        }else{
			$data['status']= false;
            $data['responce']="$q Registration Failled.";
			echo json_encode($data);
        }
        }else{
			$data['status']= false;
            $data['responce']="Allready registered";
			echo json_encode($data);
		}
	exit();
    }
	
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/clg.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Rajkiya Engineering College Banda | Hostels</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/rec.js"></script>
 
</head>

<body>
<div id="container"> 
  <header>
  	<img src="image/about_logo%20(1).png" width="85" height="76" alt=""/>
  	<div id="header-text">Rajkiya Engineering College, Banda Hostels</div>
  </header>
  <nav>
  	<?php
	  if(isset($_SESSION['recUsername']))
  		echo "<a href='home' title='home'>Home</a>
		<a href='app' title='Application'>Application</a>
		<a href=\"logout\" title=\"logout\" id=\"logout\">Logout</a>";
	?>
  </nav>
  <section><!-- InstanceBeginEditable name="section" -->
  <div style="margin: 0px; padding: 0px; width:100%; height: auto;">
  	<div id = "login-form" class="animate">
  		<heading>
  		Login to your account
  		</heading>
		<div id='login-err' style="color: red; height: 30px;"></div>
		<form action="login.php" method="post">
			<input name='username' type='text' placeholder="Enter Username"/><br>
			<input name='pass' type='password' placeholder="Enter Password"/>
			<div style="text-align: left;">
				<input type="checkbox" />Show Paassword
			</div>
			<div style='text-align: center;'>
				<button id='login-submit' type="submit">Login</button>
			</div>
		</form>
	</div>
	
	<div id = "reg-form" class="animate">
    	<form action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" onSubmit="">

       			<input type="text" name="username" placeholder="Username" required /><br>
       			<input type="text" name="firstname" placeholder="Firstname" required />
        		<input type="text" name="lastname" placeholder="Lastname" required/><br>

        		<div class="">Gender :<span style="color:red;"> *</span></div>
        		<input type="radio" name="gender" value="Male">Male
        		<input type="radio" name="gender" value="Female">Female<br>

        		Date of Birth :<span style="color:red;"> *</span>
        		<input type="date" name="dob" required/><br>

        		<input type="text" name="mobnumber" maxlength="10" placeholder="Mobile No." required/>
        		<input type="text" name="rollno" maxlength="10" placeholder="Roll No." required/>
        		<br>
        		<div class="">
        			<span>Year :</span>
        			<select name="year">
      	  				<option value="1st">1st</option>
        				<option value="2nd">2nd</option>
        				<option value="3rd">3rd</option>
        				<option value="4th">4th</option>
        			</select>
        		</div>
        		<div class="">
        			<?php
					$q = "SELECT * FROM ". recBranches;
					$res = $conn->query($q);
					echo "<span>Branch :</span>";
        			echo "<select name='branch'>";
        			if($res->num_rows>0){
						while($row=$res->fetch_assoc()){
							echo("<option 	value='".$row['recBranchCode']."'>".$row['recBranchName']."		</option>");
						}
					}
					echo "</select>";
					?>
        			
        		</div>
       			<span>Block :</span>
      		    <select name="block">
      		    <?php
				$q = "SELECT * FROM rechostels";
				$res = $conn->query($q);
        		if($res->num_rows>0){
					while($row=$res->fetch_assoc()){
						echo("<option value='".$row['recHostelCode']."'>".$row['recHostelName']."</option>");
					}
				}
				?>
        		</select>

        		<span>Floor :</span>
        		<select name="floor">
        			<option value="G">Ground Floor</option>
        			<option value="F">First Floor</option>
        			<option value="S">Second Floor</option>
        			<option value="T">Third Floor</option>
        		</select>
        		<br>
        		<span>Room no. :</span>
        		<select name="roomno">
        			<option value="01">01</option>
        			<option value="02">02</option>
        			<option value="03">03</option>
        			<option value="04">04</option>
        			<option value="05">05</option>
        			<option value="06">06</option>
        			<option value="07">07</option>
        			<option value="08">08</option>
        			<option value="09">09</option>
        			<option value="10">10</option>
        			<option value="11">11</option>
        			<option value="12">12</option>
        			<option value="13">13</option>
        			<option value="14">14</option>
        			<option value="15">15</option>
        			<option value="16">16</option>
        			<option value="00">CR</option>
       		 	</select><br>

        		<input type="text" name="email" placeholder="Email" required/>
        		<input type="password" name="password" placeholder="Password" required/>

				<div style="text-align: center;"><button type="submit" >Register</button></div>
			</form>
		</div>
	  </div>
	  	<div id = 'menu'>
			<div class="menu-item" id = "login-form-btn">Login</div>
			<div class="menu-item" id = "reg-form-btn">Registration</div>
		</div>
  <!-- InstanceEndEditable --></section>
 	<?php
  	if(isset($_SESSION['recUsername']))
   		echo "<footer>@ blkCaphax</footer>";
	?>
</div>

<div id="lock-display">
	
</div>
<div id="wait-box" class='animate'>
	<img src="wait.gif" width="51" height="52" /><br>
	<div>
		<span></span><br>
		<p></p>
		<button>OK</button>
	</div>
</div>


</body>
<!-- InstanceEnd --></html>
