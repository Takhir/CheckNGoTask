<?php

require_once 'User.php';

try {
    $user = new User();
    $users = $user->getUsers();
    echo json_encode($users);
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}

?>
