<?php
require_once __DIR__.'/config.php';

    $notificationsDAO = new NotificationsDAO();
    $eventDAO = new EventDAO();
    $userDAO = new UserDAO();
    $currDate = date("Y-m-d H:i:s");
    $eventId = $_POST["eventId"];
    $userId = $_POST["userId"];
    $status = $_POST["status"];

    $event = $eventDAO->getEvent($eventId);
    $ownerId = $event->getCreator();

    $result = 0;
    if($status == 2){
        $result = $userDAO->joinEvent($eventId, $userId, $currDate);
        if($result == 0)
            $result = 1;
        $notificationsDAO->notify(NotificationsDAO::NEW_EVENT_REQUEST, $ownerId, $userId, $eventId);
	}
    else {
        $result = $eventDAO->userInEventRequest($userId,$eventId,$status,$currDate);
        $notificationsDAO->removeNotificationsByEvent($ownerId,$userId, $eventId, NotificationsDAO::NEW_EVENT_REQUEST);
        $notificationsDAO->notify(NotificationsDAO::EVENT_REQUEST_ACCEPTED,$userId,'NULL',$eventId);
	}
    echo $result;
?>