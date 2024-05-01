<?php
require_once ("487_functions.php");
require_once ("databasefin.php");

$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if (isset($_POST["selectedCourses"])) {
        $selectedCourses = $_POST["selectedCourses"];
        $courseDetails = "Favorited Classes:\n";

        foreach ($selectedCourses as $courseID) {
            $sql1 = "SELECT * FROM `CurrentClasses` NATURAL JOIN `AllClasses` NATURAL JOIN `Professors` WHERE `ClassID` LIKE ? AND `ClassSection` = ?";
            $stmt1 = $mysqli->prepare($sql1);
            list($ClassID, $ClassSection) = explode(",", $courseID);
            $stmt1->execute([$ClassID, $ClassSection]);
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $courseDetails .= "===========================================" . "\n";
                $courseDetails .= "Course: " . $row1['ClassID'] . " Section " . $row1['ClassSection'] . "\n";
                $courseDetails .= "Professor: " . $row1['PTitle'] . " " . $row1['PFName'] . " " . $row1['PLName'] . "\n";
                $courseDetails .= "Meeting Days: " . $row1['DaysMeeting'] . " from " . $row1['TimeSlot'] . "\n";

            }
        }

        header("Content-Type: text/plain");
        header("Content-Disposition: attachment; filename=selected_courses.txt");
        echo $courseDetails;
        exit;
    }
}

new_loginheader("Current CSCI/CIS Courses", "displaycourses.php");

$sql = "SELECT * FROM `CurrentClasses` NATURAL JOIN `AllClasses` NATURAL JOIN `Professors` ORDER BY SUBSTRING(ClassID, -3)";
$stmt = $mysqli->prepare($sql);
$stmt->execute();

?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />
    <title>Current Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        .expandChildTable:before {
            content: "+";
            display: block;
            cursor: pointer;
        }

        .expandChildTable.selected:before {
            content: "-";
        }

        .childTableRow {
            display: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="container">
                <br>
                <h3 class="col-lg-9">Next Semester's CSCI/CIS Courses</h3>
                <br>
            </div>
        </header>
        <div class="container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Course Code</th>
                            <th>Section</th>
                            <th>Course Title</th>
                            <th>Professor</th>
                            <th>Days Meeting</th>
                            <th>Timeslot</th>
                            <th>Classroom</th>
                            <th>Favorite</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                    <td><span class='expandChildTable'></span></td>
                    <td>{$row['ClassID']}</td>
                    <td>{$row['ClassSection']}</td>
                    <td>{$row['CourseTitle']}</td>
                    <td>{$row['PTitle']} {$row['PFName']} {$row['PLName']}</td>
                    <td>{$row['DaysMeeting']}</td>
                    <td>{$row['TimeSlot']}</td>
                    <td>{$row['ClassRoom']}</td>
                    <td><input type='checkbox' id='{$row['ClassID']}' name='selectedCourses[]' value='{$row['ClassID']},{$row['ClassSection']}'></td>
                </tr>
                <tr class='childTableRow'>
                    <td colspan='9'>
                        <h5>{$row['ClassID']} Section {$row['ClassSection']} Details</h5>";
                            $stmt3 = $mysqli->prepare("SELECT ProfessorID, ClassID, file_name FROM Syllabi NATURAL JOIN CurrentClasses WHERE ClassID LIKE ? AND ProfessorID LIKE ?");
                            $stmt3->execute([$row["ClassID"], $row["ProfessorID"]]);
                            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                            if ($row["Lab"] == "1") {
                                $ClassID = "%" . $row["ClassID"] . "%";
                                $ClassSection = $row["ClassSection"];
                                $sql2 = "SELECT * FROM `Labs` WHERE ClassID LIKE ? AND ClassSection = ?";
                                $stmt2 = $mysqli->prepare($sql2);
                                $stmt2->execute([$ClassID, $ClassSection]);
                                echo "<table class='table'>
                                        <thead>
                                            <tr>
                                                <th>Professor Email</th>
                                                <th>Syllabus</th>
                                                <th>Teacher Evaluations</th>
                                                <th>Lab</th>
                                                <th>Lab Meeting Days</th>
                                                <th>Time Meeting</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                        <td>{$row['PEmail']}</td>
                                        <td>";
                                if ($row3) {
                                    $id = $row3['ProfessorID'] . "," . $row3["ClassID"];
                                    $filename = $row3["ClassID"] .  " Syllabus "  . $row3['ProfessorID'];
                                    echo "<a href='syldown.php?id=$id'>$filename</a>";
                                } else {
                                    echo "File not found.";
                                }
                                echo "</td>
                                        <td><a href='https://my.olemiss.edu/irj/portal?NavigationTarget=navurl://408225e484f76553b120223a08ac2a44'>myOleMiss Login (Will need teacher/course name)</a></td>
                                        <td>Required</td>";
                                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<td>{$row2['DaysMeeting']}</td><td>{$row2['TimeSlot']}</td>";
                                }
                                echo "</tr></tbody></table>";
                            } else {
                                echo "<table class='table'>
                                            <thead>
                                                <tr>
                                                    <th>Professor Email</th>
                                                    <th>Syllabus</th>
                                                    <th>Check Teacher Evaluations</th>
                                                    <th>Lab</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{$row['PEmail']}</td>
                                                    <td>";
                                if ($row3) {
                                    $id = $row3['ProfessorID'] . "," . $row3["ClassID"];
                                    $filename = $row3["ClassID"] .  " Syllabus "  . $row3['ProfessorID'];
                                    echo "<a href='syldown.php?id=$id'>$filename</a>";
                                } else {
                                    echo "File not found.";
                                }
                                echo "</td>
                                                    <td><a href='https://my.olemiss.edu/irj/portal?NavigationTarget=navurl://408225e484f76553b120223a08ac2a44'>Teacher Evaluations (Will need teacher/course name)</a></td>
                                                    <td>None</td>
                                                </tr>
                                            </tbody>
                                        </table>";
                            }
                            echo "<table class='table'>
                                    <thead>
                                        <tr>
                                            <th>Course Description</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <tr>
                                        <td>{$row['CourseDesc']}</td>
                                    </tr>
                                </tbody>
                                </table>
                            </td>
                        </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" name="submit">Download Selected Courses</button>
            </form>
        </div>
    </div>
    <footer>
    </footer>
    <!-- https://www.marcorpsa.com/ee/t3900.html -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script><!-- <script src="js/disqus-config.js"></script> -->
    <script>
        $(function () {
            $('.expandChildTable').on('click', function () {
                $(this).toggleClass('selected').closest('tr').next().toggle();
            })
        });
    </script>
</body>

</html>