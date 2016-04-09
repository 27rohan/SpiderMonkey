$(document).ready(function() {
  $('.tagid').on('keypress', (function(event) {
    var tag = $(this).val();
    var userid = $(this).attr("data-userid");
    var theurl = $(this).attr("id");
    if(event.which==13 && tag!='') {
      event.preventDefault();
      $.ajax({
        url: 'tagadder.php',
        data: {"tag" : tag, "userid" : userid, "theurl" : theurl},
        type: 'post'
      });
      console.log(tag, "Tag enter works.");
      return false;
    }
	if(event.which==13 && tag == '') {
		event.preventDefault();
		console.log("Default prevented.");
	}
  }));
});