<!DOCTYPE html>
<html>
<body>

<?php
$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die("Error connecting to MySQL server.");

if(isset($_POST['userid'])) {
	$userid = $_POST['userid'];

	$query = "DELETE FROM feedback WHERE userid = $userid";
	mysqli_query($dbc, $query);
}

mysqli_close($dbc);

?>

</body>
</html>