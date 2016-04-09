<?php
session_start();
if(isset($_SESSION['name'])){
	$_SESSION = array();
	session_destroy();
	echo "Logging out";
	header("location:welcome.php");
}
else{
	return false;
}
?>