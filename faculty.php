<?php
// faculty.php - Faculty Page 
// Written by:  John Cabanas, 2023


// Include
include('header.php');


// redirects if not a teacher
	if ($role != 'Teacher') {
		if ($role == 'Administrator') {
			header('Location: administrator.php' );
			exit();
		}
		if ($role == 'Student') {
			header('Location: student.php' );
			exit();
		}
		else {
			header('Location: homepage.php' );
			exit();
		}
	}

// Variables
	$pgm				= 'faculty.php'; 
	$pgm2				= 'update_profile.php'; 
	$table				= 'student';
	$table2             = 'staff';
	$msg			    = NULL;
	$msg_color			= NULL;
	$currentid             = $_SESSION['id'];	// current user's ID
	$bold				= "style='font-weight:bold;'";
	$grades				= array("A" => "green","B" => "black","C" => "brown","D" => "orange", "F" => "red");
	$sorts				= array ('firstname', 'lastname', 'id', 'email', 'assignmentname', 'submitted','grade');
	$sortchoices        = array ('DESC', 'ASC');
	$extns              = array('.jpg', '.jpeg', '.gif', '.png', '.webp');
    $dir                = 'profile pictures/faculty';
	$maxsize            = 25000000;
	$where              = "WHERE $table2.staffid = $currentid ";
   

// Get photo from staff table for staff member currently logged in and sets the $profilepic variable
	$query = "SELECT photo, classname, email
			  FROM $table2
			  JOIN class ON staff.staffid = class.staffid
			  $where";
	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "QUERY [$query]: " . mysqli_error($mysqli);
	list($profilepic, $course, $contact) = mysqli_fetch_row($result);


// Get user inputs and assigns default value if no input was set
	if (isset($_POST['assignment'])) 		$assignment 		= sanitize($mysqli, $_POST['assignment']);		else $assignment = NULL;
	if (isset($_POST['pathname']))  		$pathname           = sanitize($mysqli, $_POST['pathname']);  	    else $pathname  = NULL;
	if (isset($_POST['task']))  		    $task 			    = sanitize($mysqli, $_POST['task']);  		    else $task  = NULL;
	if (isset ($_POST['sort']))             $sort               = sanitize($mysqli, $_POST['sort']);            else $sort = 'Select';
	if ($sort == 'Select')                  $sort               = NULL;
	if (isset($_POST['sortdirection']))  	$sortdirection      = $_POST['sortdirection']; 						else $sortdirection = 'Select';
	if ($sortdirection == 'Select')         $sortdirection      = NULL;
	

// Process Input Sort
	switch($sort) {
		case 'firstname': 	    $sortby = 'firstname'; break;
		case 'lastname': 	    $sortby = 'lastname'; break;
		case 'id': 		        $sortby = 'id'; break;
		case 'email': 		    $sortby = 'email'; break;
		case 'assignmentname':  $sortby = 'assignmentname'; break;
		case 'submitted':	    $sortby = 'submitted'; break;
		case 'grade': 		    $sortby = 'grade'; break;
		default: 			    $sortby = 'firstname, lastname'; break;
	}
	$sortby = 'ORDER BY ' . $sortby . ' ' . $sortdirection;


// Validates that new assignment submission isn't null
	if ($task == 'Add') {
		if ($assignment == NULL) $msg .= 'Please enter the name of the assignment you want to add<br>';
	}
// Validates that new photo submission isn't null
	if ($task == 'Upload'){
		if (!isset($_FILES['photo']['name']) || $_FILES['photo']['name'] == NULL) $msg .= 'Please upload an image if you wish to update your profile picture<br>';
	}
// $task variable changed to 'Error' if either submissions were null
	if ($msg != NULL) $task = 'Error';


// Checks for the value of the $task variable
	switch($task) {
		case 'Error':	
			$msg_color = 'red';  break;

		case 'Add':
			// Adds assignment name to assignment table
			$query = "SELECT DISTINCT classid FROM class WHERE staffid = $userid";	//gets the classid for the class the teacher teaches
	        list($classid) = mysqli_fetch_row(mysqli_query($mysqli, $query));
			$query = "INSERT INTO assignment SET 
					  assignmentname = '$assignment',
					  classid = '$classid'";
			$result = mysqli_query($mysqli, $query);
			if (!$result) {
				$msg = "Query failed [$query]" . mysqli_error($mysqli); 
				$msg_color='red';
			}
			else {
				$msg = "New assignment added";
			}

			// Assigns the highest assignmentid to $maxassignid, which is the id for the assignment that was just addded
			$query = "SELECT MAX(assignmentid) FROM assignment";
			$result = mysqli_query($mysqli, $query);
			if (!$result) {
				$msg = "Query failed [$query]" . mysqli_error($mysqli); 
				$msg_color='red';
			}
			else {
				list($maxassignid)= mysqli_fetch_row($result);
			}
				
			// Gets the total number of students in the student table and
			// assigns it to $studentcount, will be used in a loop
			$query = "SELECT COUNT(DISTINCT(studentid)) FROM student";
			$result = mysqli_query($mysqli, $query);
			if (!$result) {
				$msg = "Query failed [$query]" . mysqli_error($mysqli); 
				$msg_color='red';
			}
			else {
				list($studentcount)= mysqli_fetch_row($result);
			}

			for ($i = 1; $i <= $studentcount; $i++){
				$query = "INSERT INTO studentassignment SET
				studentid = '$i',
				assignmentid = '$maxassignid',
				submitted = 'no',
				grade = NULL";
				$result = mysqli_query($mysqli, $query);
				if (!$result) {
					$msg = "Query failed [$query]" . mysqli_error($mysqli); 
					$msg_color='red';
					break; 	// stops loop if a query failed
				} 
			}
			$msg .= ", assignment added to students";
			break;

		case 'Upload':
			// Upload the photo
				list($rc, $filename) = upload('photo', $dir, $userid, $extns, $maxsize);
				echo "filename: $filename SR: $rc task: $task";
				if ($rc == 0) { 
					$query = "UPDATE $table SET photo = '$filename' WHERE staffid = '$userid'";
					$result = mysqli_query($mysqli, $query);
					if (!$result) echo "QUERY [$query]: " . mysqli_error($mysqli);
					$msg = "File Uploaded Successfully.  RC: $rc userid: $userid";
				}
				else {
					$msg = "File Uploaded Failed, RC = $rc, $filename";
					$msg_color = 'red';
				}
			break;
		default:
	}

