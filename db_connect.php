<?php
class Connection {
    public $servername = 'localhost';
    public $username = 'root';
    public $password = '';
    public $dbname = 'thesisregisterapp';
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function checkConnection() {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
          }
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function insertUser($name, $password, $email, $phone) {
        $sql = "INSERT INTO users (name, password, email, phone) VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bind_param("ssss", $name, $password, $email, $phone);
    
        if ($stmt->execute()) {
            echo "New user created successfully" . '<br>';
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    
        $stmt->close();
    }

    public function returnUserId($name) {
        $sql = "SELECT id FROM users WHERE name = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();
        return ($userId !== null) ? $userId : null;
    }

    public function insertTeacher($users_id, $degree, $post) {
        $sql = "INSERT INTO teachers (users_id, degree, post) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $users_id, $degree, $post);

        if ($stmt->execute()) {
            echo "New teacher inserted successfully" . '<br>';
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $stmt->close();

    }

    public function insertStudent($users_id){
        $sql = "INSERT INTO students (users_id) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $users_id);
        if ($stmt->execute()) {
            echo "New student inserted successfully" . '<br>';
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $stmt->close();
    }

    public function userExists($username, $password) {
        $query = "SELECT * FROM users WHERE name = ? AND password = ?";
        $statement = $this->conn->prepare($query);
        $statement->bind_param('ss', $username, $password);
        $statement->execute();
    
        $result = $statement->get_result();
    
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isStudent($userId){
        $query = "SELECT * FROM students WHERE users_id = ?;";
        $statement = $this->conn->prepare($query);
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isTeacher($userId){
        $query = "SELECT * FROM teachers WHERE users_id = ?;";
        $statement = $this->conn->prepare($query);
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    

    public function insertDiplomaThesis($teacherID, $title, $abstract, $topic) {
        $sql = "INSERT INTO diploma_thesis (teachers_id, title, abstract, topic) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $teacherID, $title, $abstract, $topic);
        if ($stmt->execute()) {
            echo "New thesis inserted successfully" . '<br>';
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $stmt->close();
    }


    public function getTeacherID ($name) {
        $sql = "SELECT t.id
            FROM teachers t
            INNER JOIN users u ON t.users_id = u.id
            WHERE u.name = ?";

        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param("s", $name);
    
        if ($stmt->execute()) {
            $stmt->bind_result($teacherId);
            $stmt->fetch();
            $stmt->close();
    
    
            return $teacherId;
        } else {
            die("Query failed: " . $stmt->error);
        }

    }


    public function returnStudentID($name) {
        $sql = "SELECT students.id FROM students 
        INNER JOIN users ON students.users_id = users.id 
        WHERE users.name = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($studentID);
        $stmt->fetch();
        $stmt->close();
        return ($studentID !== null) ? $studentID : null;        
    }


    public function insertApplicants($studentID, $thesisID){
        $sql = "INSERT INTO applicants_for_thesis (students_id, diploma_thesis_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $studentID, $thesisID);
        if ($stmt->execute()) {
            echo "Applied for thesis successfully" . '<br>';
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $stmt->close();

    }
}
