<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_loginheader("Current CSCI/CIS Courses", "CourseDisplayPage.php");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "SELECT * FROM `CurrentClasses` NATURAL JOIN `AllClasses` ORDER BY SUBSTRING(ClassID, -3)";
//$sql2 = "SELECT * FROM `AllClasses` "
$stmt = $mysqli -> prepare ($sql1);
$stmt -> execute();


if (!$stmt) {
    echo 'There are no results for your search';
} else {
    echo "<div class='row'>";
    echo '<table class="table table-striped table-bordered table-hover">';
    echo "<tr>
          <th>Class Name</th>
          <th>Section</th>
          <th>Course Title</th>
          <th>Professor</th>
          <th>Days Meeting</th>
          <th>Timeslot</th>
          <th>Classroom</th>
          <th>Lab</th>
          </tr>";
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>";
        echo $row['ClassID'];
        echo "</td><td>";
        echo $row['ClassSection'];
        echo "</td><td>";
        echo $row['CourseTitle'];
        echo "</td><td>";
        echo $row['ProfessorID'];
        echo "</td><td>";
        echo $row['DaysMeeting'];
        echo "</td><td>";
        echo $row['TimeSlot'];
        echo "</td><td>";
        echo $row['ClassRoom'];
        echo "</td><td>";
        if ($row["Lab"] == "1") {
            echo "Yes";
        }
        if ($row["Lab"] == "0") {
            echo "No";
        }
        echo "</td></tr>";
    }

    echo "</table>";
    echo "</div>";
    Database::dbDisconnect();
}

?>