<style>
	tr,table{
		width: 100%;
		box-shadow: 0px 0px 2px #bbb;
	}
	td,th{
		padding: 0px 10px;
		box-sizing: padding-box;
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
<?php
require_once('../include/session.php');

$conn = new mysqli(dbHost,dbUser,dbPass);
$conn->select_db(dbName);

$q = "SELECT * FROM ".recAppTable." WHERE recUsername= '".$login_user->getUsername()."'";
if($res=$conn->query($q)){
	if($res->num_rows>0){
		$i=1;
		echo("<table>");
		echo("<th>Sr No.</th><th>Outpass Id</th><th>Applied Date</th><th>Type</th><th>Status</th><th></th>");
		while($row=$res->fetch_assoc()){
			echo("<tr>");
			echo("<td style='text-align: center;'>$i</td><td style='text-align: center;'>".$row['recOutpassId']."</td><td style='text-align: center;'>".date_format(date_create($row['recAppliedDate']),"d/m/Y")."</td><td style='text-align: center;'>".$row['recType']."</td><td td style='text-align: center;'>".getStatus($row['status'])."</td><td style='text-align: center;'><a href='viewOtp.php?id=".$row['recOutpassId']."' target='_blank'>view</a></td>");
			echo("</tr>");
			$i++;
		}
		echo("</table>");
	}
}
?>
