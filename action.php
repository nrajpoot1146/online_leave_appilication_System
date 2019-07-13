<?php
include('include/session.php');
include_once('include/config.php');
include_once('class/ClassApplication.php');

if(isset($_POST['t'])){
	$cmd = $_POST['t'];
	//if($cmd == REC_OUTPASS)
		//include('include/nr_rec_outpass.php');
	//elseif($cmd == REC_PROFILE)
		//include("profile.php");
	//else
	if($cmd == SUBMIT_OUTPASS){
		
		$f = fopen(appConfigJson,'r');
		if(filesize(appConfigJson)>0)
			$cnfg = fread($f,filesize(appConfigJson));
		$cnfg = json_decode($cnfg,true);
		$app = new ClassApplication($_POST);
		
		$purpose = $_POST['recPurpose'];
		$place = $_POST['recPlace'];
		$type = $_POST['recType'];
		
		$outDate = $_POST['recOutDate'];
		$outTime = $_POST['recOutTime'];
		$EXIT_DATE = date_create($app->outDate." ".$app->outTime);
			
		$inDate  = $_POST['recInDate'];
		$inTime  = $_POST['recInTime'];
		$ENTERY_DATE = date_create($app->inDate." ".$app->inTime);
		
		$dateInterval = date_diff($EXIT_DATE,$ENTERY_DATE);
		
		if($type==1){
			$currentDate = new DateTime("now");
			$dateIntervalFromCdate = date_diff($currentDate,$ENTERY_DATE);
			$dayFromCurrentDate = $dateIntervalFromCdate->format("%R%a");
			if($dayFromCurrentDate>=0&&$dayFromCurrentDate<=5){
				$day = (int)$dateInterval->format("%a");
				if($day==0){
					$h = (int)$dateInterval->format("%R%h");
					if($h>0){
						$username = $login_user->getUsername();

						$conn = new mysqli(dbHost,dbUser,dbPass);
						$conn->select_db(dbName);
						
						$array = generateOtpid($conn);
						$recOutpassId = $array['recOutpassId'];
						$passCount = $array['passCount'];
						
						$q = "INSERT INTO ". recAppTable ." (recOutpassId,recUsername,recOutDate,recOutTime,recInDate,recInTime,recPP,recPlace,recType,status,passCount) VALUES (?,?,?,?,?,?,?,?,?,0,?)";

						if($nrmt=$conn->prepare($q)){
							$outDate=$EXIT_DATE->format("Y-m-d");
							$inDate =$ENTERY_DATE->format("Y-m-d");
							$nrmt->bind_param("sssssssssd",$recOutpassId,$username,$outDate,$outTime,$inDate,$inTime,$purpose,$place,$type,$passCount);
							if($nrmt->execute()){
								$to = "";
								$q = "SELECT recEmail FROM ". recAdminTable ." WHERE recAdmin=1";
								$res = $conn->query($q);
								while($row=$res->fetch_assoc()){
									if($to!=""){
										$to.=", ";
									}
									$to .= $row['recEmail'];
								}

								$otpDetails = array();
								$otpDetails['recOutpassId'] = $recOutpassId;
								$app->setId($recOutpassId);
								$otpDetails['ExitDate'] = $outDate;
								$otpDetails['EnteryDate'] = $inDate;
								$otpDetails['ExitTime'] = $outTime;
								$otpDetails['EnteryTime'] = $inTime;
								$otpDetails['Type'] = $type;
								$otpDetails['purpose'] = $purpose;
								$otpDetails['place'] = $place;
								$otpDetails['FullUserName'] = $login_user->get_fullname();

								//sendMail($to,$otpDetails);
								sendMail($to,$app,$login_user);
								echo "success";
							}else{
								echo "failled";
							}
						}else
							echo "failled to prepare query.";
						$conn->close();
					}else{
						echo("Failled ! Entry time and exit time are same.");
					}
				}else{
					echo("Failled ! Exit date And Entery date must be same.");
				}
			}else{
				echo("Failled ! Exit date must be with in 5 days.");
			}
		}elseif($type==2){
			$currentDate = new DateTime("now");
			$dateIntervalFromCdate = date_diff($currentDate,$ENTERY_DATE);
			$dayFromCurrentDate = $dateIntervalFromCdate->format("%R%a");
			if($dayFromCurrentDate>=0&&$dayFromCurrentDate<=100){
				$day = (int)$dateInterval->format("%a");
				if(true){
					$h = (int)$dateInterval->format("%R%h");
					if($h>0){
						$username = $login_user->getUsername();

						$conn = new mysqli(dbHost,dbUser,dbPass);
						$conn->select_db(dbName);
						
						$array = generateOtpid($conn);
						$recOutpassId = $array['recOutpassId'];
						$passCount = $array['passCount'];
						
						$q = "INSERT INTO ". recAppTable ." (recOutpassId,recUsername,recOutDate,recOutTime,recInDate,recInTime,recPP,recPlace,recType,status,passCount) VALUES (?,?,?,?,?,?,?,?,?,0,?)";

						if($nrmt=$conn->prepare($q)){
							$outDate=$EXIT_DATE->format("Y-m-d");
							$inDate =$ENTERY_DATE->format("Y-m-d");
							$nrmt->bind_param("sssssssssd",$recOutpassId,$username,$outDate,$outTime,$inDate,$inTime,$purpose,$place,$type,$passCount);
							if($nrmt->execute()){
								$to = "";
								$q = "SELECT recEmail FROM ". recAdminTable ." WHERE recAdmin=1";
								$res = $conn->query($q);
								while($row=$res->fetch_assoc()){
									if($to!=""){
										$to.=", ";
									}
									$to .= $row['recEmail'];
								}

								$otpDetails = array();
								$otpDetails['recOutpassId'] = $recOutpassId;
								$app->setId($recOutpassId);
								$otpDetails['ExitDate'] = $outDate;
								$otpDetails['EnteryDate'] = $inDate;
								$otpDetails['ExitTime'] = $outTime;
								$otpDetails['EnteryTime'] = $inTime;
								$otpDetails['Type'] = $type;
								$otpDetails['purpose'] = $purpose;
								$otpDetails['place'] = $place;
								$otpDetails['FullUserName'] = $login_user->get_fullname();
								$m = sendMail($to,$app,$login_user);
								if($m)
									echo "success";
								else
									echo "Failled";
							}else{
								echo "failled";
							}
						}else
							echo "failled to prepare query.";
						$conn->close();
					}else{
						echo("Failled ! Entry time and exit time are same.");
					}
				}else{
					echo("Failled ! Exit date And Entery date must be same");
				}
			}else{
				echo("Failled ! Exit date must be with in 5 days.");
			}
		}
		else{
			echo("invalid");
		}
		
	}
	elseif($cmd=='oppref'){
		
	}
	else
		pageRedirect();
}elseif(isset($_GET['id'])){
	$id=$_GET['id'];
	$s="";
	if(isset($_GET['ky'])){
		$ky=$_GET['ky'];
		if(isset($_GET['c'])){
			$f = fopen(keyJson,"r");
			if(filesize(keyJson)>0)
				$s = fread($f,filesize(keyJson));
			else{
				exit();
			}
			fclose($f);
			if($s!=""){
				$s = json_decode($s,true);
				if(isset($s['id'.$id])&&$s["id".$id]==$ky){
					$conn = new mysqli(dbHost,dbUser,dbPass,dbName);
					$q = "SELECT recUsername from ".recAppTable." WHERE recOutpassId = ?";
					$nrmt = $conn->prepare($q);
					$nrmt->bind_param("s",$id);
					$nrmt->execute();
					$res = $nrmt->get_result();
					$nrmt->close();
					$row = $res->fetch_assoc();
					
					$q = "SELECT recEmail from ".recStudentsTable." WHERE recUsername = '".$row['recUsername']."'";
						
					$res = $conn->query($q);
					$row = $res->fetch_assoc();
					
					if($_GET['c']==1){
						
						$header = "content-type: text/html;";
						$msg = "<div>";
						$msg .= "Your application with application id = $id has been <span style='color: green; font-weight: bold;'>confirmed.</span>";
						$msg .= "</div>";
						
						if(mail($row['recEmail'],"Application Id $id",$msg,$header)==1){
							$q = "UPDATE recoutpass SET status = '1' WHERE recOutpassId = ?";
							$nrmt = $conn->prepare($q);
							$nrmt->bind_param("s",$id);
							$nrmt->execute();
							$nrmt->close();
							unset($s["id".$id]);
							$s=json_encode($s);
							$f=fopen(keyJson,"w");
							fwrite($f,$s);
							fclose($f);
							echo("<center><h1>Accepted Successfully.</h1></center>");
						}else{
							echo("<center><h1>Link.</h1></center>");
						}
						
					}
					elseif($_GET['c']=='-1'){
						$header = "content-type: text/html;";
						$msg = "<div>";
						$msg .= "Your application with application id = $id has been <span style='color: red; font-weight: bold;'>rejected.</span>";
						$msg .= "</div>";
						
						if(mail($row['recEmail'],"Application Id $id",$msg,$header)==1){
							$q = "UPDATE recoutpass SET status = '-1' WHERE recOutpassId = ?";
							$nrmt = $conn->prepare($q);
							$nrmt->bind_param("s",$id);
							$nrmt->execute();
							$nrmt->close();
							unset($s["id".$id]);
							$s=json_encode($s);
							$f=fopen(keyJson,"w");
							fwrite($f,$s);
							fclose($f);
							echo("<center><h1>Rejected Successfully.</h1></center>");
						}else{
							echo("<center><h1>Failled.</h1></center>");
						}
					}
					$conn->close();
				}
				else{
					echo("<center><h1>Request not Available.</h1></center>");
				}
			}
 		}
	}
}else{
	pageRedirect();
}

