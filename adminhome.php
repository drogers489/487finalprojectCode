<?php
require_once ("session.php");
require_once ("487_functions.php");
require_once ("databasefin.php");
verify_admin_login();
new_header("Administrator Homepage","adminhome.php");

if (($output = message()) !== null) {
    echo $output;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
</head>

<body>
    <div class="row">
        <h2>Administrator Access</h2>
        <a href="addremclass.php"><button>Add/Remove Course Section (Display)</button></a>
        <a href="addremtem.php"><button>Add/Remove Course (Template)</button></a>
        <br>
        <a href="addremprof.php"><button>Add/Remove Professor</button></a>
        <a href="addremsyllabus.php"><button>Add/Remove Syllabi</button></a>
        <a href="addremlab.php"><button>Add/Remove Labs</button></a>
        <br>
        <a href="add_prof.php"><button>Add/Remove Professor Login</button></a>
        <a href="add_admin.php"><button>Add/Remove Administrator Login</button></a>
        <br>
        <a href="logoutAdmin.php"><button>Log Out</button></a>
    </div>
</body>

</html>