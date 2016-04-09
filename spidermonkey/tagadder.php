<!DOCTYPE html>
<html>
<body>

<?php
$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die("Error connecting to MySQL server.");

if(isset($_POST['theurl'])) {

$urlValue = $_POST['theurl'];
$userid = $_POST['userid'];
$tag = $_POST['tag'];
$tagrel = 1.0000;
$taguptoo = 1;

$query = "SELECT * FROM urltable WHERE url = '$urlValue'";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
$urlid = $row['urlid'];

$query  = "SELECT tagid FROM tagtable WHERE tag = '$tag'";
$result = mysqli_query($dbc, $query);

if($row = mysqli_fetch_array($result)) {
	$tagid = $row['tagid'];
	echo 'Tag exists';
}

else {
	echo 'Tag does not exist';
	$query = "INSERT INTO tagtable(tag) VALUES('$tag')";
	
	mysqli_query($dbc, $query);
	$tagid = mysqli_insert_id($dbc);
	
}

$query = "SELECT EXISTS (SELECT * FROM urlidtagidmapper WHERE urlid = $urlid AND tagid = $tagid);";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
if($row[0] == 0) {
	$taguptoo = 0;
}


$query = "SELECT EXISTS (SELECT * FROM urlidtagidmapper WHERE urlid = $urlid AND tagid = $tagid AND userid = $userid);";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);

if($row[0] == 0) {
	$query = "SELECT * FROM urlidtagidmapper WHERE urlid = $urlid AND tagid = $tagid";
	$result = mysqli_query($dbc, $query);

	if($newrow = mysqli_fetch_array($result)) {
		$tagrel = $newrow[tagrel];
	}

	$query = "INSERT INTO urlidtagidmapper(urlid, tagid, userid, tagrel) VALUES($urlid, $tagid, $userid, $tagrel)";
	mysqli_query($dbc, $query);

	if($taguptoo == 1) {
		$query = "UPDATE urlidtagidmapper SET tagrel = tagrel+0.0025 WHERE urlid = $urlid AND tagid = $tagid";
		mysqli_query($dbc, $query);
	}
}

}

mysqli_close($dbc);

?>

</body>
</html>