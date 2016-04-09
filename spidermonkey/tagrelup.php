<!DOCTYPE html>
<html>
<body>
<?php

$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die("Error connecting to database.");

if(isset($_POST['addressValue'])) {

$urlid = $_POST['addressValue'];
$userid = $_POST['userid'];
$tag = $_POST['tag'];

$query = "SELECT * FROM tagtable WHERE tag = '$tag'";
$result = mysqli_query($dbc, $query)
	or die("Error querying tagtable.");
$row = mysqli_fetch_array($result);
$tagid = $row['tagid'];

$query = "SELECT EXISTS (SELECT * FROM tagrelrecord WHERE userid = $userid AND urlid = $urlid AND tagid = $tagid AND tagresp = 1)";
$result = mysqli_query($dbc, $query)
	or die("Error querying tagrelrecord");
$row = mysqli_fetch_array($result);
$prevsub = $row[0];

if($prevsub == 0) {
	$query = "SELECT EXISTS (SELECT * FROM tagrelrecord WHERE userid = $userid AND urlid = $urlid AND tagid = $tagid AND tagresp = 0)";
	$result = mysqli_query($dbc, $query)
		or die("Error querying tagrelrecord");
	$row = mysqli_fetch_array($result);
	$alternatesub = $row[0];

	if($alternatesub == 1) {
		$query = "UPDATE urlidtagidmapper SET tagrel = tagrel+0.0025 WHERE urlid = $urlid AND tagid = $tagid";
		mysqli_query($dbc, $query);

		$query = "DELETE FROM tagrelrecord WHERE userid = $userid AND urlid = $urlid AND tagid = $tagid AND tagresp = 0";
		mysqli_query($dbc, $query);
	}

	$query = "INSERT INTO tagrelrecord(userid, urlid, tagid, tagresp) VALUES($userid, $urlid, $tagid, 1)";
	mysqli_query($dbc, $query)
		or die("Error inserting into tagrelrecord.");

	$query = "UPDATE urlidtagidmapper SET tagrel = tagrel+0.0025 WHERE urlid = $urlid AND tagid = $tagid";
	mysqli_query($dbc, $query);
}

mysqli_close($dbc);

}
?>
</body>
</html>