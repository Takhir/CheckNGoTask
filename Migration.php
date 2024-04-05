<?php

require_once 'Database.php';

class Migration extends Database {
    public function createUsersTable() {
        $conn = $this->getConnection();

        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            share DECIMAL(10,2) DEFAULT 0
        )";

        if ($conn->query($sql) === TRUE) {
            echo "Table users created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        $conn->close();
    }
}

$migration = new Migration();

$migration->createUsersTable();

?>
