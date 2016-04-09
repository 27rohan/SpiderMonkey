<!DOCTYPE html>
<?php
session_start();

if(!isset($_SESSION['name'])) {
  header("Location: welcome.php");
}

$username = $_SESSION['name'];
$cats = explode(',', $_SESSION['usercat']);
$uid = $_SESSION['uid'];
$mostprefcat = $_SESSION['mostprefcat'];

?>
<html>
<head>


<meta charset="utf-8" />

<script type="text/javascript" src="jquery-1.11.2.js"></script>
        <link rel="stylesheet" href="sourcexsrt/sourcexsrt/css/style.css" />
		<!-- link rel="stylesheet" href="sourcexsrt/sourcexsrt/css/nivo-slider.css" type="text/css" media="screen" / -->
		<link rel="stylesheet" href="sourcexsrt/sourcexsrt/css/default/default.css" type="text/css" media="screen" />
	<!--	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="sourcexsrt/sourcexsrt/jquery.nivo.slider.pack.js" type="text/javascript"></script>
        <[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->


<script src="jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>

<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css" />

<style>
.js .tagform {
  display:none;
}
</style>

<title>RicoMonkey Feedback</title>
</head>
    

<body id="home">
<div id="wrapper">

<header>
<div id="logo">
<h1>RICOMONKEY<span id="iisrt"><span id="ii">II</span>  <span id="srt"></span></span></h1>
<div id="tagline">
	<h2>Ricochet!</h2>
</div>
</div>

<div>
<?php

echo '<br /><p align="right">Hi ' . $username . ' !</p>';

?>
<p align="right" class="searchp" style="cursor:pointer;" onclick="logout()"> SIGN OUT </p>
</div>

<nav>
<ul>
<li class="button"><a href="ricomonkey.php">RICOCHET</a></li>
<li class="button"><a href="persrec.php">PERSONAL</a></li>
<li class="button"><a href="popbyrank.php">MOST POPULAR</a></li>
<li class="button"><a href="activity.php">ACTIVITY</a></li>
<li class="button"><a href="index.html">SEARCH BY TAG</a></li>
<li class="button"><a href="searchtitle.php">SEARCH BY TITLE</a></li>
<li class="button"><a href="feedback.php">SUBMIT FEEDBACK</a></li>
</ul>
</nav>

</header>
<br><br> 

<!-- Insert in this section -->

<section>

<?php

$time = time();

// Create connection
$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
	or die("Error connecting to database.");

$satisfied = '';
$popular = '';
$tags = '';
$new = '';

if(isset($_POST['submitfeedback'])) {

	if(isset($_POST['satisfied']) && isset($_POST['popular']) && isset($_POST['tags']) && isset($_POST['new'])) {
		$satisfied= $_POST['satisfied'];
		$popular= $_POST['popular'];
		$tags= $_POST['tags'];
		$new= $_POST['new'];
	}

	$output_form = false;

	if($satisfied == ''  || $popular == '' || $tags == '' || $new == '') {
		echo '<p>Please answer all questions.</p><br />';
		$output_form = true;
	}

	else {

		$sql = "INSERT INTO feedback (userid, satisfied, popular, tags, new) VALUES ($uid, $satisfied, $popular, $tags, $new)";

		mysqli_query($dbc, $sql)
			or die("Error querying database.");

		echo '<br /><p>Thank you for submitting your response!</p><br />';

		echo '<a href="javascript:void(0)" class="anotherresp" onclick="newResp(' . $uid . ');">Submit another response</a>';

	}
}

else {
	$query = "SELECT EXISTS (SELECT * FROM feedback WHERE userid = $uid)";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result);
	$check = $row[0];

	if($check == 1) {
		$output_form = false;
		echo '<br /><p>You have already submitted your feedback.</p><br />';

		echo '<a href="javascript:void(0)" class="anotherresp" onclick="newResp(' . $uid . ');">Submit another response</a><br />';

		
	}
	else {
		$output_form = true;
	}
}

echo '<br /><br />';

$persrec = '';
$mostpref = '';

if(isset($_POST['recfeedback'])) {

	if(isset($_POST['persrec']) && isset($_POST['mostpref'])) {
		$persrec= $_POST['persrec'];
		$mostpref= $_POST['mostpref'];
	}

	$output_form_pers = false;

	if($persrec == ''  || $mostpref == '') {
		echo '<p>Please answer all questions.</p><br />';
		$output_form_pers = true;
	}

	else {
		$sql = "INSERT INTO feedbackpers(userid, persrec, mostpref, timeofsub) VALUES($uid, $persrec, $mostpref, $time)";
		mysqli_query($dbc, $sql)
			or die("Error recording personal feedback.");

		if($mostpref == 0) {
			$query = "UPDATE user SET mostprefcat = NULL WHERE userid = $uid";
			mysqli_query($dbc, $query)
				or die("Error erasing mostprefcat.");
		}

		echo '<br /><p>Thank you for helping us improve! <a href="feedback.php">You can submit this feedback multiple times.</a></p><br />';

		$output_form_pers = false;
	}
	
}

else {
	$output_form_pers = true;
}

if($output_form == true) {

?>

<br />
<form action="feedback.php" method="post">
Are you satisfied with the recommendations?
<br><label for="satisfied">Yes </label><input type="radio" name="satisfied" value="1" >
<br><label for="satisfied">No </label><input type="radio" name="satisfied" value="0">
<hr>
Have popular pages correctly been recommended?
<br><label for="popular">Yes </label><input type="radio" name="popular" value="1" >
<br><label for="popular">No </label><input type="radio" name="popular" value="0">
<hr>
Are tags being appropriately assigned?
<br><label for="tags">Yes </label><input type="radio" name="tags" value="1" >
<br><label for="tags">No </label><input type="radio" name="tags" value="0">
<hr>
Did you discover new web pages?
<br><label for="new">Yes </label><input type="radio" name="new" value="1" >
<br><label for="new">No </label><input type="radio" name="new" value="0">
<hr>
<br />
<button type='submit' name='submitfeedback'>Submit</button>
</form>

<?php
}

if($output_form_pers == true) {

?> 

<br />

<h1>Help us improve, for you!</h1>
<form action="feedback.php" method="post">
<hr>
Are the personalized recommendations to your liking?
<br><label for="persrec">Yes </label><input type="radio" name="persrec" value="1" >
<br><label for="persrec">No </label><input type="radio" name="persrec" value="0">
<hr>
Have we been able to correctly identify your most preferred category?
<br><label for="mostpref">Yes </label><input type="radio" name="mostpref" value="1" >
<br><label for="mostpref">No </label><input type="radio" name="mostpref" value="0">
<hr>
<br />
<button type='submit' name='recfeedback'>Submit</button>
</form>

<br /><br />
<a href="charts.php"><h2>Check feedback results</h2></a>

<?php

}

mysqli_close($dbc);

?>

</section>

<footer>
	<p>Copyright &copy; 2015 RicoMonkey&trade;. All Rights Reserved.</p>
</footer>

</div>

</body>

<!-- S C R I P T S -->

<script type="text/javascript" src="jquery-1.11.2.js"></script>
<script type="text/javascript"> 
function newResp(uid){
	  var userid = uid;
	  $.ajax({
	  	url: 'delfeedback.php',
	  	data: {"userid" : userid},
	  	type: 'post',
	  	success: function() {
	  		window.location.href = "feedback.php";
	  	}
	  });
	  console.log(userid, "Going");
	  return false;
   }
</script>

<script type="text/javascript" src="manyscripts.js"></script>

</html>