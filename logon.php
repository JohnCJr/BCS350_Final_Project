<?php
// logon.php - Website Logon
// Edited by: John Cabanas, November 2021

// Include
include('header.php');

// Variables 
$msg 		= NULL;								// Error Message
$td 		= "width='20%' align='right'";		// Attributes for 1st column
$tf 		= "width='80%' align='left'";		// Attributes for 2nd column
$pgm		= 'logon.php';
$width		= '800';

// Get Form Input  
$userid 	= isset($_POST['userid']) ? trim($_POST['userid']) : NULL; // Simplified
$password 	= isset($_POST['password']) ? trim($_POST['password']) : NULL; // Simplified

// Verify Input
if (isset($_POST['logon'])) {
	if (empty($userid)) $msg .= "Username is missing<br>"; // Changed to use empty()
	if (empty($password)) $msg .= "Password is missing<br>"; // Changed to use empty()

	// LOGON		
	if (empty($msg)) { // Changed to use empty()
		
		// Query Student Using the USERID, joins the student and staff tables using union to query through both tables
		$query = "SELECT studentid, firstname, lastname, password, role 
				  FROM student
				  WHERE userid = ? 
				  UNION 
				  SELECT staffid, firstname, lastname, password, role 
				  FROM staff 
				  WHERE userid = ?";
		$stmt = mysqli_prepare($mysqli, $query); // Prepared statement
		mysqli_stmt_bind_param($stmt, 'ss', $userid, $userid); // Bind parameters
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt); // Get the result set

		if (!$result) echo "Query Error [$query] " . mysqli_error($mysqli);
		
		// If USERID is FOUND, Verify Password 		
		if (mysqli_num_rows($result) > 0) {
			list($id, $firstname, $lastname, $correctpassword, $role) = mysqli_fetch_row($result);
			
			// If PASSWORD matches, Complete LOGON				
			if ($password == $correctpassword) {
				$_SESSION['id']        = $id;
				$_SESSION['logon']		= TRUE;
				$_SESSION['userid'] 	= $userid;
				$_SESSION['user'] 		= $user = "$firstname $lastname";
				$_SESSION['role']		= $role; 
				$msg					= "<font color='green'><b>$user Logon Successful</b></font>";
				$logon 					= TRUE;
			} else {
				$msg = "Invalid Password";
			}
		} else {
			$msg = "USERID [$userid] is invalid";
		}
	}
}

// OUTPUT Logon Screen
if (empty($msg)) $msg = "Enter Username and Password"; // Changed to use empty()
else if (!$logon) $msg = "<font color='red'>$msg Please try again</font>";	
echo "<div class='credential-box'>
		<div class='credentials'>
			<h2>West Pine Logon Portal</h2>
			<form action='$pgm' method='POST' autocomplete='off'>
				<table>
					<tr><td $td>Username</td>		<td $tf><input type='text'     name='userid'   value='' size='40' maxlength='40' required></td></tr>
					<tr><td $td>Password</td>		<td $tf><input type='password' name='password' value='' size='40' maxlength='40' required></td></tr>
				</table>
				<p align='center'><input id='logon' type='submit' name='logon' value='LOGON'></p>
				<p>$msg</p>
			</form>
		</div>
	 </div>";

if ($logon) {
	if ($role == 'Student') $page = 'student.php';
	if ($role == 'Teacher') $page = 'faculty.php';
	if ($role == 'Administrator') $page = 'administrator.php';
	echo "<script>
			setTimeout(function() {
				window.location.href = '$page';
			}, 1500);	// 1.5 seconds
		  </script>";
}

include('footer.php');
?>