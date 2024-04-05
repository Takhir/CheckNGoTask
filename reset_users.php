<?php

require_once 'User.php';

try {
    $user = new User();
    $user->resetUsers();
    echo "Users reset successfully";
} catch (Exception $e) {
    echo "Error resetting users: " . $e->getMessage();
}

?>
