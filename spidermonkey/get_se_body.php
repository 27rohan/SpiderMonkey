<!DOCTYPE html>
<?php
session_start();
mysql_connect("localhost", "root", "shantanu");
mysql_select_db("spidermonkey");

$catarr = $_SESSION['usercat'];
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
  <!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
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

<?php

$tags=$_REQUEST['q'];
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
/*      $reff="track?source=search&id=".$urlid;
	$str="";
	$str.="<a target='_blank' href='$a' class = 'addressClick' onmousedown = 'doHit()' data-userid = '$uid'>";
    $str.="<p>$urlid $tit</p>";
	$str.="</a>";

	echo $str;
	*/

	echo '<a href = ' . $a . ' class = "addressClick" target = "_blank" onmousedown = "doHit()" data-userid = ' . $uid . '>' . 
      $tit . '</a>';

    echo '<br /><br />';
}	
mysql_close();


/*//insert into search
$query="insert ignore into search(uid,id_set) values ('$uid','$id') ";
$result = mysql_query($query) or die(mysql_error());*/
?>

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

</html>