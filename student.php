<?php
// student.php - Student Page 
// Written by:  John Cabanas, 2023


// Include
include('header.php');


// redirects if not a student
	$role = $_SESSION['role'];
	if ($role != 'Student') {
		if ($role == 'Administrator') {
			header('Location: administrator.php' );
			exit();
		}
		if ($role == 'Teacher') {
			header('Location: faculty.php' );
			exit();
		}
		else {
			header('Location: homepage.php' );
	 	    exit();
		}
	}
	
// Variables
	$pgm				= 'student.php'; 
	$pgm2				= 'update_profile.php'; 
	$table				= 'student'; 
	$currentid          = $_SESSION['id'];
	$bold				= "style='font-weight:bold;'";
	$classes			= array("Pre-Calculus", "Chemistry", "U.S History");
	$grades				= array("A" => "green","B" => "black","C" => "darkyellow","D" => "orange", "F" => "red");
	$sorts				= array('classname', 'assignmentname', 'submitted', 'grade');
	$sortchoices        = array ('DESC', 'ASC');
	$msg                = NULL;
	$msg_color          = 'black';
	$maxsize            = 25000000;
	$extns              = array('.pdf', '.docx', '.pages', '.doc');
	$dir                = 'assignments';

//--------------------------------------------------------------------------------------------------------------------------------------

// Get user input for category, sort, assignmentid, and task
    if (isset($_POST['assignmentid']))  		$assignid           = sanitize($mysqli, $_POST['assignmentid']);  	    else $assignid  = NULL;
	if (isset($_POST['pathname']))  		    $pathname           = sanitize($mysqli, $_POST['pathname']);  	        else $pathname  = NULL;
    if (isset($_POST['task']))  		        $task 			    = sanitize($mysqli, $_POST['task']);  		        else $task  = NULL;
	if (isset ($_POST['classname']))            $class              = sanitize($mysqli, $_POST['classname']);           else $class = NULL;
	if ($class == 'All')                        $class              = NULL;
	if (isset ($_POST['sort']))                 $sort               = $_POST['sort'];                                   else $sort = 'Select';
	if ($sort == 'Select')                      $sort               = NULL;
	if (isset($_POST['sortdirection']))  	    $sortdirection      = $_POST['sortdirection']; 						else $sortdirection = 'Select';
	if ($sortdirection == 'Select')             $sortdirection      = NULL;
	

	
	// Get photo from student table for student currently logged in and sets the $profilepic and $contactvariable
	$where = " WHERE $table.studentid = $currentid ";
	$query = "SELECT photo, email
			  FROM $table 
			  $where";
	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "QUERY [$query]: " . mysqli_error($mysqli);
	list($profilepic, $contact) = mysqli_fetch_row($result);    


	// Outputs user Profile Picture and name
	echo "<h1 $bold id='welcomemessage'> Welcome $user</h1>
		  <div class='data-container'>
			<div class='profile-container'>
				<div class='profile'> 
					<p id='name'>$user</p>
					<p id='role'>$_SESSION[role]</p>";

	if ($profilepic == NULL) {
		$profilepic = 'profile pictures/default.jpg';
	}

	echo "          <img src='$profilepic' width='200'/>
					<p id='user-contact'>$contact</p>
					<p><a href='$pgm2'><button style='color:white; background-color:green; font-weight:bold;'>Edit Profile</button></a></p>
				</div>
		    </div>";

	
	// Process class input
	if ($class != NULL) $where = " WHERE class.classname = '$class' AND $table.studentid = $userid";
	else $where = " WHERE $table.studentid = $userid";
	
	// Process sort input
	switch($sort) {
		case 'classname': 	$sortby = 'classname'; break;
		case 'assignmentname': 	$sortby = 'assignmentname'; break;
		case 'submitted':	$sortby = 'submitted'; break;
		case 'grade': 		$sortby = 'studentassignment.grade'; break;
		default: 			$sortby = 'classname, assignmentname'; break;
	}
	$sortby = 'ORDER BY ' . $sortby . ' ' . $sortdirection;
	
	
	// Uploads assignment to studentassignment table
	if ($task == 'Upload'){
		if (isset($_FILES['document']['tmp_name']) && ($assignid != NULL)) {
			list($rc, $filename) = upload('document', $dir, "$userid-$assignid", $extns, $maxsize);
			if ($rc == 0) { 
				$query = "UPDATE studentassignment SET submission = '$filename' 
				          WHERE studentid = '$userid' AND assignmentid = '$assignid'";
				$result = mysqli_query($mysqli, $query);
				if (!$result) { 
					$msg = "File Uploaded Successfully.  RC: $rc userid: $userid";
				}
			}
			else {
				$msg = "File Uploaded Failed, RC = $rc, $filename";
				$msg_color = 'red';
			}
		}
		if (!isset($_FILES['document']['tmp_name'])) {
			$msg .= 'Please upload a document if you wish to sybmit an assignment<br>';
		}
	}


	
	// Create a query using JOIN to gather all relevant data
	$query = "SELECT class.classname, assignment.assignmentname,
					 staff.firstname, staff.lastname, staff.email, 
					 studentassignment.submitted, studentassignment.grade, 
					 assignment.assignmentid, studentassignment.submission
	          FROM $table 
			  INNER JOIN studentassignment ON $table.studentid = studentassignment.studentid
			  INNER JOIN assignment ON studentassignment.assignmentid = assignment.assignmentid
			  INNER JOIN class ON assignment.classid = class.classid
			  INNER JOIN staff ON class.staffid = staff.staffid
			  $where 
			  $sortby";
	
	// Execute the Query
	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "QUERY [$query]: " . mysqli_error($mysqli);
	

