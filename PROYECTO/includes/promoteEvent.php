<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
    $userDAO = new UserDAO();
    $activityDAO = new ActivityDAO();
    $userId = $_POST["userId"];
    $eventId = $_POST["eventId"];

    if(!$userDAO->isPromoting($userId, $eventId)){
         $result = $userDAO->promote($userId, $eventId);
         $activityDAO->addActivity($userId, ActivityDAO::EVENT, 'null', $eventId, ActivityDAO::PROMOTED_EVENT);
	}
    else {
        $result = $userDAO->unpromote($userId, $eventId);
        $activityDAO->removeActivityByObject($userId, ActivityDAO::EVENT, $eventId, ActivityDAO::PROMOTED_EVENT);
	}

    echo $result;

   
