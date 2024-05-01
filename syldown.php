<?php
if (isset($_GET['id'])) {
    require_once ("487_functions.php");
    require_once ("databasefin.php");
    $mysqli = Database::dbConnect();
    $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    list($ProfessorID, $ClassID) = explode(",", $_GET['id']);
    $stmt = $mysqli->prepare("SELECT file_name, file_data FROM Syllabi WHERE ProfessorID = ? AND ClassID = ?");
    $stmt->execute([$ProfessorID, $ClassID]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $row['file_name'] . '"');
        echo $row['file_data'];
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "File Not Provided.";
}
?>