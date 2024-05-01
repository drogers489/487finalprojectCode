<?php 
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");

verify_admin_login();
new_header("Administrator Homepage", "adminhome.php"); 

$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
	echo $output;
}

if (isset($_GET["id"]) && $_GET["id"] !== "") {
	$delete_query = "DELETE FROM profLogin WHERE id=?";
	$stmt = $mysqli->prepare($delete_query);
	$stmt->execute([$_GET['id']]);

	if ($stmt) {
		$_SESSION["message"] = "Successfully deleted user.";

	} else {
		$_SESSION["message"] = "Unable to delete user.";
	}		
} else {
	$_SESSION["message"] = "User could not be found!";
}

redirect("add_prof.php");	
Database::dbDisconnect();
?>