function generateOtpid($conn){
	$q = "SELECT * from ". recAppTable;
	$res = $conn->query($q);
	if($res->num_rows!=0){
		$q = "SELECT MAX(id) from ". recAppTable;
		$res = $conn->query($q);
		$row = $res->fetch_row();
		$maxPassCount = $row[0];

		$q = "SELECT recOutpassId from ". recAppTable ." WHERE id=$maxPassCount";
		$res = $conn->query($q);
		$row = $res->fetch_row();
		
		$r = (int) substr($row[0],0,6);
		$r0 = date('y').date('m').date('d');

		$q = "SELECT passCount from ". recAppTable ." WHERE id=$maxPassCount";
		$res = $conn->query($q);
		$row = $res->fetch_row();
		$passCount = $row[0];
		if($r<$r0){
			$passCount=1;
		}else{
			$passCount +=1;
		}
	}else{
		$passCount = 1;
	}
	if($passCount<10)
		$passCount="00".$passCount;
	elseif($passCount<100)
		$passCount="0".$passCount;

	$recOutpassId = date('y').date('m').date('d').$passCount;
	$array = array();
	$array['recOutpassId'] = $recOutpassId;
	$array['passCount'] = $passCount;
	return($array);
}

function sendMail($to,$array,$login_user){
	$val = '';
	for($i=0;$i<50;$i++){
		$val.=chr(rand(65,90));
	}
	
	$msg = "<html><div style='border: 3px solid royalblue; border-radius: 4px;'>";
	$msg .= "<div style='text-align: center; font-weight: bold; font-size: 30px;'>\n";
	$msg .= "Application ID : ".$array->getId();
	$msg .= "</div>";
	$msg .= "<table style='width:100%; box-shadow: 0px 0px 2px #bbb;'>\n";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #E7E5E5;'><td style='padding: 0px 10px;box-sizing: padding-box;'>Name :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".$login_user->get_fullname()."</td></tr>\n";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #FFFFFF'><td style='padding: 0px 10px;box-sizing: padding-box;'>Exit Date :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".dateFormat($array->getOutDate())."</td></tr>";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #E7E5E5;'><td style='padding: 0px 10px;box-sizing: padding-box;'>Exit Time :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".$array->getOutTime()."</td></tr>";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #FFFFFF;'><td style='padding: 0px 10px;box-sizing: padding-box;'>Entry Date :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".dateFormat($array->getInDate())."</td></tr>";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #E7E5E5;'><td style='padding: 0px 10px;box-sizing: padding-box;'>Entry Time :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".$array->getInTime()."</td></tr>";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #FFFFFF;'><td style='padding: 0px 10px;box-sizing: padding-box;'>Application Type :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".$array->getTypeStr()."</td></tr>\n";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #E7E5E5;'><td style='padding: 0px 10px;box-sizing: padding-box;'>Purpose :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".$array->getPurpose()."</td></tr>";
	$msg .= "<tr style='width:100%; box-shadow: 0px 0px 2px #bbb; background: #FFFFFF;'><td  style='padding: 0px 10px;box-sizing: padding-box;'>Place :</td><td style='padding: 0px 10px;box-sizing: padding-box;'>".$array->getPlace()."</td></tr>";
	$msg .="</table>";
	$msg .="<div style='text-align:center;'>";
	$msg .= "<a href='".host."/action.php?id=".$array->getId()."&ky=$val&c=1' style='text-align: center; display: inline-block;margin: 10px 20px;font-size: 20px;'>Accept</a>";
	$msg .= "<a href='".host."/action.php?id=".$array->getId()."&ky=$val&c=-1' style='text-align: center; display: inline-block;margin: 10px 20px;font-size: 20px;'>Reject</a>";
	$msg .="</div>";
	$msg .="<script>alert('fdfdf')</script>";
	$msg .="</div></html>";
	$header = "content-type: text/html;".PHP_EOL."from :".$login_user->get_fullname().";";
	$to="nrajpoot1146@gmail.com";
	$m=mail($to,"REC Banda Application Id : ".$array->getId(),$msg,$header);
	if($m){
		$s="";
		$f="";
		if($f=fopen(keyJson,"r+")){
			if(filesize(keyJson)>0)
				$s = fread($f,filesize(keyJson));
		}
		else{
			$f = fopen("key.JSON","w+");
		}
		if($s==""){
			$s= array();
		}
		else{
			$s = json_decode($s,true);
		}
		fclose($f);
		$f = fopen(keyJson,"w");
		$s["id".$array->getId()] = $val;
		$s=json_encode($s);
		fwrite($f,$s);
		fclose($f);
	}
	return($m);
}

?>