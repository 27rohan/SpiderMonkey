<!--

$_SESSION['sid'] //session id
$_SESSION['category'] //represent current category
$_SESSION['name'] //remember user name
$_SESSION['uid']  //remember id of user


-->
<?php
/*session_start();

if(!isset($_SESSION['name'])){
	header("location:welcome.php");
}
if(!isset($_SESSION['sid'])){  //session_id
	mysql_connect("localhost", "root", "shantanu");
	mysql_select_db("recommend");
	$query = "SELECT sid FROM session_catalog_user_activity_id";
	$result = mysql_query($query) or die(mysql_error());
	$s=mysql_fetch_array ($result);
	$_SESSION['sid']=$s['sid'];
	$query = "UPDATE session_catalog_user_activity_id SET sid=sid+1";
	$result = mysql_query($query) or die(mysql_error());
}
*/
?>

                                         <!-- metadata   -->
<html>
<head>
<link rel="stylesheet" href="stylesheet/default.css" type="text/css" media="screen" />
<script type="text/javascript" src="jquery-1.11.2.js"></script>
<script src="jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>

<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css" />

<style>
.js .tagform {
  display:none;
}
</style>
</head>
	
                                         <!--   body     -->
<body onload="initialize()">
<div class="logosearch" >
	<div class="logo">
		<img src='pic/recommend.png'/>
	</div>
	<div class="search" style="background:url('pic/quote.png') no-repeat;">
		<div>
			<p class="searchp" style="cursor:pointer;" onclick="logout()"> SIGN OUT </p>
			<p class="searchp"> Hi <?php echo $_SESSION['name']; ?> </p>
			<p class="searchp" style="cursor:pointer;" onclick="search()"> GO </p>
			<input type="text" style='float:right;overflow:hidden;height:30%;width:30%' placeholder='search' id='search'/>
      </div>
  </div>
</div>

                                         <!--  main body  -->
<div class="categorymainad">

                                         <!--  category  -->

<div class="category">
			
</div>

                                         <!--  get body -->

<div class="main" id="main">

<nav>
<ul>
<li class="button"><a href="ricomonkey.php">RECOMMENDED</a></li>
<li class="button"><a href="popbyrank.php">MOST POPULAR</a></li>
<li class="button"><a href="activity.php">ACTIVITY</a></li>
<li class="button"><a href="index.html">SEARCH BY TAG</a></li>
</ul>
</nav>

</div>

                                       <!--  advertisement -->


</div>
</body>

                                          <!--  tailer  -->
<script language="JavaScript" type="text/javascript" src="manyscripts.js"></script>
</html>