<?php
require_once __DIR__.'/config.php';

    $notificationsDAO = new NotificationsDAO();
    $eventDAO = new EventDAO();
    $userDAO = new UserDAO();
    $activityDAO = new ActivityDAO();
    $currDate = date("Y-m-d H:i:s");
    $eventId = $_POST["eventId"];
    $userId = $_POST["userId"];
    $status = $_POST["status"];

    $event = $eventDAO->getEvent($eventId);
    $ownerId = $event->getCreator();

    $result = 0;
    if($status == 2){
        $activityDAO->removeActivityByObject($userId, ActivityDAO::EVENT, $eventId, ActivityDAO::JOINED_EVENT);
        $result = $userDAO->joinEvent($eventId, $userId, $currDate);
        if($result == 0)
            $result = 1;
        $notificationsDAO->notify(NotificationsDAO::NEW_EVENT_REQUEST, $ownerId, $userId, $eventId);
	}
    else{
        $result = $eventDAO->userInEventRequest($userId,$eventId,$status,$currDate);
        $notificationsDAO->removeNotificationsByEvent($ownerId,$userId, $eventId, NotificationsDAO::NEW_EVENT_REQUEST);
        
        if($status == 1){
            $notificationsDAO->notify(NotificationsDAO::EVENT_REQUEST_ACCEPTED,$userId,'NULL',$eventId);
            $activityDAO->addActivity($userId, ActivityDAO::EVENT, 'null', $eventId, ActivityDAO::JOINED_EVENT);
		}
	}
    echo $result;
?>