// CATEGORY DropDown
	echo "<div class='datatable-sections'>
		  	<form action='$pgm' method='post'>
		  	CLASS <select name='classname' onchange='this.form.submit()'>
		  		   <option>All</option>";
	foreach($classes as $key) {
		if ($key == $class) $se='SELECTED'; else $se = NULL;
		echo "     <option $se>$key</option>\n";
		}
	echo "       </select></p>";
	
// SORT BY DropDown
	echo " SORT BY <select name='sort' onchange='this.form.submit()'>
				   	<option>Select</option>";
	foreach($sorts as $value) {
		if ($value == $sort) $se='SELECTED';  else $se = NULL;
		echo "		<option $se>$value</option>\n";
		}
	echo "			</select>
					Order<select name='sortdirection' onchange='this.form.submit()'>
					<option>Select</option>";
	foreach($sortchoices as $choice){
		if ($choice == $sortdirection) $se='SELECTED';  else $se = NULL;
			  echo "<option $se>$choice</option>\n";
	}
	echo "</select></form>";	
		
// Output table		
	echo "<table class='datatable'>
			<thead>
				<tr id='title'><th colspan='7'>Your Grades</th></tr>
		  		<tr>
					<th>Class</th>
					<th>Teacher</th>
					<th>Email</th>
					<th>Assignment</th>
					<th>Submitted</th>
					<th>Grade</th>
					<th>Submit</th>
				</tr>
			<thead>";
	while(list($classname, $assignmentname, $tfirstname, $tlastname, $email, $submitted, $grade, $assignmentid, $submission) = mysqli_fetch_row($result)) {
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
				  <td>$classname</td>
				  <td>$tfirstname $tlastname</td>
				  <td><a href='mailto:$email'>$email</a></td>
				  <td>$assignmentname</td>
				  <td>$submitted</td>
				  <td><span style='color: $color'>$grade</span></td>
				  <td><form action='$pgm' method='POST' enctype='multipart/form-data'>";
				// provides option to either submit or view an assignment based on whether one was submitted already
				if ($submission == NULL) {
					echo "<input type='hidden' name='assignmentid' value='$assignmentid'>
				          <td style='background-color: lightgreen;'><input type='file' name='document'>
						  <input type='submit' name='task' value='Upload'</td>";
				}
				else {
					echo "<input type='hidden' name='pathname' value='$submission'>
					      <td style='background-color: lightgreen;'><input type='submit' name='task' value='View submisson'></td>";
				}
				  
		echo "   </form>
			   </tr>
			  </tbody>";
	}

	echo "</table></div></div>";

	if ($task == 'View submisson') {
		$extension = pathinfo($pathname, PATHINFO_EXTENSION);
		if ($extension == 'pdf') {
			echo "<embed src='$pathname' width='100%'' height='1200px'>";
	    }
		else {
			echo "<iframe src='$pathname' width='100%' height='600px' frameborder='0'></iframe>";
		}
	}

	// Message
    echo "<p><table><tr>
		  <td $bold>MESSAGE: </td>
		  <td style='color:$msg_color;'>$msg</td>
		  </tr></table>"; 
	
	include('footer.php');
?>