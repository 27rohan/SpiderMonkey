<!DOCTYPE html>
<html>
<body>

<?php

$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die("Error connecting to MySQL server.");

if(isset($_POST['addressShare'])) {

$addressValue = $_POST['addressShare'];
$userid = $_POST['userid'];

$querynow = "SELECT * FROM urltable WHERE url = '$addressValue'";
$result = mysqli_query($dbc, $querynow);
$row = mysqli_fetch_array($result);
$urlid = $row['urlid'];
$urlcat = $row['urlcat'];

$query = "SELECT * FROM shared_url WHERE urlid = $urlid AND userid = $userid";
$result = mysqli_query($dbc, $query);

if(mysqli_fetch_array($result) == false) {

	$query = "UPDATE urltable SET urlshares = urlshares+1 WHERE url = '$addressValue'";
	mysqli_query($dbc, $query);

	$query = "INSERT INTO shared_url(urlid, urlcat, userid) VALUES($urlid, '$urlcat', $userid)";
	mysqli_query($dbc, $query);

}

}

mysqli_close($dbc);

?>

</body>
</html>