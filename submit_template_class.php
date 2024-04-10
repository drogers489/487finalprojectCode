<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage","adminhome.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST["ClassID"]) && $_POST["ClassID"] !== "") {
    $ClassCode = $_POST["ClassID"];
    $ClassSection = $_POST["ClassSection"];
    $CourseTitle = $_POST["CourseTitle"];
    $ProfessorID = $_POST["ProfessorID"];
    $DaysMeeting = implode(",", $_POST["DaysMeeting"]);
    $TimeSlot = $_POST["TimeSlot"];
    $ClassRoom = $_POST["ClassRoom"];
    $Lab = isset($_POST["Lab"]) ? 1 : 0;

    try {
        $stmt = $mysqli->prepare("INSERT INTO `CurrentClasses` (`ClassID`, `ClassSection`, `CourseTitle`, `ProfessorID`, `DaysMeeting`, `TimeSlot`, `ClassRoom`, `Lab`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$ClassCode, $ClassSection, $CourseTitle, $ProfessorID, $DaysMeeting, $TimeSlot, $ClassRoom, $Lab]);


        if ($stmt->rowCount() > 0) {
            echo "<div class='row'>";
            echo "<h3>The Following Class has been Added</h3>";
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Class Code</th>
                            <th>Class Section</th>
                            <th>Course Title</th>
                            <th>Professor</th>
                            <th>Days Meeting</th>
                            <th>Timeslot</th>
                            <th>Classroom</th>
                            <th>Lab</th>
                        </tr>
                    </thead>
                    <tbody>";
            echo "<tr>
                    <td style='text-align:center'>" . $ClassCode . "</td>
                    <td style='text-align:center'>" . $ClassSection . "</td>
                    <td style='text-align:center'>" . $CourseTitle . "</td>
                    <td style='text-align:center'>" . $ProfessorID . "</td>
                    <td style='text-align:center'>" . $DaysMeeting . "</td>
                    <td style='text-align:center'>" . $TimeSlot . "</td>
                    <td style='text-align:center'>" . $ClassRoom . "</td>
                    <td style='text-align:center'>" . ($Lab ? "True" : "False") . "</td>
                  </tr>";
            echo "</tbody></table>";
        } else {
            echo "<div class='row'>";
            echo "Class could not be added.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    Database::dbDisconnect();
    echo "<a href='addremclass.php'>Add/Remove Another Class</a>";
    echo "<div>";
}
?>