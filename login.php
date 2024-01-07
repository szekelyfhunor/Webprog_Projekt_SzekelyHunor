<?php
if (!class_exists('Connection')) {
    include "db_connect.php";
}


class Login {
    public $username;
    public $password;
    public $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function getUsername() {
        return $this->username;
    }

    public function processLogin(){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $this->populateFields();

            $this->conn->checkConnection();

            if($this->conn->userExists($this->username, $this->password)){
                $userId = $this->conn->returnUserId($this->username);

                if ($this->conn->isStudent($userId)){
                    header("Location: students.php");
                    exit();
                } elseif ($this->conn->isTeacher($userId)){
                    header("Location: diplomaRegistration.html");
                    exit();
                }

            } else {
                echo "Helytelen felhasznalonev vagy jelszo" . '<br>';
                echo '<a href="loginPage.html">Vissza</a>';
            }

            $this->conn->closeConnection();
        }
    }

    public function populateFields(){
        $this->username = $_POST["username"];
        $this->password = $_POST["password"];
    }
}

$login = new Login();
$login->processLogin();
?>
