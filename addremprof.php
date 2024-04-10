<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Remove Professors</title>
</head>
<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage","adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM `Professors`";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
?>

<body>
    <!-- <h1>Add/Remove Professors</h1> -->
    <form method="POST" action="submit_added_prof.php">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Add Professor</h3>
                <p>Professor WebID: <input type=text name=ProfessorID></p>
                <p>Title (Mr., Mrs., Dr., etc.): <input type=text name=PTitle></p>
                <p>First Name: <input type=text name=PFName></p>
                <p>Last Name: <input type=text name=PLName></p>
                <p>Email: <input type=text name=PEmail></p>
                <input type="submit" name="submit" class="button round" value="Add Professor" />
            </label>
        </div>
    </form>
    <form method="POST" action="removeprof.php">
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
                <input type="submit" name="submit" class="button round" value="Remove Professor" />
            </label>
        </div>
    </form>
    <br>
    <div class='row'>
    <a href='adminhome.php'><button>Go Back</button></a>
    </div>
</body>


</html>