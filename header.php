<?php
// header.php - Webpage Heading includes main website banner and navig
// Written by: John Cabanas, November 2023

// Includes added here since every pages will include header.php
	include('sgv_show.php');
	include('functions.php');
	include('upload.php');
	include('session.php');
	require('bcs350_mysqli_connect.php');
	

// Output	
	echo "<!DOCTYPE HTML><html lang='en'>
	<head>
		<title>West Pine High School</title>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<link rel='icon' type='image/x-icon' href='images/favicon.png'>
		<link href='styles.css' rel='stylesheet'>
	</head>
	<body>";
	// sgv_show('all'); 
	echo "<div class='banner'>
			<div id='banner_left'>
				<img id='banner_image' src='./images/favicon.png' width='100px'>
				<h1>West Pine High School</h1>
			</div>
		";
	// Displays navigation buttons
	include('menubar.php');
?>