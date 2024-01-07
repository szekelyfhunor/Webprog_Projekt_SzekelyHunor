<?php

if(isset($_GET['student_id']) && isset($_GET['thesis_id'])){
    $studentId = $_GET['student_id'];
    $thesisId = $_GET['thesis_id'];

    include "db_connect.php";
    
    $conn = new Connection();
    $conn->checkConnection();

    $sql = "DELETE FROM applicants_for_thesis WHERE students_id = $studentId AND diploma_thesis_id = $thesisId";

    if($conn->conn->query($sql) === TRUE){
        echo "<a href='applicants.php'>⬅Back</a>";
    } else {
      echo "Error updating record: " . $conn->conn->error;
    }

    $conn->closeConnection();
} else {
    echo "Érvénytelen paraméterek!";
}