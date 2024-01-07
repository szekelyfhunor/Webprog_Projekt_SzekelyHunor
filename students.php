<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>

    <style>
        body {
            display: flex;
            align-items:start;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }


        .container2 {
            max-width: 400px;
        }
        
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <?php

    if (!class_exists('Connection')) {
        include "db_connect.php";
    }

    echo "<h2>Elérhető dolgozatok</h2>";

    $conn = new Connection();
    $conn->checkConnection();

    $sql = "SELECT t.id, t.title, t.abstract, t.topic, u.name AS teacher_name, t.timestamp
            FROM diploma_thesis t
            INNER JOIN teachers te ON t.teachers_id = te.id
            INNER JOIN users u ON te.users_id = u.id
            WHERE t.status = 'avalible'";

    $result = $conn->conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Sorsz.</th>
                        <th>Dolgozat cime</th>
                        <th>Leírás</th>
                        <th>Temakor</th>
                        <th>Tanár neve</th>
                        <th>Feltoltve</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['abstract']}</td>
                    <td>{$row['topic']}</td>
                    <td>{$row['teacher_name']}</td>
                    <td>{$row['timestamp']}</td>
                </tr>";
        }

        echo "</tbody></table>";

    } else {
        echo "<p class='lead'>Nincs elérhető dolgozat.</p>";
    }

    $conn->closeConnection();
    ?>

    <div class="container2">

        <h3 class="mt-4">Jelentkezés</h3>
        <form action="" method="post">
            <div class="mb-3">
                <label for="thesisID" class="form-label">Dolgozat sorsz.:</label>
                <input type="number" class="form-control" name="thesisID" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nev:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>

    <?php

        $conn = new Connection();
        $conn->checkConnection();

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $thesisID = $_POST["thesisID"];
            $studentName = $_POST["name"];

            $studentID = $conn->returnStudentID($studentName);

            $conn->insertApplicants($studentID, $thesisID);
        }

        $conn->closeConnection();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
