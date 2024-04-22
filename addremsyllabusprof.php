<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Remove Syllabus</title>
</head>
<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Professor Homepage","addremsyllabusprof.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT `ClassID` FROM `Syllabi` WHERE `ProfessorID` = ?";
$stmt = $mysqli->prepare($sql);
$prof = "hxiong"; // use user login to select professorID
$stmt->execute([$prof]);
?>

<body>
    <form method="post" action="submit_added_syl_prof.php" enctype="multipart/form-data">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Add Syllabus</h3>
                Choose class to add Syllabus to:<select name="ClassInfo">
                    <option></option>
                    <?php
                    while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$class['ClassID']}'>{$class['ClassID']}</option>";
                    }
                    ?>
                    <input type="file" name="Syllabus" accept=".pdf,.doc,.docx">
                    <button type="submit" name="submit">Upload</button>
        </div>
        </label>
    </form>
    <div class='row'>
    <a href='displaycourses.php'><button>Log Out</button></a>
    </div>
</body>

</html>