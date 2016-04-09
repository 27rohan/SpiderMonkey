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

.js .manage_reply_enquiry {
  display:none;
}
</style>

<title>RicoMonkey Personalized Recommendations</title>
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
<li class="button"><a href="searchbytag.php">SEARCH BY TAG</a></li>
<li class="button"><a href="searchtitle.php">SEARCH BY TITLE</a></li>
<li class="button"><a href="feedback.php">SUBMIT FEEDBACK</a></li>
</ul>
</nav>

</header>
<br><br> 

<!-- Insert in this section -->

<section>

<?php
$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
  or die('Error connecting to MySQL server.');

$noofcats = count($cats);
$noofpages = 1;

if($noofcats <= 2)
{
  $noofpages = 7;
}
elseif($noofcats < 5)
{
  $noofpages = 4;
}
else
{
  $noofpages = 3;
}

$doublepages = $noofpages*2;

$tagstring = '';
$titlestring = '';
$tagarray = '';
$titlearray = '';
$lastsubtime = 0;

$query = "SELECT * FROM feedbackpers WHERE userid = $uid AND persrec = 0 ORDER BY timeofsub DESC LIMIT 1";
$result = mysqli_query($dbc, $query);

if(mysqli_num_rows($result) != 0) {
  $row = mysqli_fetch_array($result);
  $lastsubtime = $row['timeofsub'];
}

$query = "SELECT tag FROM tagtable WHERE tagid IN (SELECT urltag.tagid FROM useridurlidmapper userurl INNER JOIN urlidtagidmapper urltag ON userurl.urlid=urltag.urlid WHERE userurl.userid=$uid AND userurl.timeofhit > $lastsubtime)";
$result = mysqli_query($dbc, $query)
  or die("Error selecting tags.");

$nooftags = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result)) {
  $tagstring = $tagstring . " " . $row['tag'];
}

echo "<br /><br /><h3>Based on Tags</h3><br />";

if($nooftags == 0) {
  echo "<br />It seems you haven't visited pages with tags recently. Pages with similar tags will be recommended when you visit such pages.";
}

else {
exec("java GlimpseOrder $tagstring", $tagarray);

echo '<br /><br />';

$querytag = "SELECT * FROM urltable WHERE urlid NOT IN (SELECT urlid FROM useridurlidmapper WHERE userid = $uid) AND urlid IN (SELECT urlid FROM urlidtagidmapper INNER JOIN tagtable ON urlidtagidmapper.tagid = tagtable.tagid WHERE tagtable.tag LIKE '%$tagarray[0]%' ";
for($i=1; $i<count($tagarray); $i++) {
  $querytag .= "OR tagtable.tag LIKE '%$tagarray[$i]%' ";
}
$querytag .= ") AND urlcat IN (" . $_SESSION['usercat'] . ") ORDER BY urlrank DESC LIMIT 10";

$result = mysqli_query($dbc, $querytag)
  or die("Error querying querytag.");

if(mysqli_num_rows($result)==0) {
  echo "No new recommendations using tags.";
}

while($row = mysqli_fetch_array($result)) {
    ?>

    <div>
    <table>
      <tr>
    <?php
    echo '<td>' . $row['urlid'] . "\t";
    if($row['urltitle'] != "") {
      echo '<a href = ' . $row['url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $row['urltitle'] . '</a>' . ' from ' . $row['url'];
    }
    else {
      echo '<a href = ' . $row['url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $row['url'] . '</a>' . ' from ' . $row['url'];
    }
  
  echo "</td>\t";
  
  echo '<td><button type = "button" class = "shareBtn" id = ' . $row['url'] . ' onmousedown = "makeShare()" data-userid = ' . $uid . 
        '>Share</button></td>';

  echo "\t";

  echo '<td><button type="button" class="tagadder" onclick="openDialog">Add Tag</button>' .
        '<div class="dialog">' .
        '<form class="tagform">' .
          'Tag:<input type="text" name="tag" class="tagid" id = ' . $row['url'] . ' data-userid = ' . $uid . '>' .
          '<button type="button" class="subtagbtn" onclick="subtag" id =' . $row['url'] . ' data-userid = ' . $uid . '>Add</button>' .
        '</form>' .
        '</div></td>' ;

  echo '<br /><br />';
  ?>
      </tr>
  </table>
</div>

<?php
}
}

echo '<br /><br />';

$query = "SELECT urltitle FROM urltable WHERE urlid IN (SELECT urlid FROM useridurlidmapper WHERE userid = $uid AND timeofhit > $lastsubtime)";
$result = mysqli_query($dbc, $query);

$nooftitles = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result)) {
  $titlestring = $titlestring . " " . $row['urltitle'];
}

echo '<br /><h3>BASED ON YOUR PREVIOUS INTERESTS</h3><br />';

if($nooftitles == 0) {
  echo "<br />It seems you haven't visited any pages recently. Visit pages in order to get new recommendations.";
}

