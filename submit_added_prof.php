<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage","adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST["ProfessorID"]) && $_POST["ProfessorID"] !== "") {
    $ProfessorID = $_POST["ProfessorID"];
    $PTitle = $_POST["PTitle"];
    $PFName = $_POST["PFName"];
    $PLName = $_POST["PLName"];
    $PEmail = $_POST["PEmail"];

    echo "<h3>The Following Professor has been Added</h3>";
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>Professor WebID</th>
                    <th>Title</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>";
    echo "<tr>
            <td style='text-align:center'>" . $ProfessorID . "</td>
            <td style='text-align:center'>" . $PTitle . "</td>
            <td style='text-align:center'>" . $PFName . "</td>
            <td style='text-align:center'>" . $PLName . "</td>
            <td style='text-align:center'>" . $PEmail . "</td>
          </tr>";
    echo "</tbody></table>";


    $stmt = $mysqli->prepare("INSERT INTO `Professors` (`ProfessorID`, `PTitle`, `PFName`, `PLName`, `PEmail`) VALUES (?, ?, ?, ?, ?)");
    //$stmt->bind_param("sssss", $ProfessorID, $PTitle, $PFName, $PLName, $PEmail);
    $stmt->execute([$ProfessorID, $PTitle, $PFName, $PLName, $PEmail]);
    Database::dbDisconnect();

    echo "<a href='addremprof.php'>Add/Remove Another Professor</a>";
}
?>