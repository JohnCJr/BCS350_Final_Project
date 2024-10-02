<?php
// check_logon.php - Check LOGON status for Private Pages
// Written by:  Prof. Kaplan, November 2021

// Check for Logon, if not Logged on, redirect to LOGON page
	if (!$logon) {
		header('Location: logon.php');
		exit;
		}
?>