$(document).ready(function(){
	
	//"use strict";
	frmCenter($(".admin-dash-item-text"),0,0)
	var wb=new waitBox("#lock-display","#wait-box");
	setContainerHeight();
	
	$(window).on('resize',function(){
		setContainerHeight();
		//blkCenter($("#wait-box"));
	});
	
	function setContainerHeight(){
		$('#container').css("min-height",$(window).height()+"px");
		
		$('section').css("min-height",($(window).height()-$('header').outerHeight()-	$('nav').outerHeight()-$('footer').outerHeight())+"px");
		
		$('.dashboard').css("margin",(($('section').innerHeight()-$('.dashboard').outerHeight())/2)+"px "+"auto");
		//$(".dashboard").css("margin","100px auto");
	}
	//navigation menu bar listener--starting
	var navClick = function(event){
		window.location=event.data.url+'?c='+$(event.target).attr("href");
		event.preventDefault();
	};
	$('nav a').click({"url":"index.php"},navClick);
	//navigation menu bar listener--ending
	
	//outpass dash item listener-- starting
	$('#app-dash .dash-item').click({"url":"out_app.php"},navClick);
	$('.aside-item').click({"url":"out_app.php"},navClick);
	//outpss dash item listener--ending
	
	//login form and registration form area. starting
	$('#login-form-btn').click(function(){
		$("#login-form").fadeIn('slow');
		$("#reg-form").hide();
		$(this).css("background","#273746");
		$("#reg-form-btn").css("background","#707b7c");
	});
	$("#reg-form-btn").click(function(){
		$("#login-form").hide();
		$("#reg-form").fadeIn('slow');
		$('#login-form-btn').css("background","#707b7c");
		$(this).css("background","#273746");
	});
	
	$("#login-form input[type=checkbox]").click(function(event){
		if($(event.target).is(":checked")){
			$("#login-form input[name=pass]").attr("type","text");
		}else{
			$("#login-form input[name=pass]").attr("type","password");
		}
	});
	
	//submission of login form
	$("#login-form form:first").submit(function(event){
		var n = $("#login-form form:first");
		var frmData = {
			'username'	:	n.children("input[name=username]").val(),
			'pass'		:	n.children("input[name=pass]").val(),
			'ajax'		:	true
		};
		wb.waitShow();
		$.ajax({
			type	:	'POST',
			url		:	'login.php',
			data	:	frmData,
			//dataType:	'json',
			encode	:	true,
			success	:	function(resText){
				wb.waitHide();
				resText = JSON.parse(resText);
				if(resText.status === true){
					window.location = resText.responce;
				}
				if(resText.status === false){
					$("#login-err").text(resText.responce);
				}
			}
		});
		event.preventDefault();
	});
	
	//submission of registration form.
	$("#reg-form form:first").submit(function(event){
		var n=$(event.target);
		var frmData = {
			'username'	:	n.children("input[name=username]").val(),
			'firstname'	:	n.children("input[name=firstname]").val(),
			'lastname'	:	n.children("input[name=lastname]").val(),
			'gender'	:	n.children("input[name=gender]:checked").val(),
			'dob'		:	n.children("input[name=dob]").val(),
			'mobnumber'	:	n.children("input[name=mobnumber]").val(),
			'rollno'	:	n.children("input[name=rollno]").val(),
			'email'		:	n.children("input[name=email]").val(),
			'year'		:	n.children('div').children("select[name=year]").val(),
			'branch'	:	n.children('div').children("select[name=branch]").val(),
			
			'block'		:	n.children("select[name=block]").val(),
			'floor'		:	n.children("select[name=floor]").val(),
			'roomno'	:	n.children("select[name=roomno]").val(),
			
			'password'	:	n.children("input[name=password]").val(),
			'ajax'		:	true
		};
		wb.waitShow();
		$.ajax({
			type	:	'POST',
			url		:	'index.php',
			data	:	frmData,
			//dataType:	'json',
			encode	:	true,
			success	:	function(resText){
				wb.waitHide();
				resText = JSON.parse(resText);
				if(resText.status === true){
					 wb.showText(resText.responce);
				}
				if(resText.status === false){
					wb.showText(resText.responce);
				}
			}
		});
		event.preventDefault();
	});
	//login form and registration form area. ending
	
	//define a waitting animation and responce text area starting
	function waitBox(x,y){
		x=$(x);
		y=$(y);
		x.hide();
		y.hide();
		blkCenter(y);
		var wait_box = y;
		var wait_img = y.children("img");
		var wait_text = y.children("div").children("span");
		var wait_button = y.children("div").children("button");
		wait_button.hide();
		
		wait_button.click(function(){
			$("body").css({
				"overflow" : "auto"
			});
			x.hide();
			y.hide();
		});
		x.css({
			"position"	:	"fixed",
			"top"		:	"0px",
			"left"		:	"0px",
			"width"		:	"100%",
			"height"	:	"100%",
			"background":	"#bbb",
			"opacity"	:	".5",
		});
		wait_box.css({
			"text-align" : "center"
		});
		this.waitShow = function(){
			$("body").css({
				"overflow" : "hidden"
			});
			wait_box.css({
				"background": "none",
				"box-shadow": "0px 0px 0px",
				"width"	:"auto",
				"height":"auto"
			});
			wait_img.show();
			wait_text.hide();
			wait_button.hide();
			x.show();
			y.show();
		};
		this.waitHide = function(){
			$("body").css({
				"overflow" : "auto"
			});
			x.hide();
			y.hide();
			wait_img.hide();
			wait_text.hide();
			wait_button.hide();
		};
		this.showText = function(txt){
			$("body").css({
				"overflow" : "hidden"
			});
			wait_box.css({
				"background": "white",
				"box-shadow": "0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)",
				"width"	:"200px",
				"height":"auto",
				"border-radius":"2px"
			});
			wait_img.hide();
			wait_text.html(txt);
			wait_text.show();
			wait_button.show();
			x.show();
			y.show();
		};
	}
	//define a waitting animation and responce text area ending
	
	//Outpass and leave appliaction starting
	$("#outpass").ready(function(){
		var nr_constant ={REC_OUTPASS:0,REC_PROFILE:2,SUBMIT_OUTPASS:10,SUBMIT_LEAVE_APPLICATION:11};
		var nrApp = new nr_app();
		nrApp.js();

		//Morning time limit
		
		//$.getJSON()
		var mt_limit = {
			min_time_h : '06',
			min_time_m : '00',
			max_time_h : '04',
			max_time_m : '59'
		};
		//Evening time limit
		var et_limit = {
			min_time_h : '06',
			min_time_m : '00',
			max_time_h : '',
			max_time_m : '00'
		};
		function nr_app(){
			var nr_otp_app = document.getElementById('otp_app');				//instance for outpaas
			var nr_leave_app = document.getElementById('lv_app');				//instance for leave application
			var nr_outTime_h = document.getElementsByName('outtime_h')[0];		//instance for hour of out time
			var nr_outTime_m = document.getElementsByName('outtime_m')[0];		//instance minutes of out time
			var nr_outTime_ap = document.getElementsByName('outtime_ap')[0];	//instance for AM & PM of out time
			var nr_inTime_h = document.getElementsByName('intime_h')[0];		//instance for hour of in time
			var nr_inTime_m = document.getElementsByName('intime_m')[0];		//instance for minutes of in time
			var nr_inTime_ap = document.getElementsByName('intime_ap')[0];		//instance for AM & PM of in time

			this.js = function(){
		
				$('#otp_app').change(this.nrOtpChecked);			//attach an eventListener to outpaas radio button
				$('#lv_app').change(this.nrLeaveChecked);			//attach an eventListener to leave application button
		
				$("#outpass form:first").submit(function(n){
					var frmData = {
						"t"				:	nr_constant.SUBMIT_OUTPASS,
				
						"recOutDate"	:	$("[name=outdate]").val(),
						"recOutTime"	:	$("[name=outtime_h]").val()+":"+$("[name=outtime_m]").val(),
						"recOutTime_h"	:	$("[name=outtime_h]").val(),
						"recOutTime_m"	:	$("[name=outtime_m]").val(),
						"recOutTime_ap"	:	$("[name=outtime_ap]").val(),
				
						"recInDate"		:	$("[name=indate]").val(),
						"recInTime"		:	$("[name=intime_h]").val()+":"+$("[name=intime_m]").val(),
						"recInTime_h"	:	$("[name=intime_h]").val(),
						"recInTime_m"	:	$("[name=intime_m]").val(),
						"recInTime_ap"	:	$("[name=intime_ap]").val(),
				
						"recPurpose"	:	$("[name=pps_of_leave]").val(),
						"recPlace"		:	$("[name=add_during_leave]").val(),
				
						"recType"		:	$("[name=app_type]:checked").val()
					};
					wb.waitShow();
					$.ajax({
						type	:	'post',
						url		:	'../action.php',
						data	:	frmData,
						encode	:	true,
						success	:	function(n){
							wb.waitHide();
							wb.showText(n);
						}
					});
					n.preventDefault();
				});
		
				$('[name=pps_of_leave]').focusout(function(){
					$('#nr-pps err').load('action.php','');
				});
		
				if(nr_otp_app.checked){
					this.nrOtpChecked();
				}else if(nr_leave_app.checked){
					this.nrLeaveChecked();
				}
			};
	
			this.nrOtpChecked = function(){
				var frmdata = {
					"t" : ""
				};
				$.ajax();
				appendChildNode('outtime_h',6,16,false);
				appendChildNode('intime_h',6,19,false);
		
				$('#nr-pps span:first-child').text('Purpose of Outpaass :');
				$('#nr-place span:first-child').text('Place (i.e. Atarra,Banda) :');
				$('#inouttime center:first-child').text('Duration of outpaass :');
		
				nr_outTime_h.addEventListener('change',nrOutTime_h_listener);		//attach an eventListener to hour of out time
				//nr_outTime_ap.addEventListener('change',nrOutTime_ap_listener);		//attach an eventListener to AM|PM of out time
				nr_inTime_h.addEventListener('change',nrInTime_h_listener);			//attach an eventListener to hour of in time
				//nr_inTime_ap.addEventListener('change',nrInTime_ap_listener);		//attach an eventListener to AM/PM of in time
		
				$("[name=outdate]").change(cntToOutdate);
				$("[name=indate]").change(cntToIndate);
		
				//nrOutTime_ap_listener();
				//nrInTime_ap_listener();
			};
	
			//Event Listener function for date of outtime when outpaas filling
			//this function connect date of intime to date of outtime
			var cntToOutdate = function(){
				$("[name=indate]").val($("[name=outdate]").val());
			};
	
			//Event Listener function for date of intime when outpaas filling
			//this function connect date of outtime to date of intime
			var cntToIndate = function(){
				$('[name=outdate]').val($('[name=indate]').val());
			};
	
			//this function is attach to leave application button 
			this.nrLeaveChecked = function(){
				$('#nr-pps span:first-child').text('Purpose of Leave :');
				$('#nr-place span:first-child').text('Address During Leave : ');
				$('#inouttime center:first-child').text('Duration of Leave :');
		
				$("[name=outdate]").unbind('change',cntToOutdate);
				$("[name=indate]").unbind('change',cntToIndate);
		
				nr_outTime_h.removeEventListener('change',nrOutTime_h_listener);
				nr_outTime_ap.removeEventListener('change',nrOutTime_ap_listener);
				appendChildNode('outtime_h',0,23,false);
				appendChildNode('intime_h',0,23,false);
				//nrOutTime_ap_listener();
				//nrInTime_ap_listener();
			};
	
			var nrOutTime_ap_listener = function(){
				this.nr_outTime_h_value = nr_outTime_h.options[nr_outTime_h.selectedIndex].value;
				this.nr_outTime_ap_value = nr_outTime_ap.options[nr_outTime_ap.selectedIndex].value;
		
				if(this.nr_outTime_h_value ==='04' && this.nr_outTime_ap_value==='PM' && nr_otp_app.checked){
					appendChildNode('outtime_h',1,4,false);
					appendChildNode('outtime_m',0,30,false);
				}
				else if(this.nr_outTime_ap_value === 'AM' && nr_otp_app.checked){
					appendChildNode('outtime_h',6,11,false);
					appendChildNode('outtime_m',0,59,false);
				}
				else if(this.nr_outTime_ap_value === 'PM' && nr_otp_app.checked){
					appendChildNode('outtime_h',12,16,true);
				}
				else{
					appendChildNode('outtime_h',1,12,false);
					appendChildNode('outtime_m',0,59,false);
				}
			};
	
			var nrOutTime_h_listener = function(){
				this.nr_outTime_h_value = nr_outTime_h.options[nr_outTime_h.selectedIndex].value;
				this.nr_outTime_ap_value = nr_outTime_ap.options[nr_outTime_ap.selectedIndex].value;
		
				if(this.nr_outTime_h_value ==='04' && this.nr_outTime_ap_value==='PM' && nr_otp_app.checked){
				appendChildNode('outtime_m',0,30,false);
				}
			};
			var nrInTime_ap_listener = function(){
				this.nr_InTime_h_value = nr_inTime_h.options[nr_inTime_h.selectedIndex].value;
				this.nr_InTime_ap_value = nr_inTime_ap.options[nr_inTime_ap.selectedIndex].value;
		
				if(this.nr_InTime_h_value ==='06' && this.nr_InTime_ap_value==='PM' && nr_otp_app.checked){
					appendChildNode('intime_h',12,18,true);
					appendChildNode('intime_m',0,30,false);
				}
				else if(this.nr_InTime_ap_value === 'AM' && nr_otp_app.checked){
					appendChildNode('intime_h',6,11,false);
					appendChildNode('intime_m',0,59,false);
				}
				else if(this.nr_InTime_ap_value === 'PM' && nr_otp_app.checked){
					appendChildNode('intime_h',12,18,true);
				}
				else{
					appendChildNode('intime_h',1,12,false);
					appendChildNode('intime_m',0,59,false);
				}
			};
	
			var nrInTime_h_listener = function(){
				this.nr_outTime_h_value = nr_outTime_h.options[nr_outTime_h.selectedIndex].value;
				this.nr_outTime_ap_value = nr_outTime_ap.options[nr_outTime_ap.selectedIndex].value;
		
				if(this.nr_outTime_h_value ==='04' && this.nr_outTime_ap_value==='PM' && nr_otp_app.checked){
					appendChildNode('outtime_m',0,30,false);
				}
			};

			var appendChildNode = function(parent_name,min_value,max_value,flag){
				var temp = document.getElementsByName(parent_name)[0];
				temp.innerHTML = '';
				for(var i = min_value; i <= max_value; i++){
					var j =i;
					if(flag ===true && j !==12){
						j = j%12;
					}
					var op = document.createElement('option');
					if(j<10){
						j = '0' + j;
					}
					op.setAttribute('value',j);
					var op_node = document.createTextNode(j);
					op.appendChild(op_node);
					temp.appendChild(op);
				}
			};
		}
	});
	//Outpass and leave appliaction ending
	
	//function for centralize any element with position absolute;
	function frmCenter(n,lOffset,tOffset){	
		n.css("position","absolute");
		n.css("top",Math.max(0,(n.parent().height()-n.outerHeight())/2)+($(window).scrollTop())+tOffset+"px");
		n.css("left",Math.max(0,(n.parent().width()-n.outerWidth())/2)+($(window).scrollLeft())+lOffset+"px");
	}
	
	function blkCenter(n){
		n.css("position","fixed");
		n.css("top",Math.max(0,($(window).height()-n.outerHeight())/2)+"px");
		n.css("left",Math.max(0,($(window).width()-n.outerWidth())/2)+"px");
	}
});