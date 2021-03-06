<?php
/************************************************
	The Search PHP File
************************************************/


/************************************************
	MySQL Connect
************************************************/

// Credentials
$dbhost = "localhost";
$dbname = "spidermonkey";
$dbuser = "root";
$dbpass = "shantanu";

//	Connection
global $dbc;

$dbc = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


/************************************************
	Search Functionality
************************************************/

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a href="urlString">';
$html .= '<h3>nameString</h3>';
$html .= '</a>';
$html .= '</li>';

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $dbc->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT * FROM tagtable WHERE tag LIKE "%'.$search_string.'%"';

	// Do Search
	$result = mysqli_query($dbc, $query);
	while($results = mysqli_fetch_array($result)) {
		$result_array[] = $results;
	}

	// Check If We Have Results
	if (isset($result_array)) {
		foreach ($result_array as $result) {

			// Format Output Strings And Hightlight Matches
			$display_tag = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['tag']);
			//$display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['name']);
			$display_url = 'searchbytag.php?pattern='.urlencode($result['tag']);

			// Insert Name
			$output = str_replace('nameString', $display_tag, $html);

			// Insert Function
			//$output = str_replace('functionString', $display_function, $output);

			// Insert URL
			$output = str_replace('urlString', $display_url, $output);

			// Output
			echo($output);
		}
	}else{

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('nameString', '<b>No Results Found.</b>', $output);
	//	$output = str_replace('functionString', 'Sorry :(', $output);

		// Output
		echo($output);
	}
}


/*
// Build Function List (Insert All Functions Into DB - From PHP)

// Compile Functions Array
$functions = get_defined_functions();
$functions = $functions['internal'];

// Loop, Format and Insert
foreach ($functions as $function) {
	$function_name = str_replace("_", " ", $function);
	$function_name = ucwords($function_name);

	$query = '';
	$query = 'INSERT INTO search SET id = "", function = "'.$function.'", name = "'.$function_name.'"';

	$tutorial_db->query($query);
}
*/
?>