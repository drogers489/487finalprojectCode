<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
</head>
<?php
require_once ("487_functions.php");
require_once ("databasefin.php");
new_header("Administrator Homepage","adminhome.php");
?>

<body>
    <div class="row">
        <h2>Administrator Access</h2>
        <a href="addremclass.php"><button>Add/Remove Class Section (Display)</button></a>
        <a href="addremclasstem.php"><button>Add/Remove Class (Template)</button></a>
        <br>
        <a href="addremprof.php"><button>Add/Remove Professor</button></a>
        <a href="addremsyllabus.php"><button>Add/Remove Syllabi</button></a>
        <a href="addremlab.php"><button>Add/Remove Labs</button></a>
        <br>
        <a href="displaycourses.php"><button>Log Out</button></a>
    </div>
</body>

</html>