<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />

<script type="text/javascript" src="jquery-1.11.2.js"></script>
<script language="JavaScript" type="text/javascript" src="manyscripts.js"></script>

<style>
h1{
	color: #000;
}
h2{
	color: #000;
}
p{
	color: #000;
}
</style>

<title>Sign Up</title>
<?php
if(isset($_SESSION['name'])){header("location:ricomonkey.php");}
?>

</head>

<body bgcolor="#F8F8F8">
<img style="float:left;" src="pic/recommend.png" width="300"/></div>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

  
<div align = "center">
<h2>SIGN UP</h2>
<form name="form2" action="signup.php" onsubmit="return signup()" method="post">
	<table>
		<tr><td><p>User name:</p></td><td><p><input type="text" id="name" name="name" onblur="signup_validate(this.id)"><span id="pname" style="color:red;">*</span></p></td></tr>
		<tr><td><p>Email id:</p></td><td><p><input type="text" id="email" name="email" onblur="signup_validate(this.id)"><span id="pemail" style="color:red;">*</span></p></td></tr>
		<tr><td><p>Password:</p></td><td><p><input id="pass" type="password" name="pass" onblur="signup_validate(this.id)"><span id="ppass" style="color:red;">*</span></p></td></tr>
	</table>
	<p>Select the categories you like<br /></p>
	<p id="ppriority" style="color:red;"></p>
	<table>
		<tr><td><p>Science & Technology</p></td><td><p><input type="checkbox" id="scitech" name="cat[]" value="1"></p></td></tr>
		<tr><td><p>Mythology</p></td><td><p><input type="checkbox" id="mythology" name="cat[]" value="2"></p></td></tr>		
		<tr><td><p>History</p></td><td><p><input type="checkbox" id="history" name="cat[]" value="3"></p></td></tr>
		<tr><td><p>Comics</p></td><td><p><input type="checkbox" id="comics" name="cat[]" value="4"></p></td></tr>		
		<tr><td><p>Innovation, Creativity</p></td><td><p><input type="checkbox" id="innocrea" name="cat[]" value="5"></p></td></tr>
		<tr><td><p>Theories & Conspiracies</p></td><td><p><input type="checkbox" id="thecons" name="cat[]" value="6"></p></td></tr>		
	</table>
	<input type="submit" name="form2Submit" value="Create my account"></p>
</form>
</div>

</body>
</html>