<?PHP
// logoff.php - Logoff
// Written by:  John Cabanas, November 2023

// Include
include('header.php');

// Logoff by Unsetting Session Variables and Destroying the Session ID
	session_unset();
	session_destroy();
	$logon = FALSE;
	$user = 'visitor'; 
	$role = NULL;
  
// Output	
	echo "<div id='logoff-img-container'>
			<img id='logoff-img' src='images/exit.png' alt='open door with arrow'>
		  	<p id='countdown'></p>
		  </div>
		  <script>

		  var countdown = 3;

		  function updateCountdown() {
			  document.getElementById('countdown').innerText = 'LOGOFF Successful, Redirecting to home page in ' + countdown + ' seconds';
			  if (countdown > 0) {
				  countdown--;
				  setTimeout(updateCountdown, 1000);
			  } else {
				  window.location.href = 'homepage.php';
			  }
		  }
		  
		  updateCountdown();
		 </script>";
	include('footer.php');
?>