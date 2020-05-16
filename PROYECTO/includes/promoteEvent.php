<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
    $userDAO = new UserDAO();
    $userId = $_SESSION["userId"];
    $event_id = $_POST["event_id"];

    if(!$userDAO->isPromoting($userId, $event_id))
         $userDAO->promote($userId, $event_id);
    else 
        $userDAO->unpromote($userId, $event_id);
    header("Location: ../eventItem.php?event_id=".$event_id."");

   