else {
$escapedtitles = escapeshellcmd($titlestring);
exec("java GlimpseOrder $escapedtitles", $titlearray);

$querytitle = "SELECT * FROM urltable WHERE urlid NOT IN (SELECT urlid AS urls FROM useridurlidmapper WHERE userid = $uid) AND ((urltitle LIKE '%$titlearray[0]%') ";
for($i=1; $i<count($titlearray); $i++) {
  $querytitle .= "OR (urltitle LIKE '%$titlearray[$i]%') ";
}
$querytitle .= ") AND urlcat IN (" . $_SESSION['usercat'] . ") ORDER BY urlrank DESC LIMIT 10";
$result = mysqli_query($dbc, $querytitle)
  or die("Error querying querytitle.");

while($row = mysqli_fetch_array($result)) {
    ?>

    <div>
    <table>
      <tr>
    <?php
    echo '<td>' . $row['urlid'] . "\t";
    if($row['urltitle'] != "") {
      echo '<a href = ' . $row['url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $row['urltitle'] . '</a>' . ' from ' . $row['url'];
    }
    else {
      echo '<a href = ' . $row['url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $row['url'] . '</a>' . ' from ' . $row['url'];
    }
  
  echo "</td>\t";
  
  echo '<td><button type = "button" class = "shareBtn" id = ' . $row['url'] . ' onmousedown = "makeShare()" data-userid = ' . $uid . 
        '>Share</button></td>';

  echo "\t";

  echo '<td><button type="button" class="tagadder" onclick="openDialog">Add Tag</button>' .
        '<div class="dialog">' .
        '<form class="tagform">' .
          'Tag:<input type="text" name="tag" class="tagid" id = ' . $row['url'] . ' data-userid = ' . $uid . '>' .
          '<button type="button" class="subtagbtn" onclick="subtag" id =' . $row['url'] . ' data-userid = ' . $uid . '>Add</button>' .
        '</form>' .
        '</div></td>' ;

  echo '<br /><br />';
  ?>
    </tr>
  </table>
</div>

<?php
}
}

echo '<br /><br /><br />';


mysqli_close($dbc);
?>

</section>

<footer>
	<p>Copyright &copy; 2015 RicoMonkey&trade;. All Rights Reserved.</p>
</footer>

</div>
</body>

<!-- S C R I P T S -->

<!-- Record a hit -->
<script type="text/javascript">
$(document).ready(function doHit() {
  $(".addressClick").on('mousedown', (function (event) {
        var addressValue = $(this).attr("href");
        var userid = $(this).attr("data-userid");
      $.ajax({
        url: 'hitrank.php',
        data: {"addressValue" : addressValue, "userid" : userid},
        type: 'post'
      });
    console.log("This just ran.");
    return false;
//    event.stopPropagation();
    }));
});
</script>

<!-- Make a Share -->
<script type="text/javascript" src="jquery-1.11.2.js"></script>
<script type="text/javascript">
$(document).ready(function makeShare() {
  $(".shareBtn").on('mousedown', (function () {
   // var x = document.getElementByID("shareBtn");
    var addressShare = $(this).attr("id");
    var userid = $(this).attr("data-userid");
    $.ajax({
      url: 'recshare.php',
      data: {"addressShare" : addressShare, "userid" : userid},
      type: 'post'
    });
    console.log("makeShare just ran.");
    return false;
  }));
});
</script>

<!-- Open a Dialog -->
<script src="jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>
<script>
//If JS is enabled add a class so we can hide the form ASAP (and only for JS enabled browsers)
document.documentElement.className = 'js';
//add the jQuery click/show/hide behaviours:
$(document).ready(function openDialog() {
$('.tagadder').each(function() {  
    $.data(this, 'dialog', 
      $(this).next('.dialog').dialog({
        buttons: {'OK' : function() {
          $(this).dialog('close');
          console.log("OK button works.");
        }},
        autoOpen: false,  
        modal: true,  
        title: 'Add a Tag',    
        draggable: false  
      })
    );  
  }).on('click', (function() {  
      $.data(this, 'dialog').dialog('open');  
      $('.tagform').show();
      return false;  
  }));  
});  
</script>

<script src="subtag.js" type="text/javascript"></script>

<script src="tagkeypress.js" type="text/javascript"></script>

<script src="manyscripts.js" type="text/javascript"></script>

<script>
//If JS is enabled add a class so we can hide the form ASAP (and only for JS enabled browsers)
document.documentElement.className = 'js';
//add the jQuery click/show/hide behaviours:
$(document).ready(function(){
     $(".reply").on('click', (function() {
         if($(".manage_reply_enquiry").is(":visible")) {
           $(".manage_reply_enquiry").hide();
        } else {
           $(".manage_reply_enquiry").show();
        }
        //don't follow the link (optional, seen as the link is just an anchor)
        return false;
     }));
  });
</script>

</html>