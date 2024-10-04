<?php
// administrator.php - Administrator Page 
// Written by: John Cabanas, 2023

// Include
include('header.php');

// Initialize variables
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// redirects if not an Admin
if ($role != 'Administrator') {
    if ($role == 'Teacher') {
        header('Location: faculty.php');
        exit();
    }
    if ($role == 'Student') {
        header('Location: student.php');
        exit();
    } else {
        header('Location: homepage.php');
        exit();
    }
}

// Variables
$pgm = 'administrator.php';
$pgm2 = 'update_profile.php';
$table = 'student';
$table2 = 'staff';
$msg = null;
$msg_color = null;
$currentid = $_SESSION['id']; // current user's ID
$bold = "style='font-weight:bold;'";
$sorts = array('firstname', 'lastname', 'id', 'email', 'userid');
$sortchoices = array('DESC', 'ASC');
$maxw = 100;
$maxh = 100;

// Get photo and email from staff table for the staff member currently logged in
$stmt = $mysqli->prepare("SELECT photo, email FROM $table2 WHERE staffid = ?");
$stmt->bind_param("i", $currentid); 
$stmt->execute();
$stmt->bind_result($profilepic, $contact);
$stmt->fetch();
$stmt->close();

// Directory for faculty profile pictures
$dir = urlencode('profile pictures/faculty');

// Default profile picture if none exists
if ($profilepic == NULL) {
    $profilepic = "$dir/default.jpg"; // Encoded directory used here
}

// Get user inputs and assigns default value if no input was set
$sort = isset($_POST['sort']) ? sanitize($mysqli, $_POST['sort']) : 'Select';
if ($sort == 'Select') $sort = null;
$sortdirection = isset($_POST['sortdirection']) ? $_POST['sortdirection'] : 'Select';
if ($sortdirection == 'Select') $sortdirection = null;

// Process Input Sort
switch ($sort) {
    case 'firstname': $sortby = 'firstname'; break;
    case 'lastname': $sortby = 'lastname'; break;
    case 'id': $sortby = 'id'; break;
    case 'email': $sortby = 'email'; break;
    case 'userid': $sortby = 'userid'; break;
    default: $sortby = 'firstname, lastname'; break;
}
$sortby = 'ORDER BY ' . $sortby . ' ' . $sortdirection;

// Outputs user Profile Picture and name
echo "<h1 $bold id='welcomemessage'>Welcome " . htmlspecialchars($user, ENT_QUOTES, 'UTF-8') . "</h1>
      <div class='data-container'>
      <div class='profile-container'>
      <div class='profile'>
        <p id='name'>" . htmlspecialchars($user, ENT_QUOTES, 'UTF-8') . "</p>
        <p id='role'>" . htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8') . "</p>";

echo "<img src='" . htmlspecialchars($profilepic, ENT_QUOTES, 'UTF-8') . "' width='200'/>
      <p id='user-contact'>" . htmlspecialchars($contact, ENT_QUOTES, 'UTF-8') . "</p>";
echo "<p><a href='$pgm2'><button style='color:white; background-color:green; font-weight:bold;'>Edit Profile</button></a></p>
      </div></div>";

// Query for student data
$stmt = $mysqli->prepare("SELECT studentid, firstname, lastname, id, email, userid, photo FROM $table $sortby");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
    $msg .= "Student data not found.";
    $msg_color = 'red';
} else {
    $msg .= "Student data found.";
}

// SORT BY DropDown
echo "<div class='table-seperator'>
      <div class='datatable-sections'>
      <form action='$pgm' method='POST'>
      SORT BY <select name='sort' onchange='this.form.submit()'>
      <option>Select</option>";
foreach ($sorts as $value) {
    $se = ($value == $sort) ? 'SELECTED' : NULL;
    echo "<option $se>" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "</option>\n";
}
echo "</select>
      Order <select name='sortdirection' onchange='this.form.submit()'>
      <option>Select</option>";
foreach ($sortchoices as $choice) {
    $se = ($choice == $sortdirection) ? 'SELECTED' : NULL;
    echo "<option $se>" . htmlspecialchars($choice, ENT_QUOTES, 'UTF-8') . "</option>\n";
}
echo "</select></form>";

// Output student information
echo "<table class='datatable'>
      <thead>
      <tr id='title'><th colspan='6'>Student Roster</th></tr>
      <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>ID</th>
          <th>Email</th>
          <th>UserID</th>
          <th>Photo</th>
      </tr>
      </thead>";
while ($row = $result->fetch_assoc()) {
    echo "<tbody>
          <tr>
              <td>" . htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8') . "</td>
              <td>" . htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8') . "</td>
              <td>" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "</td>
              <td><a href='mailto:" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</a></td>
              <td>" . htmlspecialchars($row['userid'], ENT_QUOTES, 'UTF-8') . "</td>";
    if ($row['photo'] == NULL) {
        echo "<td><img src='" . urlencode('profile pictures/default.jpg') . "' width='100'></td>";
    } else {
        echo "<td><img src='" . htmlspecialchars($row['photo'], ENT_QUOTES, 'UTF-8') . "' width='100'></td>";
    }
    echo "</tr></tbody>";
}
echo "</table></div>";

// Create a query to obtain teacher information
$stmt = $mysqli->prepare("SELECT staffid, firstname, lastname, id, email, userid, photo FROM $table2 WHERE staffid <> ? $sortby");
$stmt->bind_param("i", $currentid); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
    $msg .= " Faculty data not found.";
    $msg_color = 'red';
} else {
    $msg .= " Faculty data found.";
}

// Output teacher's student information
echo "<div class='datatable-sections'>
      <table class='datatable'>
      <thead>
      <tr id='title'><th colspan='7'>Your $course Roster</th></tr>
      <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>ID</th>
          <th>Email</th>
          <th>UserID</th>
          <th>Photo</th>
      </tr>
      </thead>";
while ($row = $result->fetch_assoc()) {
    echo "<tbody>
          <tr>
              <td>" . htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8') . "</td>
              <td>" . htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8') . "</td>
              <td>" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "</td>
              <td><a href='mailto:" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</a></td>
              <td>" . htmlspecialchars($row['userid'], ENT_QUOTES, 'UTF-8') . "</td>";
    if ($row['photo'] == NULL) {
        echo "<td><img src='" . urlencode('profile pictures/default.jpg') . "' width='100'></td>";
    } else {
        echo "<td><img src='" . htmlspecialchars($row['photo'], ENT_QUOTES, 'UTF-8') . "' width='100'></td>";
    }
    echo "</tr></tbody>";
}
echo "</table></div>";

if ($msg) echo "<p>Message: <span style='color:" . htmlspecialchars($msg_color, ENT_QUOTES, 'UTF-8') . "'>$msg</span></p>";

include('footer.php');
?>