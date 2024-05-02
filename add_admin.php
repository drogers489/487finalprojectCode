<?php
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
//verify_admin_login();

$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
new_header("Administrator Homepage", "adminhome.php"); 

if (($output = message()) !== null) {
	echo $output;
}

if (isset($_POST["submit"])) {
	if ((isset($_POST["username"]) && $_POST["username"] !== "") && (isset($_POST["password"]) && $_POST["password"] !== "")) {
		
		$username = $_POST['username'];
		$password = password_encrypt($_POST['password']);

		$stmt1 = $mysqli->prepare("SELECT * FROM adminLogin WHERE username LIKE ?");
		$stmt1->execute([$username]);

		if ($rowNum = $stmt1->rowCount() >= 1) {
			$_SESSION['message'] = "The username already exists";

		} elseif ($rowNum = $stmt1->rowCount() == 0) {
			$stmt2 = $mysqli->prepare("INSERT INTO adminLogin (username, hashed_password) VALUES (?,?)");
			$stmt2->execute([$username, $password]);
			if ($stmt2) {
				$_SESSION['message'] = "User successfully added";
			} else {
				$_SESSION['message'] = "User was unable to be added";
			}
		}
		redirect("add_admin.php");
		
	}
}

?>

<div class='row'>
	<label for='left-label' class='left inline'>

		<h3>Add an Administrator</h3>

		<form action="add_admin.php" method="post">
			<p>Username:<input type="text" name="username" value="" /> </p>
			<p>Password: <input type="password" name="password" value="" /> </p>
			<input type="submit" name="submit" value="Add Administrator" class="button round" />
		</form>
	</label>


	<p><br /><br />
		<hr />
	<h3>Current Adminstrators</h3>

	<?php
	$stmt = $mysqli->prepare("SELECT id,username FROM adminLogin");
	$stmt->execute();

	if ($stmt) {
		//echo "<div class='row'>";
		//echo "<center>";
		echo "<table>";
		echo "  <thead>";
		echo "     <tr><td></td><td>Username</td></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$username = $row['username'];
			echo "<tr>
					<td>&nbsp;<a href='del_admin.php?id=" . urlencode($row['id']) . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'><img src='trashcan.jpg' style='width:15px;height:15px'></a>&nbsp;</td>
					<td>$username</td>
					</tr>";
		}
		echo "</tbody></table><br /><a href='adminhome.php'><button>Go Back</button></a></div>";
	}
	?>

	<?php

	Database::dbDisconnect();
	?>
	