$(document).ready(function subtag() {
  $('.subtagbtn').on('click', (function() {
    var tag = $(this).parent('form').find('.tagid').val();
    var userid = $(this).attr("data-userid");
    var theurl = $(this).attr("id");
	if(tag != '') {
		$.ajax({
			url: 'tagadder.php',
			data: {"tag" : tag, "userid" : userid, "theurl" : theurl},
			type: 'post'
		});
    	console.log(tag, "Tag submit button works.");
    	return false;
	}
	else {
		console.log("Tag is null.");
	}
  }));
});