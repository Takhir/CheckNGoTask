<?php

require_once 'User.php';

try {
    if (!isset($_POST['name']) || !isset($_POST['email'])) {
        throw new Exception("Name and email fields are required");
    }

    $name = $_POST['name'];
    $email = $_POST['email'];

    $user = new User();
    $user->addUser($name, $email);

    echo json_encode(array("success" => true));
} catch (Exception $e) {
    echo json_encode(array("success" => false, "message" => $e->getMessage()));
}

?>
