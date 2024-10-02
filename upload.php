<?php
// File Upload Function
// Written by Charles Kaplan, November 2015

// INPUTS
// $input 		- HTML INPUT element name for uploaded file
// $dir 		- Directory for uploaded file
// $filename	- Filename for uploaded file
// $extns		- Valid extensions for uploaded file (array)
// $maxsize		- Maximum file size of uploaded file

// Outputs
// 1st Parameter - Error Code, 0 = Success, >0 = Failure
// 2nd Parameter - dir/filename.ext of saved file or Error Message 	 	

function upload($input, $dir, $file, $extns, $maxsize) {
	$msg = NULL;
	$rc = 0;
	if (isset($_FILES[$input]['tmp_name'])) {
		if (is_uploaded_file($_FILES[$input]['tmp_name'])) {
			$fn = $_FILES[$input]['name'];
			$ext = trim(strtolower(strrchr($fn, '.')));	// gets the extention of the field
			if (!in_array($ext, $extns)) // checks if extention is in array of valid extentions
				{$msg = "Invalid File Type"; $rc = 10;}
			if ($_FILES[$input]['size'] > $maxsize) 
				{$msg = "Uploaded file size [" . $_FILES[$input]['size'] . "] exceeds limit [$maxsize]"; $rc = 11;}
			if (substr($dir, -1, 1) != '/') $dir .= '/';	// if directory entered doesn't have a / then it is added to the end to make it look like a directory
			if (!is_dir($dir)) 
				{$msg = "Invalid Directory [$dir]"; $rc = 13;}
			$savefile = $dir . strtolower($file) . $ext;
			if ($rc == 0) {
				$result = move_uploaded_file($_FILES[$input]['tmp_name'], $savefile);
				if ($result > 1)
					{$msg = "Move Uploaded File Failed"; $rc = $result;}
				}
			}
		else {$msg = "No Uploaded File"; $rc = 12;}
		}
	else {$msg = "No Uploaded File"; $rc = 12;}
	
	if ($rc == 0) 	return(array($rc, $savefile));
	else 			return(array($rc, $msg));
	}
?>