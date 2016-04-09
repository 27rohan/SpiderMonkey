<!DOCTYPE html>
<html>

<head>
<script type="text/javascript" src="jquery-1.11.2.js"></script>
<script src="jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css" />

<style>
.js #tagform {
  display:none;
}

.js .manage_reply_enquiry {
  display:none;
}
</style>
</head>

<body>
<div>
<?php
$bonus = 0.0000;

$upheaval = $bonus + 0.0005;

echo $bonus . "<br />";
echo $upheaval;
?>
</div>
<input id="tagadder" type="button" value="Add Tag" />
<div id="dialog">
	<form id="tagform">
    Tag:<input type="text" name="tag" id="tagid">
    <button type="button" id="subtagbtn" onclick="subtag">Add</button>
  </form>
</div>

<a class="reply" href=".manage_reply_enquiry">Is this tag relevant?</a>

<form class="manage_reply_enquiry">
    <fieldset>
      <button type="button" class="subtagbtn" onclick="relevyes">Yes</button>
      <button type="button" class="subtagbtn" onclick="relevnot">No</button>
    </fieldset>
</form>
</body>

<script>
$(document).ready(function() {
$('#tagadder').on('click', (function(event) {
  $("#tagform").show();
  $('#dialog').attr('title', 'Add Tag').dialog( { buttons: {'Ok' : function() {
    $(this).dialog('close');
  }}, closeOnEscape : true, draggable : true, modal : true });
  event.preventDefault();
}));
});
</script>

<script>
$(document).ready(function subtag() {
  $('#subtagbtn').on('click', (function() {
    var tag = $("#tagid").val();
    console.log(tag, "Tag submit button works.");
  }));
});
</script>

<script>
$(document).ready(function() {
  $('#tagid').on('keypress', (function(event) {
    var tag = $('#tagid').val();
    if(event.which==13 && tag!='') {
      event.preventDefault();
      console.log(tag, "Tag enter works.");
    }
    if(event.which==13 && tag == '') {
      event.preventDefault();
      console.log("Default prevented.");
    }
  }));
});
</script>

<script>
//If JS is enabled add a class so we can hide the form ASAP (and only for JS enabled browsers)
document.documentElement.className = 'js';
//add the jQuery click/show/hide behaviours:
$(document).ready(function(){
     $(".reply").on('click', (function(){
         if($(".manage_reply_enquiry").is(":visible")){
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