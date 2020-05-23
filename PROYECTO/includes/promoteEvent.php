<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
    $userDAO = new UserDAO();
    $userId = $_POST["userId"];
    $eventId = $_POST["eventId"];

    if(!$userDAO->isPromoting($userId, $eventId))
         $userDAO->promote($userId, $eventId);
    else 
        $userDAO->unpromote($userId, $eventId);

    echo 0;

   
