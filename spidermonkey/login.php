<?php
session_start();

mysql_connect("localhost","root","shantanu");
mysql_select_db("spidermonkey");
$username=$_REQUEST["username"];
$userpwd=$_REQUEST["pass"];
$query="select * from user where username = '$username' and userpwd= SHA('$userpwd')";
$result = mysql_query($query) or die(mysql_error());
$num = mysql_num_rows($result);
if($num==1){
   $row = mysql_fetch_array($result);
   $userid = $row['userid'];
   $name = $row['username'];
   $usercat = $row['usercat'];
   $mostpref = $row['mostprefcat']; 
   $_SESSION['name'] = $name;
   $_SESSION['uid'] = $userid;
   $_SESSION['usercat'] = $usercat;
   $_SESSION['mostprefcat'] = $mostpref;   
   header("location:ricomonkey.php");
}
else{
   header("location:welcome.php"); 
}
?>					