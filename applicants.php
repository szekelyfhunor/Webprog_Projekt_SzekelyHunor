<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Jelentkezések</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <a href="diplomaRegistration.html" class="btn btn-success">Dolgozat létrehozása</a>
    <a href="applicants.php" class="btn btn-success">Jelentkezett hallgatók</a>

    <h2 class="mt-4">Jelentkezések</h2>

    <?php
    include "db_connect.php";

    $conn = new Connection();
    $conn->checkConnection();

    $sql = "SELECT users.name AS student_name, diploma_thesis.title AS thesis_title, applicants_for_thesis.students_id, diploma_thesis.id AS thesis_id
    FROM applicants_for_thesis
    INNER JOIN students ON applicants_for_thesis.students_id = students.id
    INNER JOIN users ON students.users_id = users.id
    INNER JOIN diploma_thesis ON applicants_for_thesis.diploma_thesis_id = diploma_thesis.id
    INNER JOIN teachers ON diploma_thesis.teachers_id = teachers.id
    WHERE teachers.id = 1 AND applicants_for_thesis.status = 'pending';";

    $result = $conn->conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Diák Neve</th>
                    <th>Dolgozat Címe</th>
                    <th colspan='2'></th>
                </tr>
            </thead>
            <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['student_name']}</td>
                <td>{$row['thesis_title']}</td>
                <td><a href='elfogad.php?student_id={$row['students_id']}&thesis_id={$row['thesis_id']}' class='btn btn-primary'>Elfogad</a></td>
                <td><a href='elutasit.php?student_id={$row['students_id']}&thesis_id={$row['thesis_id']}' class='btn btn-danger'>Elutasít</a></td>
            </tr>";
        }

        echo "</tbody></table>";

    } else {
        echo "<p class='lead'>Nincs elérhető jelentkezés.</p>";
    }

    $conn->closeConnection();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
