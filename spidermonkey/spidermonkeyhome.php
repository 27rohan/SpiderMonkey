<!DOCTYPE html>

<?php
	require_once('login.php');
	?>
<body>

<?php
$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die('Error connecting to MySQL server.');

$cats = explode(',', $usercat);

foreach($cats as $cid)	{
	echo '<br />';

	$query = "SELECT cname FROM category WHERE cid = '$cid'";
	$result = mysqli_query($dbc, $query)
		or die('Error querying category table');
	$row = mysqli_fetch_array($result);
	echo '<br />' . $row['cname'] . '<br />';

	$query = "CALL get_rands(3,'$cid')";
	mysqli_query($dbc, $query);

	$query = "SELECT * FROM rands";
	$result = mysqli_query($dbc, $query)
		or die('Error selecting from rands table.');

	while($row = mysqli_fetch_array($result)) {
		echo $row['rand_id'] . "\t";
		if($row['rand_urltitle'] != "") {
			echo '<a href = ' . $row['rand_url'] . ' class = "addressClick" target = "_blank" onmousedown = "doSomething()">' . $row['rand_urltitle'] . '</a>' .
			' from ' . $row['rand_url'];
		}
		else {
			echo '<a href = ' . $row['rand_url'] . ' class = "addressClick" target = "_blank" onmousedown = "doSomething()">' . $row['rand_url'] . '</a>' . ' from ' . $row['rand_url'];
		}
	echo '<br />';
	}
}

echo '<br /><br /><br />';

mysqli_close($dbc);
?>

</body>

<script type="text/javascript" src="jquery-1.11.2.js"></script>
<script type="text/javascript">
$(document).ready(function doSomething() {
	$(".addressClick").on('mousedown', (function (event) {
        var addressValue = $(this).attr("href");
    	$.ajax({
    		url: 'hitrank.php',
    		data: {"addressValue" : addressValue},
    		type: 'post'
    	});
    console.log("This just ran.");
    return false;
//    event.stopPropagation();
    }));
});
</script>

</html>