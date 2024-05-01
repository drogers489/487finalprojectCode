
<?php
	function redirect($new_location) {
		header("Location: " . $new_location);
		exit;
	}
	// color=#14213d
	function new_header($name="", $urlLink="displaycourses.php") {
		echo "<head>";
		echo "	<title>$name</title>";
		//		<!-- Link to Foundation -->";
		echo "	<link rel='stylesheet' href='css/normalize.css'>";
		echo "	<link rel='stylesheet' href='css/foundation.css'>";
		echo "<script src='js/vendor/modernizr.js'></script>";
		echo "</head>";
		echo "<body>";
		echo "<div class='contain-to-grid sticky'>";
		echo "<nav class='top-bar' data-topbar data-options='sticky_on: large'>";
		echo "<ul class='title-area'>";
		echo "<li class='name'>";
		//replace /~dfroger1/487/ with new directory if rehosting
		echo "  <h1 align='left'><a href='/~dfroger1/487/".$urlLink."'>$name</a></h1>";
		echo "</li>";
		echo "</ul>";
		echo "</nav>";
		echo "</div>";	
	}

	function new_loginheader($name="", $urlLink="displaycourses.php") {
		echo "<head>";
		echo "	<title>$name</title>";
		//		<!-- Link to Foundation -->";
		echo "	<link rel='stylesheet' href='css/normalize.css'>";
		echo "	<link rel='stylesheet' href='css/foundation.css'>";
		echo "<script src='js/vendor/modernizr.js'></script>";
		echo "</head>";
		echo "<body>";
		echo "<div class='contain-to-grid sticky'>";
		echo "<nav class='top-bar' data-topbar data-options='sticky_on: large'>";
		echo "<ul class='title-area'>";
		echo "<li class='name'>";
		//replace /~dfroger1/487/ with new directory if rehosting
		echo "  <h1 align='left'><a href='/~dfroger1/487/".$urlLink."'>$name</a></h1>";
		echo "</li>";
		echo "</ul>";
		echo "<section class='top-bar-section'>";
		echo "<ul class='right'>";
		echo "<li><a href='admin_login.php' class='button'>Admin Login</a></li>";
		echo "<li><a href='prof_login.php' class='button'>Professor Login</a></li>";
		echo "</ul>";
		echo "</section>";
		echo "</nav>";
		echo "</div>";	
	}

	function password_encrypt($password) {
		$hash_format = "$2y$10$";   // Use Blowfish with a "cost" of 10
		$salt_length = 22; 					// Blowfish salts should be 22-characters or more
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	  }
	  
	  function generate_salt($length) {
		// MD5 returns 32 characters
		$unique_random_string = md5(uniqid(mt_rand(), true));
		
		// Valid characters for a salt are [a-zA-Z0-9./]
		$base64_string = base64_encode($unique_random_string);
		
		// Replace '+' with '.' from the base64 encoding
		$modified_base64_string = str_replace('+', '.', $base64_string);
		
		// Truncate string to the correct length
		$salt = substr($modified_base64_string, 0, $length);
		
		  return $salt;
	  }
	  
	  function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
		$hash = crypt($password, $existing_hash);
		if ($hash === $existing_hash) {
		  return true;
		} 
		else {
		  return false;
		}
	  }
	
?>
