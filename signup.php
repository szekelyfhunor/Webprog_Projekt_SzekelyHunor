<?php

include "db_connect.php";

class Signup {
    private $name;
    private $password;
    private $email;
    private $phoneNumber;
    private $role;
    private $degree;
    private $position;


   

    public function ProcessRegistration(){
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $this->populateFields();

            $conn = new Connection();
            $conn->checkConnection();

            if($conn->userExists($this->name, $this->password)) {
                echo "A felhasznalo mar letezik";
            } else {

                if($this->role == "teacher"){
                    $conn->insertUser($this->name, $this->password, $this->email, $this->phoneNumber);
                    $conn->insertTeacher($conn->returnUserId($this->name), $this->degree, $this->position);
                } else {
                    $conn->insertUser($this->name, $this->password, $this->email, $this->phoneNumber);
                    $conn->insertStudent($conn->returnUserId($this->name));
                }

            }

            $conn->closeConnection();

            
            header("Location: index.html");
            
        }

    }

    private function populateFields() {
        $this->name = $_POST["name"];
        $this->password = $_POST["password"];
        $this->email = $_POST["email"];
        $this->phoneNumber = $_POST["phoneNumber"];
        $this->role = $_POST["role"];
        $this->degree = isset($_POST["degree"]) ? $_POST["degree"] : 'none';
        $this->position = $_POST["position"];
    }

    

    
}

$registration = new Signup();
$registration->ProcessRegistration();