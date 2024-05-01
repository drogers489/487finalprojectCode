<?php
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
verify_admin_login();
new_header("Administrator Homepage","adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

$sql = "SELECT `ClassID` FROM `AllClasses`";
$stmt = $mysqli -> prepare($sql);
$stmt -> execute();

if (isset($_POST["addTem"])) {
    if ((isset($_POST["ClassID"]) && $_POST["ClassID"] !== "")&&(isset($_POST["CourseTitle"]) && $_POST["CourseTitle"] !== "")&&(isset($_POST["CourseDesc"]) && $_POST["CourseDesc"] !== "")) {
        $ClassID = $_POST["ClassID"];
        $CourseTitle = $_POST["CourseTitle"];
        $CourseDesc = $_POST["CourseDesc"];

        try {
            $stmt = $mysqli->prepare("INSERT INTO `AllClasses` (`ClassID`, `CourseTitle`, `CourseDesc`) VALUES (?, ?, ?)");
            $stmt->execute([$ClassID,$CourseTitle,$CourseDesc]);
            $_SESSION["message"] = "Course Template " . $ClassID . " has been added.";
            redirect("addremtem.php");
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error: " . $e->getMessage();
        }
        Database::dbDisconnect();
        
    } else {
        $_SESSION["message"] = "Unable to add all fields. Please try again";
        redirect("addremtem.php");
    }
} elseif (isset($_POST["remTem"])) {
    if (isset($_POST["ClassID"])) {
        $ClassID = $_POST["ClassID"];
    
        try {
            $stmt = $mysqli->prepare("DELETE FROM `AllClasses` WHERE `ClassID` = ?");
            $stmt->execute([$ClassID]);
    
            if ($stmt->rowCount() > 0) {
                $_SESSION["message"] = "Removed Template ".$ClassID;
                redirect("addremtem.php");
            } else {
                $_SESSION["message"] = "Unable to remove template";
                redirect("addremtem.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION["message"] = "Unable find template to remove";
        redirect("addremtem.php");
    }
    
    Database::dbDisconnect();

} else {

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Remove Class</title>
</head>
<body>
    <form method="POST" action="addremtem.php">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Add Course Template</h3>
                <p>Course Code: <input type=text name=ClassID></p>
                <p>Course Title: <input type=text name=CourseTitle></p>
                <p><label for="CourseDesc">Course Description:</label>
                    <textarea id="CourseDesc" name="CourseDesc" rows="4" cols="50"></textarea>
                    </p>
                    <br>
                    <input type="submit" name="addTem" class="button round" value="Add Course" />
            </label>
        </div>
    </form>
    <form method="POST" action="addremtem.php">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Remove Course Template</h3>
                Choose course template to remove:<select name="ClassID">
                    <option></option>
                    <?php
                    while ($class = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        $classID = $class["ClassID"];
                        echo "<option value='$classID'>$classID</option>";
                    }
                    ?>
                </select>
                <br>
                <input type="submit" name="remTem" class="button round" value="Remove Course" />
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