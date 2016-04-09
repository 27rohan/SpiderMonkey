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

mysql_connect("localhost", "root", "shantanu");
mysql_select_db("spidermonkey");

$q = '';

if(isset($_GET['q'])) {
  $q = $_GET['q'];
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

<script src="manyscripts.js" type="text/javascript"></script>

</script>

<style>
.js .tagform {
  display:none;
}
</style>

<title>RicoMonkey Search by Title</title>
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
<br /><br />

<div>

		<input type="text" placeholder='search' id="search" />
		<button type="button" class="searchbar" onclick="search()">GO</button>

</div> 

<!-- Insert in this section -->

<section>

<?php
  if( $q != '' ) {
  echo 'You entered : ' . $q . '<br /><br />';

  $tags=$q;
$tag=explode(" ",$tags);
$n=count($tag);

$str="SELECT urlid, url, urlcat, urltitle, count(*) AS no FROM ( SELECT  urlid, url, urlcat, urltitle FROM urltable WHERE urltitle like '%$tag[0]%' ";
  for($i=1; $i<$n; $i++){
    $str.=" UNION all SELECT urlid, url, urlcat, urltitle FROM urltable WHERE urltitle like '%$tag[$i]%' ";
  }
  $str.=" ) as c WHERE c.urlcat = $cats[0] ";
  for($i=1; $i<count($cats); $i++) {
    $str.= "OR c.urlcat = $cats[$i] ";
  }
  $str.= "GROUP BY urlid ORDER BY no DESC";
  
  $query=$str;
  $resulti = mysql_query($query) or die(mysql_error());
  
  while($rowi = mysql_fetch_array ($resulti)){
  $urlid=$rowi['urlid'];
  $query = "SELECT * FROM urltable WHERE urlid = $urlid";
  $resulti2 = mysql_query($query) or die(mysql_error());
  $rowi2 = mysql_fetch_array ($resulti2);
  $a=$rowi['url'];
  $tit=$rowi['urltitle'];

  ?>

   <div>
    <table>
      <tr>
    <?php
    echo '<td>' . $rowi2['urlid'] . "\t";
    if($rowi2['urltitle'] != "") {
      echo '<a href = ' . $rowi2['url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $rowi2['urltitle'] . '</a>' . ' from ' . $rowi2['url'];
    }
    else {
      echo '<a href = ' . $rowi2['url'] . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $rowi2['url'] . '</a>' . ' from ' . $rowi2['url'];
    }
  
  echo "</td>\t";
  
  echo '<td><button type = "button" class = "shareBtn" id = ' . $rowi2['url'] . ' onmousedown = "makeShare()" data-userid = ' . $uid . 
        '>Share</button></td>';

  echo "\t";

  echo '<td><button type="button" class="tagadder" onclick="openDialog">Add Tag</button>' .
        '<div class="dialog">' .
        '<form class="tagform">' .
          'Tag:<input type="text" name="tag" class="tagid" id = ' . $rowi2['url'] . ' data-userid = ' . $uid . '>' .
          '<button type="button" class="subtagbtn" onclick="subtag" id =' . $rowi2['url'] . ' data-userid = ' . $uid . '>Add</button>' .
        '</form>' .
        '</div></td>' ;

  echo '<br /><br />';
  ?>
    </tr>
  </table>
</div>

<?php
} 
mysql_close();
}

?>

<?php

echo '<br /><br /><br />';

?>

</section>

<footer>
	<p>Copyright &copy; 2015 RicoMonkey&trade;. All Rights Reserved.</p>
</footer>

</div>
</body>

<!-- S C R I P T S -->

<!-- Search function -->
<script type="text/javascript">
$(document).ready(function search() {
  $(".searchbar").on('click', (function () {
    var str = $("#search").val();
    window.location.href = "searchtitle.php?q="+str;
    console.log(str, "Search works.");
    return false;
  }));
});
</script>

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