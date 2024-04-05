<?php

require_once 'Database.php';

class User extends Database {

    public function getUsers() {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        $users = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        return $users;
    }

    public function addUser($name, $email) {
        $conn = $this->getConnection();

        $sqlCount = "SELECT COUNT(*) as user_count FROM users";
        $result = $conn->query($sqlCount);
        $userCount = $result->fetch_assoc()["user_count"];
        $share = 100 / ($userCount + 1);

        $stmt = $conn->prepare("INSERT INTO users (name, email, share) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $email, $share);
        $stmt->execute();
        $stmt->close();

        if ($userCount > 0) {
            $newShare = 100 / ($userCount + 1);
            $updateSql = "UPDATE users SET share = $newShare";
            $conn->query($updateSql);
        }
    }

    public function resetUsers() {
        $conn = $this->getConnection();
        $sql = "TRUNCATE TABLE users";
        $conn->query($sql);
    }
}

?>
