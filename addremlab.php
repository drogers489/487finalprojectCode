<?php
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
verify_admin_login();
new_header("Administrator Homepage", "adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT `ClassID`,`ClassSection` FROM `CurrentClasses`";
$stmt = $mysqli->prepare($sql);
$stmt->execute();

if (($output = message()) !== null) {
    echo $output;
}

if (isset($_POST["addLab"])) {
    if (isset($_POST["CourseID"]) && $_POST["CourseID"] !== "") {
        list($ClassID, $ClassSection) = explode(",", $_POST["CourseID"]);
        $DaysMeeting = implode(",", $_POST["DaysMeeting"]);
        $TimeSlot = $_POST["TimeSlot"];
        echo "ClassID: " . $ClassID . " ClassSection: " . $ClassSection;

        try {
            $stmt = $mysqli->prepare("INSERT INTO `Labs` (`ClassID`, `ClassSection`, `DaysMeeting`, `TimeSlot`) VALUES (?, ?, ?, ?)");
            $stmt->execute([$ClassID, $ClassSection, $DaysMeeting, $TimeSlot]);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error: " . $e->getMessage();
        }
        $_SESSION["message"] = "Lab has been added to " . $ClassID . " Section " . $ClassSection;
    } else {
        $_SESSION["message"] = "Unable to add lab";
    }
    redirect("addremlab.php");
} elseif (isset($_POST["remLab"])) {
    if (isset($_POST["CourseID"]) && $_POST["CourseID"] !== "") {
        list($ID, $ClassSection) = explode(",", $_POST["CourseID"]);
        $ClassID = "%" . $ID . "%";

        try {
            $stmt2 = $mysqli->prepare("DELETE FROM `Labs` WHERE `ClassID` LIKE ? AND `ClassSection` = ?");
            $stmt2->execute([$ClassID, $ClassSection]);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error: " . $e->getMessage();
        }
        $_SESSION["message"] = "Lab for " . $ID . " Section " . $ClassSection . " has been deleted";
    } else {
        $_SESSION["message"] = "Unable to delete lab";
    }
    redirect("addremlab.php");
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add/Remove Lab</title>
    </head>

    <body>
        <form method="POST" action="addremlab.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Add Lab</h3>
                    <p>Course Section: <select name="CourseID">
                            <option></option>
                            <?php
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['ClassID']},{$row['ClassSection']}'>{$row['ClassID']} Section {$row['ClassSection']}</option>";
                            }
                            ?>
                        </select></p>
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
                    <br>
                    <input type="submit" name="addLab" class="button round" value="Add Lab" />
                </label>
            </div>
        </form>
        <form method="POST" action="addremlab.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Remove Lab</h3>
                    Choose Lab to remove:<select name="CourseID">
                        <option></option>
                        <?php
                        $sql1 = "SELECT `ClassID`,`ClassSection` FROM `Labs`";
                        $stmt1 = $mysqli->prepare($sql1);
                        $stmt1->execute();
                        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row1['ClassID']},{$row1['ClassSection']}'>{$row1['ClassID']} Section {$row1['ClassSection']}</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <p> <input type='submit' name='remLab' value='Remove Lab' class='round button'></p>
                </label>
            </div>
        </form>
        <br>
        <div class='row'>
            <a href='adminhome.php'><button>Go Back</button></a>
        </div>
    </body>


    </html>
    <?php
    DATABASE::dbDisconnect();
}