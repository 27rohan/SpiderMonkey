<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />

<script type="text/javascript" src="jquery-1.11.2.js"></script>
<script language="JavaScript" type="text/javascript" src="manyscripts.js"></script>

<style>
</style>

<title>Welcome to RicoMonkey!</title>
<?php
if(isset($_SESSION['name'])){header("location:ricomonkey.php");}
?>

</head>

<body bgcolor="#F8F8F8">
<div id="wrapper">
<div style="float:right;">
<form name="form1" action="login.php" onsubmit="return login()" method="post">
<input type="text" name="username" placeholder="Username" size="20">
<input type="password" name="pass" placeholder="Password" size="13">
<input type="submit" value="Login">
</form>

<p>Not a member yet? <a href="signuppage.php">Sign up!</a></p>
</div>
<img style="float:left;" src="pic/recommend.png" width="300"/></div>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>


</body>
</html>