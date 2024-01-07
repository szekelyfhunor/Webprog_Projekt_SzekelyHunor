<?php

if (isset($_GET['student_id']) && isset($_GET['thesis_id'])) {
    $studentId = $_GET['student_id'];
    $thesisId = $_GET['thesis_id'];

    include "db_connect.php";
    
    $conn = new Connection();
    $conn->checkConnection();

    $update1 = "UPDATE applicants_for_thesis SET status = 'accepted' WHERE students_id = $studentId AND diploma_thesis_id = $thesisId";
    $update2 = "UPDATE diploma_thesis SET students_id = $studentId, status = 'occupied' WHERE id = $thesisId";

    
    if ($conn->conn->query($update1) === TRUE && $conn->conn->query($update2) === TRUE) {
        echo "Record updated successfully".'<br>';
        echo "<a href='applicants.php'>⬅Back</a>";
      } else {
        echo "Error updating record: " . $conn->conn->error;
      }

    
    $conn->closeConnection();
} else {
    echo "Érvénytelen paraméterek!";
}
?>
