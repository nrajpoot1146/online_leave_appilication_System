<?php

define("LEAVE_APPLICATION",2);
define("OUT_PASS",1);

class ClassApplication{
	public $purpose;
	public $place;
	public $type;
	public $outDate;
	public $outTime;
	public $EXIT_DATE;
	public $inDate;
	public $inTime;
	public $id;
	
	function ClassApplication($array){
		$this->purpose = $_POST['recPurpose'];
		$this->place = $_POST['recPlace'];
		$this->type = $_POST['recType'];
		
		$this->outDate = $_POST['recOutDate'];
		$this->outTime = $_POST['recOutTime'];
		$this->EXIT_DATE = date_create($this->outDate." ".$this->outTime);
			
		$this->inDate  = $_POST['recInDate'];
		$this->inTime  = $_POST['recInTime'];
	}
	
	public function getTypeStr(){
		if($this->type==OUT_PASS){
			return("Outpass");
		}
		return("Leave Application");
	}
	public function getType(){
		return($this->type);
	}
	public function getPurpose(){
		return($this->purpose);
	}
	public function getPlace(){
		return($this->place);
	}
	public function getOutDate(){
		return($this->outDate);
	}
	public function getOutTime(){
		return($this->outTime);
	}
	public function getInDate(){
		return($this->inDate);
	}
	public function getInTime(){
		return($this->inTime);
	}
	public function getExitDate(){
		return($this->EXIT_DATE);
	}
	public function getArray(){
		
	}
	public function setId($str){
		$this->id = $str;
	}
	public function getId(){
		return($this->id);
	}
}
?>