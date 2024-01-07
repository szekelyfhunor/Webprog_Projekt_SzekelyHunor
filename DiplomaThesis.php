<?php

include "db_connect.php";

class DiplomaThesis {
    private $teacherName;
    private $title;
    private $abstract;
    private $topic;


    public function addDiplomaThesis(){
        if ($_SERVER["REQUEST_METHOD"] == 'POST'){
            $this->populateFields();

            $conn = new Connection();
            $conn->checkConnection();

            $conn->insertDiplomaThesis($conn->getTeacherID($this->teacherName), $this->title, $this->abstract, $this->topic);

            $conn->closeConnection();

            echo "<a href='diplomaRegistration.html'>⬅Back</a>";
        }
    }

    public function populateFields() {
        $this->teacherName = $_POST["teacherName"];
        $this->title = $_POST["title"];
        $this->abstract = $_POST["abstract"];
        $this->topic = $_POST["topic"];

    }



}

$thesis = new DiplomaThesis();
$thesis->addDiplomaThesis();