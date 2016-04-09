<?php
mysql_connect("localhost","root","shantanu");
mysql_select_db("spidermonkey");
$temp=$_REQUEST["resp"];
if($temp=="name"){
	$username=$_REQUEST['name'];
	$query="select * from user where username ='$username'";
	$result = mysql_query($query) or die(mysql_error());
	$num = mysql_num_rows($result);
	if($num==0){ echo "Available"; return true;}
	else {echo "Already taken. Please try a different one."; return false;}
}
else if($temp=="email"){
	$useremail=$_REQUEST['email'];
	$query="select * from user where useremail ='$useremail'";
	$result = mysql_query($query) or die(mysql_error());
	$num = mysql_num_rows($result);
	if($num==0){ echo "Available"; return true;}
	else {echo "Already taken. Please try a different one."; return false;}
}
?>