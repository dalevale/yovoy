<?php
require_once __DIR__.'/config.php';

    $userDAO = new UserDAO;
    $userId = $_POST["userId"];

    $result = $userDAO->deleteUser($userId);

    echo $result;
