<?php
// administrator.php - Administrator Page 
// Written by:  John Cabanas, 2023


// Include
include('header.php');


// redirects if not an Admin
	if ($role != 'Administrator') {
		if ($role == 'Teacher') {
			header('Location: faculty.php' );
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
	$pgm				= 'administrator.php'; 
	$pgm2				= 'update_profile.php'; 
	$table				= 'student';
	$table2             = 'staff';
	$msg			    = NULL;
	$msg_color			= NULL;
	$currentid             = $_SESSION['id'];	// current user's ID
	$bold				= "style='font-weight:bold;'";
	$sorts				= array ('firstname', 'lastname', 'id', 'email', 'userid');
	$sortchoices        = array ('DESC', 'ASC');
    $dir                = 'profile pictures/faculty';
    $maxw 				= 100;
    $maxh 				= 100;
	$where              = "WHERE $table2.staffid = $currentid";
   
	
// Get photo from staff table for staff member currently logged in and sets the $profilepic variable
$query = "SELECT photo, email
	      FROM $table2
		  $where";
$result = mysqli_query($mysqli, $query);
if (!$result) echo "QUERY [$query]: " . mysqli_error($mysqli);
list($profilepic, $contact) = mysqli_fetch_row($result);


// Get user inputs and assigns default value if no input was set
	if (isset ($_POST['sort']))             $sort               = sanitize($mysqli, $_POST['sort']);            else $sort = 'Select';
	if ($sort == 'Select')                  $sort               = NULL;
	if (isset($_POST['sortdirection']))  	$sortdirection      = $_POST['sortdirection']; 						else $sortdirection = 'Select';
	if ($sortdirection == 'Select')         $sortdirection      = NULL;
	

// Process Input Sort
	switch($sort) {
		case 'firstname': 	$sortby = 'firstname'; break;
		case 'lastname': 	$sortby = 'lastname'; break;
		case 'id': 		    $sortby = 'id'; break;
		case 'email': 		$sortby = 'email'; break;
		case 'userid':      $sortby = 'userid'; break;
		default: 			$sortby = 'firstname, lastname'; break;
	}
	$sortby = 'ORDER BY ' . $sortby . ' ' . $sortdirection;


	// Outputs user Profile Picture and name
	echo " <h1 $bold id='welcomemessage'> Welcome $user</h1>
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

    
	// query for student data
    $query = "SELECT studentid, firstname, lastname, id, email, userid, photo
              FROM $table 
              $sortby";

	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "Query failed [$query]  " . mysqli_error($mysqli); 

	if (mysqli_num_rows($result) < 1) {
		$msg .= "Student data not found."; 
		$msg_color ='red'; 
		$studentid = $firstname = $lastname = $id = $email = $userid = $photo = NULL;
	}
	else {
		$msg .= "student data found";
	} 

	// SORT BY DropDown
	echo "<div class='table-seperator'>
		   <div class='datatable-sections'>
			<form action='$pgm' method='POST'>
			SORT BY <select name='sort' onchange='this.form.submit()'>
			<option>Select</option>";
	foreach ($sorts as $value) {
		if ($value == $sort) $se = 'SELECTED'; else $se = NULL;
		echo "<option $se>$value</option>\n";
	}
	echo "</select>
		Order<select name='sortdirection' onchange='this.form.submit()'>
		<option>Select</option>";
	foreach ($sortchoices as $choice) {
		if ($choice == $sortdirection) $se = 'SELECTED'; else $se = NULL;
		echo "<option $se>$choice</option>\n";
	}
	echo "</select></form>";

	// Output student information
	echo "<table class='datatable'>
		<thead>
		<tr id='title'><th colspan='6'>Student Roster</th></tr>
		<tr>
			<th>First Name</td>
			<th>Last Name</td>
			<th>ID</td>
			<th>Email</td>
			<th>UserID</td>
			<th>Photo</td>
		</tr>
	</thead>";
	while (list($studentid, $firstname, $lastname, $id, $email, $userid, $photo) = mysqli_fetch_row($result)) {
	echo "<tbody>
		<tr>
			<td>$firstname</td>
			<td>$lastname</td>
			<td>$id</td>
			<td><a href='mailto:$email'>$email</a></td>
			<td>$userid</td>";
			if ($photo == NULL) echo "<td><img src='profile pictures/default.jpg' width='100'></td>"; 
			else echo" <td><img src='$photo' width='100'></td>";
		echo "</tr>
	</tbody>";
	}
	echo "</table></div>";  // Close the first datatable-sections div

	// Create a query to obtain teacher information
	$query = "SELECT staffid, firstname, lastname, id, email, userid, photo
			  FROM $table2
			  WHERE staffid <> $currentid
			  $sortby";

	// Execute the query to obtain teacher information
	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "Query failed [$query]  " . mysqli_error($mysqli);

	if (mysqli_num_rows($result) < 1) {
		$msg .= " Faculty data not found.";
		$msg_color = 'red';
		$staffid = $firstname = $lastname = $id = $email = $userid = $photo = NULL;
	} else {
		$msg .= ", Faculty data found";
	}

	// Output teacher's student information
	echo "<div class='datatable-sections'>
	<table class='datatable'>
		<thead>
		<tr id='title'><th colspan='7'>Your $course Roster</th></tr>
		<tr>
			<th>First Name</td>
			<th>Last Name</td>
			<th>ID</td>
			<th>Email</td>
			<th>UserID</td>
			<th>Photo</td>
		</tr>
	</thead>";
	while (list($staffid, $firstname, $lastname, $id, $email, $userid, $photo) = mysqli_fetch_row($result)) {
	echo "<tbody>
			<tr>
				<td>$firstname</td>
				<td>$lastname</td>
				<td>$id</td>
				<td><a href='mailto:$email'>$email</a></td>
				<td>$userid</td>";
				if ($photo == NULL) echo "<td><img src='profile pictures/default.jpg' width='100'></td>"; 
				else echo" <td><img src='$photo' width='100'></td>";
			echo "</tr>
		</tbody>";
	}
	echo "</table></div></div></div>";

	if ($msg) echo "<p>Message: <span style='color:$msg_color'>$msg</span></p>";

	include('footer.php');

?>