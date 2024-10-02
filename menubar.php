<?php
// menubar.php - navigation bar for website
// Written by: John Cabanas, November 2023


// Variables
	$pages = array('homepage', 'catalogue', 'events', 'student', 'faculty', 'administrator', 'logon', 'about us');
	$restricted	= array('student', 'faculty', 'administrator');
	

// Output
	echo "<div id='menu_bar'><ul>";
	// only the appropriate button will display based on the user role
	foreach($pages as $key) {
		if (($key == 'logon') AND ($logon)) $key = 'logoff';
		if (in_array($key, $restricted) AND (!$logon)) continue;
		if ($key == 'student' AND $role != 'Student') continue;
		if ($key == 'faculty' AND $role != 'Teacher') continue;	
		if ($key == 'administrator' AND $role != 'Administrator') continue;	
		echo "<li class='menu_list'><a href='$key.php'><button>". ucfirst($key) . "</button></a></li>";
	}
	echo "</ul></div></div>";
?>