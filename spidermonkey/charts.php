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


////////////////////////////// start ( enter value ) ////////////////////////////////////////////
$server = "localhost";
$user = "root";
$password = "shantanu";
mysql_connect($server, $user, $password);
mysql_select_db("spidermonkey");
//////////////////////////// end ///////////////////////////////////////////////////////////////

$str1 = mysql_query("SELECT * FROM f_q1") or die(mysql_error());
$str2 = mysql_query("SELECT * FROM f_q2") or die(mysql_error());
$str3 = mysql_query("SELECT * FROM f_q3") or die(mysql_error());
$str4 = mysql_query("SELECT * FROM f_q4") or die(mysql_error());

 
$rows1 = array();
$rows2 = array();
$rows3 = array();
$rows4 = array();
$flag = true;
$table1 = array();
$table2 = array();
$table3 = array();
$table4 = array();
$table1['cols'] = array(
    array('label' => 'people', 'type' => 'string'),
    array('label' => 'total', 'type' => 'number')
);
$table2['cols'] = array(
    array('label' => 'people', 'type' => 'string'),
    array('label' => 'total', 'type' => 'number')
);
$table3['cols'] = array(
    array('label' => 'people', 'type' => 'string'),
    array('label' => 'total', 'type' => 'number')
);
$table4['cols'] = array(
    array('label' => 'people', 'type' => 'string'),
    array('label' => 'total', 'type' => 'number')
); 
while($r = mysql_fetch_array($str1)) {
    if($r['people']==1) $r['people']="YES";
    else $r['people']="NO";
    $temp1 = array();
    $temp1[] = array('v' => (string) $r['people']); 
    $temp1[] = array('v' => (int) $r['count(*)']);
    $rows1[] = array('c' => $temp1);
} 
$table1['rows'] = $rows1;
$jsonTable1 = json_encode($table1);
while($r = mysql_fetch_array($str2)) {
    if($r['people']==1) $r['people']="YES";
    else $r['people']="NO";
    $temp2 = array();
    $temp2[] = array('v' => (string) $r['people']); 
    $temp2[] = array('v' => (int) $r['count(*)']);
    $rows2[] = array('c' => $temp2);
} 
$table2['rows'] = $rows2;
$jsonTable2 = json_encode($table2);
while($r = mysql_fetch_array($str3)) {
    if($r['people']==1) $r['people']="YES";
    else $r['people']="NO";
    $temp3 = array();
    $temp3[] = array('v' => (string) $r['people']); 
    $temp3[] = array('v' => (int) $r['count(*)']);
    $rows3[] = array('c' => $temp3);
} 
$table3['rows'] = $rows3;
$jsonTable3 = json_encode($table3);
while($r = mysql_fetch_array($str4)) {
    if($r['people']==1) $r['people']="YES";
    else $r['people']="NO";
    $temp4 = array();
    $temp4[] = array('v' => (string) $r['people']); 
    $temp4[] = array('v' => (int) $r['count(*)']);
    $rows4[] = array('c' => $temp4);
} 
$table4['rows'] = $rows4;
$jsonTable4 = json_encode($table4);
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

<!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
    google.load('visualization', '1', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
 
    function drawChart() {
      var data1 = new google.visualization.DataTable(<?=$jsonTable1?>);
      var data2 = new google.visualization.DataTable(<?=$jsonTable2?>);
      var data3 = new google.visualization.DataTable(<?=$jsonTable3?>);
      var data4 = new google.visualization.DataTable(<?=$jsonTable4?>);
      var options1 = {
          title: ' Satisfied with the Recommendations? ',
          is3D: 'true',
          width: 400,
          height: 300
        };
  var options2 = {
          title: ' Have popular pages correctly been Recommended? ',
          is3D: 'true',
          width: 400,
          height: 300
        };
  var options3 = {
          title: ' Have tags been appropriately assigned? ',
          is3D: 'true',
          width: 400,
          height: 300
        };
  var options4 = {
          title: ' New pages discovered? ',
          is3D: 'true',
          width: 400,
          height: 300
        };
      var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
      chart1.draw(data1, options1);
      var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
      chart2.draw(data2, options2);
      var chart3 = new google.visualization.PieChart(document.getElementById('chart_div3'));
      chart3.draw(data3, options3);
      var chart4 = new google.visualization.PieChart(document.getElementById('chart_div4'));
      chart4.draw(data4, options4);
    }
    </script>
  <style>
#chart_div1{ float: left;background: #F8F8F8; }
#chart_div2{ float: right;background: #F8F8F8; }
#chart_div3{ float: left;background: #F8F8F8; }
#chart_div4{ float: right;background: #F8F8F8; }

  </style>

<title>RicoMonkey Feedback Results</title>
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

<br />

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

<!-- Insert in this section -->

<section>

<!--this is the div that will hold the pie chart-->
    <br />
    <div style="height: 900px;">
    <div id="chart_div1">
    <br />
    <?php

    $query = "SELECT count(*) AS tot FROM feedback WHERE satisfied = 1";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    echo $row['tot'] . ' people were satisfied with the recommendations.';

    ?>
    </div>
    
    <br />
    
    <div id="chart_div2">
    <br />
    <?php

    $query = "SELECT count(*) AS tot FROM feedback WHERE popular = 1";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    echo $row['tot'] . ' people think popular pages are being correctly recommended.';

    ?>
    </div>
    
    <br />
    
    <div id="chart_div3">
    <br /><br />
    <?php

    $query = "SELECT count(*) AS tot FROM feedback WHERE tags = 1";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    echo $row['tot'] . ' people found that tags were appropriately assigned.';

    ?>
    </div>
    
    <br />
    
    <div id="chart_div4">
    <br />
    <?php

    $query = "SELECT count(*) AS tot FROM feedback WHERE new = 1";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    echo $row['tot'] . ' people discovered new pages through RicoMonkey!';

    ?>
    </div>
  </div>

    <br /><br />

</section>

<footer>
  <p>Copyright &copy; 2015 RicoMonkey&trade;. All Rights Reserved.</p>
</footer>

</div>
</body>

<!-- S C R I P T S -->

<script src="manyscripts.js" type="text/javascript"></script>

</html>