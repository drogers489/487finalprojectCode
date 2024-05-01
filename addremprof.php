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

$sql = "SELECT * FROM `Professors`";
$stmt = $mysqli->prepare($sql);
$stmt->execute();

if (isset($_POST["addProf"])) {
    if (isset($_POST["ProfessorID"]) && $_POST["ProfessorID"] !== "") {
        $ProfessorID = $_POST["ProfessorID"];
        $PTitle = $_POST["PTitle"];
        $PFName = $_POST["PFName"];
        $PLName = $_POST["PLName"];
        $PEmail = $_POST["PEmail"];

        try {
            $stmt = $mysqli->prepare("INSERT INTO `Professors` (`ProfessorID`, `PTitle`, `PFName`, `PLName`, `PEmail`) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$ProfessorID, $PTitle, $PFName, $PLName, $PEmail]);
            $_SESSION["message"] = "Professor " . $ProfessorID . " has been added.";
            redirect("addremprof.php");
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error: " . $e->getMessage();
        }
        Database::dbDisconnect();

    } else {
        $_SESSION["message"] = "Unable to add professor";
        redirect("addremprof.php");
    }
} elseif (isset($_POST["remProf"])) {
    if (isset($_POST["ProfessorID"])) {
        $professorID = $_POST["ProfessorID"];

        try {
            $stmt = $mysqli->prepare("DELETE FROM `Professors` WHERE `ProfessorID` = ?");
            $stmt->execute([$professorID]);

            if ($stmt->rowCount() > 0) {
                $_SESSION["message"] = "Removed Professor " . $professorID;
                redirect("addremprof.php");
            } else {
                $_SESSION["message"] = "Unable to remove professor";
                redirect("addremprof.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION["message"] = "Unable find professor to remove";
        redirect("addremprof.php");
    }

    Database::dbDisconnect();

} else {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add/Remove Professors</title>
    </head>

    <body>
        <!-- <h1>Add/Remove Professors</h1> -->
        <form method="POST" action="addremprof.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Add Professor</h3>
                    <p>Professor WebID: <input type=text name=ProfessorID></p>
                    <p>Title (Mr., Mrs., Dr., etc.): <input type=text name=PTitle></p>
                    <p>First Name: <input type=text name=PFName></p>
                    <p>Last Name: <input type=text name=PLName></p>
                    <p>Email: <input type=text name=PEmail></p>
                    <input type="submit" name="addProf" class="button round" value="Add Professor" />
                </label>
            </div>
        </form>
        <form method="POST" action="addremprof.php">
            <div class="row">
                <label for="left-label" class="left inline">
                    <h3>Remove Professor</h3>
                    Choose professor to remove:<select name="ProfessorID">
                        <option></option>
                        <?php
                        while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$class['ProfessorID']}'>{$class['ProfessorID']} : {$class['PTitle']} {$class['PFName']} {$class['PLName']}</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" name="remProf" class="button round" value="Remove Professor" />
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