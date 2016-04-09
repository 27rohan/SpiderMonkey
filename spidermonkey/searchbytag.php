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
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<script type="text/javascript" src="jquery-1.11.2.js"></script>
<meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <!-- Load CSS -->
  <link rel="stylesheet" href="sourcexsrt/sourcexsrt/css/style.css" />
  <!-- Load Fonts -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:regular,bold" type="text/css" />
    <!-- link rel="stylesheet" href="sourcexsrt/sourcexsrt/css/nivo-slider.css" type="text/css" media="screen" / -->
    <link rel="stylesheet" href="sourcexsrt/sourcexsrt/css/default/default.css" type="text/css" media="screen" />
  <!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="sourcexsrt/sourcexsrt/jquery.nivo.slider.pack.js" type="text/javascript"></script>
        <[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>

<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css" />

<script type="text/javascript" src="scripts/custom.js"></script>

<style>
.js .tagform {
  display:none;
}

.js .manage_reply_enquiry {
}
</style>

<title>RicoMonkey Search by Tag</title>
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

<!-- Main Title -->
    <div class="icon"></div>
    <h1 class="title">Enter a Tag</h1>
    <h5 class="title">Search pages with tags</h5>

    <!-- Main Input -->
    <input type="text" id="search" autocomplete="off">

    <!-- Show Results -->
    <h4 id="results-text">Showing results for: <b id="search-string">Array</b></h4>
    <ul id="results"></ul>
    <br /><br /><br />

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

$posttag = '';

if(isset($_GET['pattern'])) {
  $posttag = $_GET['pattern'];
  $query = "SELECT * FROM urltable WHERE urlid IN (SELECT urlid FROM urlidtagidmapper WHERE tagid=(SELECT tagid FROM tagtable WHERE tag = '$posttag') AND tagrel>0.5000 ORDER BY tagrel DESC)";
  $result = mysqli_query($dbc, $query);

  $noofresults = mysqli_num_rows($result);

  if($noofresults == 0) {
    echo '<p>No results for ' . $posttag . '</p>';
  }
  else {
    echo '<p>Showing results for : ' . $posttag . '</p>';
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

  echo '</tr></table>';

  echo '<br />';

  echo '<p class="tagrel">Is this tag relevant?</p>' .
        '<form class="manage_reply_enquiry">' .
          '<button type="button" class="reltagyes" onclick="relevyes" id = ' . $row['urlid'] . ' data-userid = ' . $uid . '>Yes</button>' .
          '<button type="button" class="reltagno" onclick="relevnot" id = ' . $row['urlid'] . ' data-userid = ' . $uid . '>No</button>' .
        '</form>' ;

  echo '<br /><br />';
  }
  ?>
</div>

<?php
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

<!-- Open Tag Relevance Form -->
<!-- script>
//If JS is enabled add a class so we can hide the form ASAP (and only for JS enabled browsers)
document.documentElement.className = 'js';
//add the jQuery click/show/hide behaviours:
$(document).ready(function(){
     $(".tagrel").on('click', (function() {
         if($(".manage_reply_enquiry").is(":visible")) {
           $(".manage_reply_enquiry").hide();
        } else {
           $(".manage_reply_enquiry").show();
        }
        //don't follow the link (optional, seen as the link is just an anchor)
        return false;
     }));
  });
</script -->

<script type="text/javascript">
$(document).ready(function relevyes() {
  $(".reltagyes").on('click', (function() {
    var addressValue = $(this).attr("id");
    var userid = $(this).attr("data-userid");
    var tag = '<?php echo $posttag; ?>';
    $.ajax ({
      url: 'tagrelup.php',
      data: {"addressValue" : addressValue, "userid" : userid, "tag" : tag},
      type: 'post'
    });
    console.log(addressValue, userid, tag, "relevyes just ran.");
    return false;
  }));
});
</script>

<script type="text/javascript">
$(document).ready(function relevnot() {
  $(".reltagno").on('click', (function() {
    var addressValue = $(this).attr("id");
    var userid = $(this).attr("data-userid");
    var tag = '<?php echo $posttag; ?>';
    $.ajax ({
      url: 'tagreldown.php',
      data: {"addressValue" : addressValue, "userid" : userid, "tag" : tag},
      type: 'post'
    });
    console.log(addressValue, userid, tag, "relevnot just ran.");
    return false;
  }));
});
</script>

</html>