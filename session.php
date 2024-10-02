<?php
// session.php - starts a session and gets session variables
// Edited by: John Cabanas November 2023

// Starts session
	session_start();
	
// Retrieve Session Variables
	if (isset($_SESSION['logon'])) {
		$logon = TRUE;
		$user = $_SESSION['user'];
		$role = $_SESSION['role'];
		}
	else {
		$logon = FALSE;
		$user = 'visitor';
		$role = NULL; 
		}
?>