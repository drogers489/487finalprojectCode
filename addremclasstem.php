<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Remove Class</title>
</head>
<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage","adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT `ClassID` FROM `AllClasses`";
$stmt = $mysqli -> prepare($sql);
$stmt -> execute();
?>

<body>
    <form method="POST" action="submit_template_class.php">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Add Class Template</h3>
                <p>Class Code: <input type=text name=ClassID></p>
                <p>Course Title: <input type=text name=CourseTitle></p>
                <p><label for="CourseDesc">Course Description:</label>
                    <textarea id="CourseDesc" name="CourseDesc" rows="4" cols="50"></textarea>
                    </p>
                    <br>
                    <input type="submit" name="submit" class="button round" value="Add Class" />
            </label>
        </div>
    </form>
    <form method="POST" action="removetemplate.php">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Remove Class Template</h3>
                Choose class template to remove:<select name="ClassID">
                    <option></option>
                    <?php
                    while ($class = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        $classID = $class["ClassID"];
                        echo "<option value='$classID'>$classID</option>";
                    }
                    ?>
                </select>
                <br>
                <input type="submit" name="submit" class="button round" value="Remove Class" />
            </label>
        </div>
    </form>
    <br>
    <div class='row'>
    <a href='adminhome.php'><button>Go Back</button></a>
    </div>
</body>


</html>