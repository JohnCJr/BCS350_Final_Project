<?php
// functions.php stores all functions used for the BCS350 final project wesbite titled West Pine High School
// Created by John Cabanas

	// Sanitize Function
	function sanitize($mysqli, $var) {
		$var = trim($var);									// Remove whitespace
		$var = mysqli_real_escape_string($mysqli, $var);	// Converts special characters to be safe to use in a SQL statement
		$var = strip_tags($var);
		$var = htmlentities($var);                          // Convert special characters to HTML equivalents
		return($var);
		}
?>