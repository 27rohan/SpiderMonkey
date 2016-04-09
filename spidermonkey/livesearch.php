<?php
//get the q parameter from URL
$q=$_GET["q"];
$dbc=mysqli_connect("localhost","root","shantanu","spidermonkey");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$hint="";
// escape variables for security
$result = mysqli_query($dbc,"SELECT * FROM tagtable where tag like '%$q%' order by tagid");
while($row = mysqli_fetch_array($result)) {
	$tag = $row['tag'];
	$tagid = $row['tagid'];
	$hint = "<a href= 'searchbytag.php' ><td>" . $tag . "</a></td><br>";
}
// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint=="") {
  $response="No suggestion";
} else {
  $response=$hint;
}
//output the response
echo $response;
mysqli_close($dbc);
?>
