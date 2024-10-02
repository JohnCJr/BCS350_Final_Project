<?php
// update_profile.php - Update user profile
// Edited by: John Cabanas, November 2023
// Notes: clicking the change button uploads the file to mysql


// Include
include('header.php');



	
// Variables
	$pgm		= 'update_profile.php'; 
	$pgm2		= ($_SESSION['role'] == 'Student') ? 'student.php' : 'faculty.php';
	$table		= ($_SESSION['role'] == 'Student') ? 'student' : 'staff'; 
    $dir        = ($_SESSION['role'] == 'Student') ? 'profile pictures/student' : 'profile pictures/faculty';
    $rowid      = $_SESSION['id'];
    $where      = ($_SESSION['role'] == 'Student') ? "studentid = '$rowid'" :  "staffid = '$rowid'";
	$bold		= "style='font-weight:bold;'";
	$center		= "align='center'";
	$msg		= NULL;
	$msg_color	= 'black';
	$columns	= array('firstname', 'lastname', 'email', 'password', 'photo');
	$maxsize    = 25000000;
	$extns = array('.jpg', '.jpeg', '.gif', '.png', '.webp');

// Get Input
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	foreach($columns as $value) 
		if (isset($_POST[$value])) 		${$value} 		= sanitize($mysqli, $_POST[$value]);		else ${$value} = NULL;
	if (isset($_POST['task']))  		$task 			= sanitize($mysqli, $_POST['task']);  		else $task  = 'Show';
		
	

// Verify Input
	if (($task == 'Change')) {
        // Password field
		if ($password == NULL) $msg .= 'password is missing<br>';
        // Email		
		if (($email != NULL) AND (!filter_var($email, FILTER_VALIDATE_EMAIL)))
			$msg .= 'Invalid Email Address<br>';
        if ($email == NULL) 
        $msg .= 'email address is missing<br>';
        if ($msg != NULL) $task = 'Error';
    }

// Process Input
switch($task) {
    case 'Error':	$msg_color = 'red';
	case 'Show':
		$query = "SELECT firstname, lastname, email, password, photo
				  FROM $table
				  WHERE $where";
		$result = mysqli_query($mysqli, $query);
		if (!$result) echo "Query failed [$query]  " . mysqli_error($mysqli); 

		if (mysqli_num_rows($result) < 1) {
			$msg .= "ROWID $rowid not found."; 
			$msg_color='red'; 
			$firstname = $lastname = $email = $password = $photo = NULL;
			}
		else {
			list($firstname, $lastname, $email, $password, $photo) = mysqli_fetch_row($result); 
			$msg .= "Data Found";
			} 
		break;
    
	case 'Change':
		$query = "UPDATE $table SET
				  email	        = UPPER('$email'),
				  password		= '$password'";
		// Uploads an image file and gives it the name of the rowid associated with the user
        if (isset($_FILES['photo']['tmp_name'])) {
            list($rc, $filename) = upload('photo', $dir, $rowid, $extns, $maxsize);
            if ($rc == 0) { 
                $query .= ", photo = '$filename'";
            }
        }
        $query .= " WHERE $where";
		$result = mysqli_query($mysqli, $query);
		if (!$result) {
			$msg = "QUERY failed [$query]: " . mysqli_error($mysqli);
			$msg_color = 'red';
			}
		else $msg = "Data Updated";

		// assigns newly added photo to $photo variable
		$query = "SELECT photo FROM $table WHERE $where";
		$result = mysqli_query($mysqli, $query);
		if (!$result) echo "QUERY [$query]: " . mysqli_error($mysqli);
		list($photo) = mysqli_fetch_row($result);

        break;
	default:
    }	

	// sets default image to view
	if ($photo == NULL) $photo = 'profile pictures/default.png';


// Output
	echo "<h1 align='center'>Profile Update</h1>";
	echo "<form action='$pgm' method='POST' enctype='multipart/form-data'>
		  <div class='data-container'><table class='user-info'>
		  <tr><td $bold>First Name</td>
			  <td><input type='text' name='firstname'  value='$firstname' size='15' readonly>*</td></tr>  
		  <tr><td $bold>Last Name</td>
			  <td><input type='text' name='lastname'  value='$lastname' size='15' readonly>*</td></tr>
		  <tr><td $bold>Email</td>
			  <td><input type='email' name='email' value='$email' size='60'></td></tr>
		  <tr><td $bold>Password</td>
			  <td><input type='password' name='password'  value='$password' size='15'></td></tr>
		  <tr><td $bold>Profile Picture</td> <td><img src='$photo' width='200'></td>
		  <tr><td $bold>Upload Photo</td>
		  	   <td><input type='file' name='photo'>
		 </table></div>" ;
		  
// Action Bar
    echo "<p>
		  <input type='submit' name='task' value='Change' style='background-color:orange;font-weight:bold;'>
		  </td></tr></table></form>
		  <p><a href='$pgm2'><button style='color:white; background-color:green; font-weight:bold;'>RETURN</button></a>";
	
// Message
    echo "<p><table><tr>
		  <td $bold>MESSAGE: </td>
		  <td style='color:$msg_color;'>$msg</td>
		  </tr></table>"; 
		  
// End of Program
include('footer.php');
?>