<?php
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
// The username/password weren't entered so send the authentication headers
header('HTTP/1.1 401 Unauthorized');
header('WWW-Authenticate: Basic realm="RicoMonkey"');
exit('<h3>RicoMonkey</h3>Sorry, you must enter your username and password to log in and access ' .
'this page.');
}
// Connect to the database
$dbc = mysqli_connect('localhost', 'root', 'shantanu', 'spidermonkey');
// Grab the user-entered log-in data
$user_username = mysqli_real_escape_string($dbc, trim($_SERVER['PHP_AUTH_USER']));
$user_password = mysqli_real_escape_string($dbc, trim($_SERVER['PHP_AUTH_PW']));
// Look up the username and password in the database
$query = "SELECT * FROM user WHERE username = '$user_username' AND " .
"userpwd = SHA('$user_password')";
$data = mysqli_query($dbc, $query);
if (mysqli_num_rows($data) == 1) {
// The log-in is OK so set the user ID and username variables
$row = mysqli_fetch_array($data);
$userid = $row['userid'];
$username = $row['username'];
$usercat = $row['usercat'];
$mostpref = $row['mostprefcat'];
}
else {
// The username/password are incorrect so send the authentication headers
header('HTTP/1.1 401 Unauthorized');
header('WWW-Authenticate: Basic realm="RicoMonkey"');
exit('<h2>RicoMonkey</h2>Sorry, you must enter a valid username and password to log in and ' .
'access this page. If you aren\'t a registered member, please sign up</a>.');
}
// Confirm the successful log-in
echo('<p class="login">You are logged in as ' . $username . '.</p>');
?>