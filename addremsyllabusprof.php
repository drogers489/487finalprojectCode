<?php
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
verify_prof_login();
new_header("Professor Homepage","addremsyllabusprof.php");

$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

$profQuery = "SELECT username FROM profLogin WHERE id=?";
$stmt0 = $mysqli->prepare($profQuery);
$stmt0->execute([$_SESSION['prof']]);
while ($user = $stmt0->fetch(PDO::FETCH_ASSOC)) {
    $prof = $user['username'];
}

$sql = "SELECT DISTINCT CurrentClasses.ClassID FROM CurrentClasses LEFT JOIN Syllabi ON CurrentClasses.ClassID = Syllabi.ClassID WHERE CurrentClasses.ProfessorID = ? AND Syllabi.ProfessorID IS NULL";
$stmt = $mysqli->prepare($sql);
$stmt->execute([$prof]);

if (isset($_POST["addSyl"])) {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $stmt1 = $mysqli->prepare("INSERT INTO Syllabi (ProfessorID, ClassID, file_name, file_data) VALUES (:ProfessorID, :ClassID, :file_name, :file_data)");

        $ClassID = $_POST['SyllabusID'];
        $ProfessorID = $prof;
        $stmt1->bindParam(':ProfessorID', $ProfessorID);
        $stmt1->bindParam(':ClassID', $ClassID);
        $stmt1->bindParam(':file_name', $_FILES["file"]["name"]);
        $stmt1->bindParam(':file_data', file_get_contents($_FILES["file"]["tmp_name"]));
        
        if ($stmt1->execute()) {
            $_SESSION["message"] = "File uploaded successfully.";
            redirect("addremsyllabusprof.php");
            
        } else {
            $_SESSION["message"] = "Error uploading file.";
            redirect("addremsyllabusprof.php");
        }

    } else {
        $_SESSION["message"] = "No file provided.";
        redirect("addremsyllabusprof.php");
    }

} elseif (isset($_POST["remSyl"])) {
    if (isset($_POST["SyllabusID"])) {
        $classID=$_POST["SyllabusID"];
        try {
            $stmt = $mysqli->prepare("DELETE FROM `Syllabi` WHERE `ClassID` = ? AND `ProfessorID` = ?");
            $stmt->execute([$classID,$prof]);

            if ($stmt->rowCount() > 0) {
                $_SESSION["message"] = "Removed Syllabus for class " .$classID . " with professor ". $prof;
                redirect("addremsyllabusprof.php");
            } else {
                $_SESSION["message"] = "Unable to remove syllabus";
                redirect("addremsyllabusprof.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION["message"] = "Unable find syllabus to remove";
        redirect("addremsyllabusprof.php");
    }

    Database::dbDisconnect();


} else {

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add/Remove Syllabus</title>
    </head>

    <body>
        <form method="post" action="addremsyllabusprof.php" enctype="multipart/form-data">
            <div class="row">
                <label for="left-label" class="left inline">
                    <?php 
                    echo "<h3>Welcome, $prof.<h3><h4>Please chose an action below:</h4>";
                    ?>
                    <hr />
                    <h3>Add Syllabus</h3>
                    Choose class to add Syllabus to:
                    <select name="SyllabusID">
                        <option></option>
                        <?php
                        while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$class['ClassID']}'>{$class['ClassID']}</option>";
                        }
                        ?>
                    </select>
                    <input type="file" id="file" name="file" accept=".txt,.pdf,.doc,.docx">
                    <button type="submit" name="addSyl" value="submit">Upload</button>
                </label>
            </div>
        </form>
        <form method="POST" action="addremsyllabusprof.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Remove Syllabus</h3>
                    Choose Syllabus to remove:<select name="SyllabusID">
                        <option></option>
                        <?php
                        $sql = "SELECT `ClassID` FROM `Syllabi` WHERE ProfessorID = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->execute([$prof]);
                        while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$class['ClassID']}'>{$class['ClassID']}</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" name="remSyl" class="button round" value="Remove Syllabus" />
                </label>
            </div>
        </form>

        <div class='row'>
            <a href='logoutProf.php'><button>Log out</button></a>
        </div>
    </body>

    </html>
<?php }