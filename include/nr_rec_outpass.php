<div id='outpass'>
	<div id='outpass-heading'>
		<span style='font-weight: bold;'>LEAVE/OUTPAASS APPLICATION</span>
	</div>
	
	<form method='post'>
		<center>
			<span>Choose application type</span><br>
			<input id="otp_app" name="app_type" type="radio" value='1' checked /> Outpaas
			<input id="lv_app" name="app_type" type="radio" value='2'/> Leave Application
		</center>
		
		<table id="student-details">
			<tr class="nr-inline-block">
				<td>Name :</td>
				<td><input type="text" value="<?php echo $login_user->get_fullname(); ?>" disabled/></td>
			</tr>
			<tr class="nr-inline-block">
				<td>Roll No :</td>
				<td><input type="text" value="<?php echo $login_user->get_rollno(); ?>" disabled/></td>
			</tr>
			<tr class="nr-inline-block">
				<td>Year :</td>
				<td><input type="text" value="<?php echo $login_user->get_year(); ?>" disabled/></td>
			</tr>
			<tr class="nr-inline-block">
				<td>Branch :</td>
				<td><input type="text" value="<?php echo $login_user->get_branch(); ?>" disabled/></td>
			</tr>
			<tr class="nr-inline-block">
				<td>Mobile No. :</td>
				<td><input type="text" value="<?php echo $login_user->get_mobile_no(); ?>" disabled/></td>
			</tr>
			<tr class="nr-inline-block">
				<td>Room no.</td>
				<td><input type="text" value="<?php echo $login_user->get_FRoomno(); ?>" disabled/></td>
			</tr>
		</table>
		
		<div id="inouttime">
			<center style="margin: 20px 0px 0px 0px; font-weight: 600; font-size: 18px;">Duration of outpaas :</center>
			
			<span>From :</span>
			<div id='outtime'>
				<span>Date :</span>
				<input type="date" name="outdate" />
				<span>Time :</span>
				<select name='outtime_h'>
					<option value='01'>01</option>
					<option value='02'>02</option>
					<option value='03'>03</option>
					<option value='04'>04</option>
					<option value='05'>05</option>
					<option value='06'>06</option>
					<option value='07'>07</option>
					<option value='08'>08</option>
					<option value='09'>09</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
				</select><b> : </b>
				<select name='outtime_m'>
					<?php 
					for($i=0;$i<60;$i++){
						if($i<10)
							$tmp = '0'.$i;
						else
							$tmp = $i;
						echo "<option value='$tmp'>$tmp</option>";
					}
					?>
				</select>
				<select name='outtime_ap' disabled style="display: none;">
					<option value='AM'>AM</option>
					<option value='PM'>PM</option>
				</select>
			</div>
			
			<span>To :</span>
			<div id='intime'>
			
				<span>Date :</span>
				<input type='date' name='indate' />
			
				<span>Time :</span>
				<select name='intime_h'>
					
				</select><b> : </b>
				<select name='intime_m'>
					<?php 
					for($i=0;$i<60;$i++){
						if($i<10)
							$tmp = '0'.$i;
						else
							$tmp = $i;
						echo "<option value='$tmp'>$tmp</option>";
					}
					?>
				
				</select>
				<select name='intime_ap' style="display: none;" disabled>
					<option value='AM'>AM</option>
					<option value='PM'>PM</option>
				</select>
			</div>
		</div>
		
		<div>
			<span>Visit :</span>
			<select name="place_type">
				<option>Outstaion</option>
				<option>Local</option>
			</select>
		</div>
		
		<div id="nr-pps">
			<span>Purpose of Outpaas :</span><br>
			<textarea name="pps_of_leave"></textarea>
			<err class="err"></err>
		</div>
		
		<div id="nr-place">
			<span>Place (i.e. Atarra,Banda) :</span><br>
			<textarea name="add_during_leave"></textarea>
			<err class="err"></err>
		</div>
		<br>
		<center><button type='submit'>Submit</button></center>
	</form>	
</div>