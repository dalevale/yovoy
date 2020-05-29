<?php
require_once __DIR__.'/config.php';

    $userDAO = new UserDAO;
    $userId = $_POST["userId"];

    $userDAO->deleteUser($userId);

    echo 0;
