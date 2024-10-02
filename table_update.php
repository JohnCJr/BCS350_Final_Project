<?php
// table_update.php - table to update student grades
// Edited by: John Cabanas, November 2023
// Notes: clicking the change button uploads the file to mysql


// Connect to the Database
	include('header.php');

	
// Variables
	$pgm		= 'table_update.php'; 
	$pgm2		= 'faculty.php'; 
	$table		= 'student'; 
	$bold		= "style='font-weight:bold;'";
	$center		= "align='center'";
	$msg		= NULL;
	$msg_color	= 'black';
	$columns	= array('firstname', 'lastname', 'id', 'email', 'submitted', 'grade');

// Get Input
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	foreach($columns as $value) 
		if (isset($_POST[$value])) 		${$value} 		= sanitize($mysqli, $_POST[$value]);		else ${$value} = NULL;
	if (isset($_POST['task']))  		$task 			= sanitize($mysqli, $_POST['task']);  		else $task  = 'Show';
	
	if (isset($_GET['r']) && $_GET['r']) {
		$rowid = sanitize($mysqli, $_GET['r']);
		$task = 'Show';
	} else if (isset($_POST['rowid'])) {
		$rowid = sanitize($mysqli, $_POST['rowid']);
	}
	
	if (isset($_GET['r2'])) {
		$assignid = sanitize($mysqli, $_GET['r2']);
		$task = 'Show';
	} else if (isset($_POST['assignid'])) {
		$assignid = sanitize($mysqli, $_POST['assignid']);
	}


	
// Verify Input
	if (($task == 'Change')) {
	
// Text Fields
	if ($submitted == NULL) $msg .= 'Submission status is missing<br>';
	if (strtolower($submitted) != 'yes' && strtolower($submitted) != 'no') $msg .= 'Submission status must be yes or no<br>';

	if ($grade == NULL) {
		$msg .= 'Grade is missing<br>';
	}
	else if ($grade > 100 || $grade < 0) {
		$msg .= 'Grade must be between 0 and 100<br>';
	}
	else if (!is_numeric($grade)) {
		$msg .= 'Grade must be a number<br>';
	}
	if ($msg != NULL) $task = 'Error';

	}
// Process Input
	switch($task) {
    case 'Error':	$msg_color = 'red';  break;
	case 'Show':
		$query = "SELECT firstname, lastname, id, email, submitted, grade
				  FROM $table
				  JOIN studentassignment ON $table.studentid = studentassignment.studentid
				  WHERE studentassignment.studentid = '$rowid' AND studentassignment.assignmentid = '$assignid'";
		$result = mysqli_query($mysqli, $query);
		if (!$result) echo "Query failed [$query]  " . mysqli_error($mysqli); 

		if (mysqli_num_rows($result) < 1) {
			$msg = "ROWID $rowid not found."; 
			$msg_color='red'; 
			$fname = $lname = $category = $email = $phone = $city = NULL;
			}
		else {
			list($firstname, $lastname, $id, $email, $submitted, $grade) = mysqli_fetch_row($result); 
			$msg = "Data Found";
			} 
		break;
    
	case 'Change':
		$query = "UPDATE studentassignment SET
				  submitted	= LOWER('$submitted'),
				  grade		= '$grade'
				  WHERE studentid = '$rowid' AND assignmentid = '$assignid'";
				  echo "Row ID: $rowid, Assignment ID: $assignid";
		$result = mysqli_query($mysqli, $query);
		if (!$result) {
			$msg = "QUERY failed [$query]: " . mysqli_error($mysqli);
			$msg_color = 'red';
			}
		else $msg = "Data Updated";
		break;
    
	default:
    }	

// Output
	echo "<!DOCTYPE HTML><html><body>
		  <div $bold>Update grade and submission for $firstname $lastname</div>\n";
		  
	echo "<p><form action='$pgm' method='POST' enctype='multipart/form-data'>
		  <input type='hidden' name='rowid' value='$rowid'>
		  <input type='hidden' name='assignid' value='$assignid'>
		  <table>
		  <tr><td $bold>First Name</td>
			  <td><input type='text' name='firstname' value='$firstname' size='10' readonly>*</td></tr>  
		  <tr><td $bold>Last Name</td>
			  <td><input type='text' name='lastname' value='$lastname' size='10' readonly>*</td></tr>
		  <tr><td $bold>Email</td>
			  <td><input type='email' name='email' value='$email' size='30' readonly>*</td></tr>
		  <tr><td $bold>ID</td>
			  <td><input type='text' name='id' value='$id' size='10' readonly>*</td></tr>
		  <tr><td $bold>Submitted</td>
			  <td><input type='text' name='submitted' value='$submitted'  size='2'></td></tr>
		  <tr><td $bold>Grade</td>
			  <td><input type='text' name='grade'  value='$grade'  size='2'></td></tr>
		 </table>" ;
		  
// Action Bar
    echo "<p><table><tr><td>
		  <input type='submit' name='task' value='Change' style='background-color:orange;font-weight:bold;'>
		  </td></tr></table></form>
		  <p><a href='$pgm2'><button style='color:white; background-color:green; font-weight:bold;'>Return</button></a></p>";
	
// Message
    echo "<p><table><tr>
		  <td $bold>MESSAGE: </td>
		  <td style='color:$msg_color;'>$msg</td>
		  </tr></table>"; 
		  
// End of Program
	echo "</body></html>";
	mysqli_close($mysqli);

// Sanitize Function
   include('functions');
?>