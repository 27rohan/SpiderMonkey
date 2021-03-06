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

if(!isset($_SESSION['sid'])) {  //session_id
  $dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey')
    or die('Error connecting to MySQL server.');
  $query = "SELECT sid FROM sessions";
  $result = mysqli_query($dbc, $query) or die('Error querying sessions.');
  $s=mysqli_fetch_array($result);
  $_SESSION['sid']=$s['sid'];
  $query = "UPDATE sessions SET sid=sid+1, assignedsid=assignedsid+1, userid=$uid";
  $result = mysqli_query($dbc, $query) or die('Error updating sessions.');
  mysqli_close($dbc);
}

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

<title>RicoMonkey</title>
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

<br />

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

foreach($cats as $cid)  {
  echo '<br />';

  $query = "SELECT cname FROM category WHERE cid = '$cid'";
  $result = mysqli_query($dbc, $query)
    or die('Error querying category table');
  $row = mysqli_fetch_array($result);
  echo '<br /><h3>' . $row['cname'] . '</h3><br />';

  if($mostprefcat!='' && $cid == $mostprefcat) {
    $query = "CALL get_rands('$doublepages','$cid')";
    mysqli_query($dbc, $query);
  }

  else {
    $query = "CALL get_rands('$noofpages','$cid')";
    mysqli_query($dbc, $query);
  }

  $query = "SELECT * FROM rands";
  $result = mysqli_query($dbc, $query)
    or die('Error selecting from rands table.');

  while($row = mysqli_fetch_array($result)) {
    ?>

    <div>
    <table>
      <tr>
    <?php
    echo '<td>' . $row['rand_id'] . "\t";
    if($row['rand_urltitle'] != "") {
      echo '<a href = ' . $row['rand_url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $row['rand_urltitle'] . '</a>' . ' from ' . $row['rand_url'];
    }
    else {
      echo '<a href = ' . $row['rand_url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $row['rand_url'] . '</a>' . ' from ' . $row['rand_url'];
    }
  
  echo "</td>\t";
  
  echo '<td><button type = "button" class = "shareBtn" id = ' . $row['rand_url'] . ' onmousedown = "makeShare()" data-userid = ' . $uid . 
        '>Share</button></td>';

  echo "\t";

  echo '<td><button type="button" class="tagadder" onclick="openDialog">Add Tag</button>' .
        '<div class="dialog">' .
        '<form class="tagform">' .
          'Tag:<input type="text" name="tag" class="tagid" id = ' . $row['rand_url'] . ' data-userid = ' . $uid . '>' .
          '<button type="button" class="subtagbtn" onclick="subtag" id =' . $row['rand_url'] . ' data-userid = ' . $uid . '>Add</button>' .
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