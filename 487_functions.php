
<?php
	function redirect($new_location) {
		header("Location: " . $new_location);
		exit;
	}
	// color=#14213d
	function new_header($name="Donald Rogers", $urlLink="CourseDisplayPage.php") {
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
		echo "  <h1 align='left'><a href='/~dfroger1/".$urlLink."'>$name</a></h1>";
		echo "</li>";
		echo "</ul>";
		echo "</nav>";
		echo "</div>";	
	}

	function new_loginheader($name="Donald Rogers", $urlLink="CourseDisplayPage.php") {
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
		echo "  <h1 align='left'><a href='/~dfroger1/".$urlLink."'>$name</a></h1>";
		echo "</li>";
		echo "</ul>";
		echo "<section class='top-bar-section'>";
		echo "<ul class='right'>";
		echo "<li><a href='adminhome.php' class='button'>Admin Login</a></li>"; //change to admin_login.php once finished setting up login system
		echo "<li><a href='addremsyllabusprof.php' class='button'>Professor Login</a></li>"; //change to prof_login.php once finished setting up login
		echo "</ul>";
		echo "</section>";
		echo "</nav>";
		echo "</div>";	
	}

	function new_footer($name="Donald Rogers"){
		date_default_timezone_set("America/Chicago");
		echo "<br /><br /><br />";
	    echo "<h4><div class='text-center'><small>Copyright {$name}".date("M Y").", ".$name."</small></div></h4>";
		echo "</body>";
		echo "</html>";
	}	
	
	function print_alert($name="") {
		echo "<br />";
		echo "<div class='row'>";
		echo "<div data-alert class='alert-box info round'>".$name;
		
		echo "</div>";
		echo "</div>";
		
	}
	
?>
