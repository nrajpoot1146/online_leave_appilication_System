<?php
 class recUser{
	public $fName;
	private $mName;
	private $lName;
	private $dob;
	function recUser(){
		echo $this->fName;
	}
};

class student extends recUser{
	function student(){
		$t=new recUser::recUser();
		$t->fName = "fff";
		echo("vvv");
	}
};

$n = new student();
?>