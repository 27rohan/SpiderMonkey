<?php
session_start();

$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey');


$catarr = $_POST['cat'];
$useremail=$_POST["email"];
$userpwd=$_POST["pass"];
$username=$_POST["name"];

if(empty($catarr)) {
	echo "Catarr is empty.";
}

$usercat = implode(',', $catarr);

//insert info into user
$query="INSERT INTO user(username, useremail, userpwd, usercat) VALUES ('$username','$useremail', SHA('$userpwd'), '$usercat')";
mysqli_query($dbc, $query) or die("Error inserting.");

$query="SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($dbc, $query) or die("Error selecting.");
if(mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	$userid = $row['userid'];
	$name = $row['username'];
	$usercat = $row['usercat'];
	$mostpref = $row['mostprefcat']; 
	$_SESSION['name'] = $name;
	$_SESSION['uid'] = $userid;
	$_SESSION['usercat'] = $usercat;
	$_SESSION['mostprefcat'] = $mostpref;
}


header("location:ricomonkey.php");
?>					