<?php 
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
verify_prof_login();

new_header("Log Out"); 
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
	echo $output;
}

session_destroy();
redirect("displaycourses.php");
Database::dbDisconnect();
?>
