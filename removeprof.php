<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage");

$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ProfessorID"])) {
    $professorID = $_POST["ProfessorID"];

    try {
        $stmt = $mysqli->prepare("DELETE FROM `Professors` WHERE `ProfessorID` = ?");
        $stmt->execute([$professorID]);

        if ($stmt->rowCount() > 0) {
            echo "<div class='row'>";
            echo "Professor was removed successfully.";
            echo "<div>";
        } else {
            echo "<div class='row'>";
            echo "Professor not found or could not be removed.";
            echo "<div>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

Database::dbDisconnect();
echo "<div class='row'>";
echo "<a href='addremprof.php'><button>Add/Remove Another Professor</button></a>";
echo "</div>";
?>