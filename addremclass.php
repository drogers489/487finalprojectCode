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
    <form method="POST" action="submit_added_class.php">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Add Class to Display</h3>
                <p>Class Code: <select name="ClassID">
                    <option></option>
                    <?php
                    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['ClassID']}'>{$row['ClassID']}</option>";
                    }
                    ?>
                </select></p>
                <p>Class Section: <input type=text name=ClassSection></p>
                <p>Professor (WebID):<select name="ProfessorID">
                    <option></option>
                    <?php
                    $sql = "SELECT `ProfessorID` FROM `Professors`";
                    $stmt = $mysqli -> prepare($sql);
                    $stmt -> execute();
                    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['ProfessorID']}'>{$row['ProfessorID']}</option>";
                    }
                    ?></select></p>
                <p>Days Meeting:
                    <input type="checkbox" id="M" name="DaysMeeting[]" value="M">
                    <label for="M">Monday</label>
                    <input type="checkbox" id="T" name="DaysMeeting[]" value="T">
                    <label for="T">Tuesday</label>
                    <input type="checkbox" id="W" name="DaysMeeting[]" value="W">
                    <label for="W">Wednesday</label>
                    <input type="checkbox" id="TH" name="DaysMeeting[]" value="TH">
                    <label for="TH">Thursday</label>
                    <input type="checkbox" id="F" name="DaysMeeting[]" value="F">
                    <label for="F">Friday</label>
                    <br>
                </p>
                <p>Timeslot: <input type=text name=TimeSlot></p>
                <p>Classroom: <input type=text name=ClassRoom></p>
                
                <p>Lab: <label>
                        <input type="radio" name="Lab" value="1">
                        True
                    </label>
                    <label>
                        <input type="radio" name="Lab" value="0">
                        False
                    </label>
                    <br>
                    <input type="submit" name="submit" class="button round" value="Add Class" />
            </label>
        </div>
    </form>
    <form method="POST" action="removeclass.php">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Remove Class</h3>
                Choose class to remove:<select name="Del">
                    <option></option>
                    <?php
                    $sql = "SELECT `ClassID`,`ClassSection` FROM `CurrentClasses`";
                    $stmt = $mysqli -> prepare($sql);
                    $stmt -> execute();
                    while ($class = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$class['ClassID']},{$class['ClassSection']}'>{$class['ClassID']} Section {$class['ClassSection']}</option>";
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