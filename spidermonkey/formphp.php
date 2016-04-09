<html>
<body>
<?php

// Create connection
$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die("Error connecting to database.");

$satisfied= $_POST['satisfied'];
$popular= $_POST['popular'];
$tags= $_POST['tags'];
$new= $_POST['new'];

$sql = "INSERT INTO feedback (userid, satisfied, popular, tags, new) VALUES ($satisfied, $popular, $tags, $new)";

mysqli_query($dbc, $query)
	or die("Error querying database.");

mysqli_close($dbc);

?>

</body>
</html>
