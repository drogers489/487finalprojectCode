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
new_header("Administrator Homepage","adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT `ClassID`,`ProfessorID` FROM `CurrentClasses`";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
?>

<body>
    <form method="post" action="submit_added_syl.php" enctype="multipart/form-data">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Add Syllabus</h3>
                Choose class to add Syllabus to:<select name="ClassInfo">
                    <option></option>
                    <?php
                    while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$class['ClassID']},{$class['ProfessorID']}'>{$class['ClassID']}, {$class['ProfessorID']}</option>";
                    }
                    ?>
                    <input type="file" name="Syllabus" accept=".pdf,.doc,.docx">
                    <button type="submit" name="submit">Upload</button>
        </div>
        </label>
    </form>
    <div class='row'>
    <a href='adminhome.php'><button>Go Back</button></a>
    </div>
</body>

</html>