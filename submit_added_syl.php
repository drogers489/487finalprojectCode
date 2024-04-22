<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST["ClassInfo"]) && $_POST["ClassInfo"] !== "") {
    $ClassInfo = explode(",", $_POST["ClassInfo"]);
    $ClassID = $ClassInfo[0];
    $ProfessorID = $ClassInfo[1];

    $file = $_FILES["pdfFile"];
    $fileName = $file["name"];
    $fileTmpName = $file["tmp_name"];
    $fileError = $file["error"];

    if ($fileError == 0) {
        $uploads = "syllabi/";
        if (!file_exists($uploads)) {
            mkdir($uploads, 0777, true);
        }
        $syllabus = $uploads . $fileName;
        move_uploaded_file($fileTmpName, $syllabus);

        try {
            $stmt = $mysqli->prepare("INSERT INTO `Syllabi` (`ProfessorID`, `ClassID`, `Syllabus`) VALUES (?, ?, ?)");
            $stmt->execute([$ProfessorID, $ClassID, $syllabus]);

            if ($stmt->rowCount() > 0) {
                echo "<div class='row'>";
                echo "Syllabus uploaded successfully to $syllabus, redirecting you to previous page in 5 seconds.";
                echo "</div>";
                
            } else {
                echo "<div class='row'>";
                echo "Syllabus not saved into database";
                echo "</div>";

            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        Database::dbDisconnect();
        header("refresh:5;url=addremsyllabus.php");
    }
    
    echo "<div class='row'>";
    echo "<a href='addremsyl.php'><button>Add/Remove Another Syllabus</button></a>";
    echo "</div>";
}
?>