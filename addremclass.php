<?php
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
verify_admin_login();
new_header("Administrator Homepage", "adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

$sql = "SELECT `ClassID` FROM `AllClasses`";
$stmt = $mysqli->prepare($sql);
$stmt->execute();

if (isset($_POST["addSec"])) {
    if ((isset($_POST["ClassID"]) && $_POST["ClassID"] !== "") && (isset($_POST["ClassSection"]) && $_POST["ClassSection"] !== "") && (isset($_POST["ProfessorID"]) && $_POST["ProfessorID"] !== "") && (isset($_POST["DaysMeeting"]) && $_POST["DaysMeeting"] !== "") && (isset($_POST["TimeSlot"]) && $_POST["TimeSlot"] !== "") && (isset($_POST["ClassRoom"]) && $_POST["ClassRoom"] !== "") && (isset($_POST["Lab"]) && $_POST["Lab"] !== "")) {
        $ClassCode = $_POST["ClassID"];
        $ClassSection = $_POST["ClassSection"];
        $ProfessorID = $_POST["ProfessorID"];
        $DaysMeeting = implode(",", $_POST["DaysMeeting"]);
        $TimeSlot = $_POST["TimeSlot"];
        $ClassRoom = $_POST["ClassRoom"];
        $Lab = $_POST["Lab"];


        try {
            $stmt = $mysqli->prepare("INSERT INTO `CurrentClasses` (`ClassID`, `ClassSection`, `ProfessorID`, `DaysMeeting`, `TimeSlot`, `ClassRoom`, `Lab`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$ClassCode, $ClassSection, $ProfessorID, $DaysMeeting, $TimeSlot, $ClassRoom, $Lab]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $_SESSION["message"] = $ClassID . " Section " . $ClassSection . " has been added to display";
    } else {
        $_SESSION["message"] = "Unable to add Section";
    }
    Database::dbDisconnect();
    redirect("addremclass.php");

} elseif (isset($_POST["delSec"])) {
    if (isset($_POST["Del"])) {
        list($ClassID, $ClassSection) = explode(",", $_POST["Del"]);
        try {
            $stmt = $mysqli->prepare("DELETE FROM `CurrentClasses` WHERE `ClassID` = ? AND `ClassSection` = ?");
            $stmt->execute([$ClassID, $ClassSection]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $_SESSION["message"] = "".$ClassID . " Section " . $ClassSection . " has been deleted from display";
    } else {
        $_SESSION["message"] = "Unable to remove Section";
    }
    Database::dbDisconnect();
    redirect("addremclass.php");

} elseif (isset($_POST["delAll"])) {
        try {
            $stmt = $mysqli->prepare("DELETE FROM `CurrentClasses`");
            $stmt->execute();
            $_SESSION["message"] = "All sections have been removed";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $_SESSION["message"] = "ERROR: Unable to remove all sections";
        }
    Database::dbDisconnect();
    redirect("addremclass.php");

} else {

    ?>

    <body>
        <form method="POST" action="addremclass.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Add Course Section</h3>
                    <p>Course Code: <select name="ClassID">
                            <option></option>
                            <?php
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['ClassID']}'>{$row['ClassID']}</option>";
                            }
                            ?>
                        </select></p>
                    <p>Course Section: <input type=number min=1 max=10 name=ClassSection></p>
                    <p>Professor (WebID):<select name="ProfessorID">
                            <option></option>
                            <?php
                            $sql = "SELECT `ProfessorID` FROM `Professors`";
                            $stmt = $mysqli->prepare($sql);
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['ProfessorID']}'>{$row['ProfessorID']}</option>";
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
                        <input type="submit" name="addSec" class="button round" value="Add Section" />
                </label>
            </div>
        </form>
        <form method="POST" action="addremclass.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Remove Section</h3>
                    Choose Course Section to remove:<select name="Del">
                        <option></option>
                        <?php
                        $sql = "SELECT `ClassID`,`ClassSection` FROM `CurrentClasses`";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->execute();
                        while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$class['ClassID']},{$class['ClassSection']}'>{$class['ClassID']} Section {$class['ClassSection']}</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" name="delSec" class="button round" value="Remove Section" />
                </label>
            </div>
        </form>
        <form method="POST" action="addremclass.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Remove All Sections</h3>
                    <input type="submit" name="delAll" class="button round" value="Remove All Sections" onclick="return confirm('Are you sure you want to remove all sections? This cannot be undone.')">
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
}