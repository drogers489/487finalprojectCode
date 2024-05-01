<?php
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
ini_set("display_errors", 1);
error_reporting(E_ALL);

new_header("Current CSCI/CIS Courses");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (($output = message()) !== null) {
	echo $output;
}

if (isset($_POST["submit"])) {
	if ((isset($_POST["username"]) && $_POST["username"] !== "") && (isset($_POST["password"]) && $_POST["password"] !== "")) {

		$username = $_POST['username'];
		$password = $_POST['password'];

		$stmt1 = $mysqli->prepare("SELECT * FROM adminLogin WHERE username LIKE ?");
		$stmt1->execute([$username]);

		if ($stmt1){
			while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
				if (password_check($_POST['password'],$row['hashed_password']) == True){
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['admin'] = $row['id'];
					redirect('adminhome.php');
				} else {
					$_SESSION['message'] = "Username/Password not found";
					redirect('admin_login.php');
				}
			}
		} else {
			$_SESSION['message'] = "Username/Password not found";
			redirect('admin_login.php');
		}
	}
} else {

echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";

echo "<h3>Administrator Login</h3>";

echo "<form action='admin_login.php' method='post'>
<p>Username:<input type='text' name='username' value='' /> </p>
<p>Password: <input type='password' name='password' value='' /> </p>
<input type='submit' name='submit' value='Log In' />
</form>";

echo "</div>";
echo "</label>";
}

Database::dbDisconnect();
?>