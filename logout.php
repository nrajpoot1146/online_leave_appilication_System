<?php
require_once("include/config.php");
session_start();
if(isset($_SESSION['recUsername'])){
	session_unset();
	session_destroy();
}
header("location: ". host);
exit();
?>