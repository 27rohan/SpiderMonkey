<!DOCTYPE html>
<html>
<body>

<?php

$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die("Error connecting to MySQL server.");

if(isset($_POST['addressValue'])) {

$addressValue = $_POST['addressValue'];
$userid = $_POST['userid'];
$time = time();
$preferred = '';
$bonus = 0.0000;
$incflag = false;

//Get URL's details
$querynow = "SELECT * FROM urltable WHERE url = '$addressValue'";
$result = mysqli_query($dbc, $querynow);
$row = mysqli_fetch_array($result);
$urlid = $row['urlid'];
$stacks = $row['stacks'];
$mstackstart = $row['mstackstart'];
$mstackend = $row['mstackend'];

//Record Hit
if($time > $mstackend) {

	if($stacks != 0) {
		$query = "UPDATE urltable SET stacks = 0 WHERE urlid = $urlid";
		mysqli_query($dbc, $query);
	}

	$query = "SELECT EXISTS (SELECT * FROM useridurlidmapper WHERE userid = $userid AND urlid = $urlid AND timeofhit > $mstackend)";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result);

	if($row[0] == 0) {
		$querynew = "INSERT INTO useridurlidmapper(userid, urlid, timeofhit) VALUES($userid, $urlid, $time)";
		mysqli_query($dbc, $querynew);
		$incflag = true;

		$query = "UPDATE urltable SET urlhits = urlhits+1 WHERE urlid = $urlid";
		mysqli_query($dbc, $query);
	}
	else {
		$query = "SELECT * FROM useridurlidmapper WHERE userid = $userid AND urlid = $urlid AND timeofhit > $mstackend ORDER BY timeofhit DESC";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($result);

		if($time - $row['timeofhit'] > 1500000) {
			$querynew = "INSERT INTO useridurlidmapper(userid, urlid, timeofhit) VALUES($userid, $urlid, $time)";
			mysqli_query($dbc, $querynew);
			$incflag = true;

			$query = "UPDATE urltable SET urlhits = urlhits+1 WHERE urlid = $urlid";
			mysqli_query($dbc, $query);
		}
	}
}
else if($mstackend == 999999999999999999) {
	$querynew = "INSERT INTO useridurlidmapper(userid, urlid, timeofhit) VALUES($userid, $urlid, $time)";
	mysqli_query($dbc, $querynew);
	$incflag = true;

	$query = "UPDATE urltable SET urlhits = urlhits+1, mstackend = $time WHERE urlid = $urlid";
	mysqli_query($dbc, $query);
}

if($stacks==1 && $time < $mstackend && $time > $mstackstart) {
	$query = "SELECT EXISTS (SELECT * FROM useridurlidmapper WHERE userid = $userid AND urlid = $urlid AND timeofhit BETWEEN $mstackstart+1000 AND $mstackend)";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result);

	if($row[0] == 0) {
		$querynew = "INSERT INTO useridurlidmapper(userid, urlid, timeofhit) VALUES($userid, $urlid, $time)";
		mysqli_query($dbc, $querynew);
		$incflag = true;
		
		$query = "UPDATE urltable SET urlhits = urlhits+1 WHERE urlid = $urlid";
		mysqli_query($dbc, $query);
	}
}

//Check Stacks
if($stacks == 0) {
	$timebracket = $time - 1500000;
	if($timebracket > $mstackend) {
		$query = "SELECT count(*) AS hitct FROM useridurlidmapper WHERE urlid = $urlid AND timeofhit BETWEEN $timebracket AND $time";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($result);
		if($row['hitct'] == 5) {
			$query = "UPDATE urltable SET stacks = stacks+1, mstackstart = $time, mstackend = $time+7500000, laststacktime = $time WHERE urlid = $urlid";
			mysqli_query($dbc, $query);
		}
	}
}

else {
	$query = "SELECT count(*) AS hitct FROM useridurlidmapper WHERE urlid = $urlid AND timeofhit BETWEEN $mstackstart+1 AND $mstackend";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result);
	$hitsincycle = $row['hitct'];
}

if($stacks == 1) {
	$bonus = 0.0005;
	if($hitsincycle == 5) {
		$query = "UPDATE urltable SET stacks = stacks+1, laststacktime = $time WHERE urlid = $urlid";
		mysqli_query($dbc, $query);
	}
}

if($stacks == 2) {
	$bonus = 0.0010;
	if($hitsincycle == 15) {
		$query = "UPDATE urltable SET stacks = stacks+1, laststacktime = $time WHERE urlid = $urlid";
		mysqli_query($dbc, $query);
	}
}

if($stacks == 3) {
	$bonus = 0.0015;
	if($hitsincycle == 25) {
		$query = "UPDATE urltable SET stacks = stacks+1, laststacktime = $time WHERE urlid = $urlid";
		mysqli_query($dbc, $query);
	}
}

if($stacks == 4) {
	$bonus = 0.0020;
	if($hitsincycle == 40) {
		$query = "UPDATE urltable SET stacks = stacks+1, laststacktime = $time WHERE urlid = $urlid";
		mysqli_query($dbc, $query);
	}
}

if($stacks == 5) {
	$bonus = 0.0025;
}

//Increase Rank
if($incflag == true) {
	$upheaval = 0.0025 + $bonus;
	$query = "UPDATE urltable SET urlrank = urlrank+$upheaval WHERE url = '$addressValue'";
	mysqli_query($dbc, $query);
}


//Set Most Preferred Category
$lastsubtime = 0;
$query = "SELECT * FROM feedbackpers WHERE userid = $userid AND mostpref = 0 ORDER BY timeofsub DESC LIMIT 1";
$result = mysqli_query($dbc, $query);
$noofsubs = mysqli_num_rows($result);

if($noofsubs != 0) {
	$row = mysqli_fetch_array($result);
	$lastsubtime = $row['timeofsub'];
}

$query = "CALL set_pref($userid, $lastsubtime)";
mysqli_query($dbc, $query);

$query = "SELECT cat, count(cat) AS ct FROM catprefs GROUP BY cat ORDER BY ct DESC LIMIT 1";
$result = mysqli_query($dbc, $query);

while($row = mysqli_fetch_array($result)) {
	if($row['ct']>=10){
		$preferred = $row['cat'];
		$query = "UPDATE user SET mostprefcat = $preferred WHERE userid = $userid";
		mysqli_query($dbc, $query);
	}
}

}

mysqli_close();
?>

</body>
</html>