// Output
// Create a query to obtain teacher's students information 
	$query = "SELECT studentassignment.studentid, studentassignment.assignmentid, student.firstname, 
					 student.lastname, student.id, student.email, assignmentname, submitted, grade, studentassignment.submission
	          FROM $table2
			  INNER JOIN class ON $table2.staffid = class.staffid
			  INNER JOIN assignment ON class.classid = assignment.classid
			  INNER JOIN studentassignment ON studentassignment.assignmentid = assignment.assignmentid
			  INNER JOIN student ON student.studentid = studentassignment.studentid
			  $where
			  $sortby";
	
// Execute the query to obtain teacher's students information 
	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "QUERY [$query]: " . mysqli_error($mysqli);
	
// Outputs user Profile Picture and name
	echo "<h1 $bold id='welcomemessage'> Welcome $user</h1>
		  <div class='data-container'>
		  	<div class='profile-container'>
          	<div class='profile'> 
		   		<p id='name'>$user</p>
				<p id='role'>$_SESSION[role]</p>";

	if ($profilepic == NULL){
		$profilepic = 'profile pictures/default.jpg';
	}

	echo "<img src='$profilepic' width='200'/>
		  <p id='user-contact'>$contact</p>";
	echo "<p><a href='$pgm2'><button style='color:white; background-color:green; 
		  font-weight:bold;'>Edit Profile</button>
   		  </a></p></div>
		  </div>";
	
// SORT BY DropDown
	echo "<div class='datatable-sections'>
		  <form action='$pgm' method='POST'>
	      SORT BY <select name='sort' onchange='this.form.submit()'>
		  <option>Select</option>";
	foreach($sorts as $value){
		if ($value == $sort) $se='SELECTED';  else $se = NULL;
		echo "<option $se>$value</option>\n";
		}
	echo "</select>
		  Order<select name='sortdirection' onchange='this.form.submit()'>
		  <option>Select</option>";
	foreach($sortchoices as $choice){
		if ($choice == $sortdirection) $se='SELECTED';  else $se = NULL;
		echo "<option $se>$choice</option>\n";
		}
	echo "</select></form>";	



// Output student information 
	echo "<table class='datatable'>
		  	<thead>
		  		<tr id='title'><th colspan='8'>Your $course Roster</th></tr>
				<tr>
					<th>First Name</td>
					<th>Last Name</td>
					<th>ID</td>
					<th>Email</td>
					<th>Assignment</td>
					<th>Submitted</td>
					<th>Grade</td>
					<th>Submssion</th>
					<th style= 'display: none''></td>
				</tr>
			<thead>";
	while(list($userid, $assignid, $firstname, $lastname, $id, $email, $assignment, $submitted, $grade, $submission) = mysqli_fetch_row($result)) {
		// Selects color to student grades
		switch($grade) {
			case $grade >= 90: 	$letter = 'A'; break;
			case $grade >= 80: 	$letter = 'B'; break;
			case $grade >= 70:	$letter = 'C'; break;
			case $grade >= 65: 	$letter = 'D'; break;
			case $grade < 65: 	$letter = 'F'; break;
			default: 			$letter = 'B'; break;	// default is black
		}
		// Sets color based on $grades array
		$color = $grades[$letter];

		echo "<tbody>
			  	<tr>
					<td>$firstname</td>
					<td>$lastname</td>
					<td>$id</td>
					<td><a href='mailto:$email'>$email</a></td>
					<td>$assignment</td>
					<td>$submitted</td>
					<td><span style='color: $color'>$grade</span></td>
					<form action='$pgm' method='POST' enctype='multipart/form-data'>";
					// provides option view an assignment based on whether one was submitted already by the student
					if ($submission == NULL) {
						echo "
							  <td>$submission</td>";
					}
					else {
						echo "<input type='hidden' name='pathname' value='$submission'>
							  <td style='background-color: lightgreen;'><input type='submit' name='task' value='View submisson'></td>";
					}
					echo "<td class='button-column'><a href='table_update.php?r=$userid&r2=$assignid'>EDIT GRADE</a></td>
					</form>
			    </tr>
			  </tbody>";
		}


	echo "</table>";
	echo "<form action='$pgm' method='POST' enctype='multipart/form-data'>
			<br><table>
				<tr><td $bold>Add new assignment</td>
				<td><input type='text' name='assignment'  value='' size='25'></td>
				<td> <input type='submit' name='task' value='Add'></td></tr>
			</table>
		  </form>";

		  if ($task == 'View submisson') {
			$extension = pathinfo($pathname, PATHINFO_EXTENSION);
			if ($extension == 'pdf') {
				echo "<embed src='$pathname' width='100%'' height='1200px'>";
			}
			else {
				echo "<iframe src='$pathname' width='100%' height='600px' frameborder='0'></iframe>";
			}
		  }

	if ($msg) echo "<p>Message: <span style='color:$msg_color'>$msg</span></p>";
	echo "</div></div>";
	
		  
	include('footer.php');
?>