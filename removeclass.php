<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage","adminhome.php");

$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Del"])) {
    list($ClassID, $ClassSection) = explode(",", $_POST["Del"]);
    try {
        $stmt = $mysqli->prepare("DELETE FROM `CurrentClasses` WHERE `ClassID` = ? AND `ClassSection` = ?");
        $stmt->execute([$ClassID, $ClassSection]);

        if ($stmt->rowCount() > 0) {
            echo "<div class='row'>";
            echo "<br>Class was removed successfully.";
        } else {
            echo "<div class='row'>";
            echo "<br>Class not found or could not be removed.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
Database::dbDisconnect();
echo "<br><br><a href='addremclass.php'><button>Add/Remove Another Class</button></a>";
echo "</div>";
?>