<?php
// sgv_show.php - Show all Elements of a Super Global Variable
// Written by: Charles Kaplan, October 2023
// Used to testing global variable values

function sgv_show($input = 'all') {
// Variables
	$input		= 'all';
	$bold		= "style='font-weight: bold;'"; 
	
// Determine which SGV's to Show
	$input = strtolower($input);
	if ($input == 'all') $input = 'cefgprsv';
	$len = strlen($input);
	for($i=0; $i<$len; $i++) {
		$sgv = substr($input, $i, 1);
		switch($sgv) {
			case 'c':	if (isset($_COOKIE))	$temp = $_COOKIE; 	$title = 'COOKIE'; break;
			case 'e':	if (isset($_ENV))		$temp = $_ENV; 		$title = 'ENV'; break;
			case 'f':	if (isset($_FILES))		$temp = $_FILES; 	$title = 'FILES'; break;
			case 'g':	if (isset($_GET))		$temp = $_GET; 		$title = 'GET'; break;
			case 'p':	if (isset($_POST))		$temp = $_POST; 	$title = 'POST'; break;
			case 'r':	if (isset($_REQUEST))	$temp = $_REQUEST; 	$title = 'REQUEST'; break;
			case 's':	if (isset($_SESSION))	$temp = $_SESSION;	$title = 'SESSION'; break; 
			case 'v':	if (isset($_SERVER))	$temp = $_SERVER;	$title = 'SERVER'; break; 
			default:
			}
		echo "<p><div align='center' $bold>$title SGV</div>";
		if ((isset($temp)) AND (count($temp) > 0)) {
			echo "<table align='center' rules='all' border='frame' cellspacing='3'>";
			if ($title != 'FILES') {
				foreach($temp as $key => $value) 
					echo "<tr><td $bold>$key</td><td>$value</td></tr>";
				}
			else {
				foreach($temp as $key => $value)
					foreach($value as $key2 => $value2)
						echo "<tr><td>$key</td><td $bold>$key2</td><td>$value2</td></tr>";
				}
			echo "</table><p>";
			unset($temp);
			}
		else echo "<div align='center'>None Found</div><p>"; 
		}
	}
?>