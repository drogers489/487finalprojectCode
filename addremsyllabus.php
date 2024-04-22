<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Remove Syllabus</title>
</head>

<body>
    <?php
    require_once("487_functions.php");
    require_once("databasefin.php");
    new_header("Administrator Homepage", "adminhome.php");

    try {
        $pdo = Database::dbConnect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT `ClassID`,`ProfessorID` FROM `CurrentClasses`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    ?>

    <form method="post" action="submit_added_syl2.php" enctype="multipart/form-data">
        <div class="row">
            <label for="left-label" class="left inline">
                <h3>Add Syllabus</h3>
                Choose class to add Syllabus to:
                <select name="ClassInfo">
                    <option></option>
                    <?php
                    while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$class['ClassID']},{$class['ProfessorID']}'>{$class['ClassID']}, {$class['ProfessorID']}</option>";
                    }
                    ?>
                </select>
                <input type="file" name="uploaded_file" accept=".pdf,.doc,.docx">
                <button type="submit" name="submit">Upload</button>
            </label>
        </div>
    </form>

    <div class='row'>
        <a href='adminhome.php'><button>Go Back</button></a>
    </div>
</body>

</html>
