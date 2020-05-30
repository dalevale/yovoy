<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
    $notificationsDAO = new NotificationsDAO();

    $id = $_POST["notifId"];
    $action = $_POST["action"];

    if($action == 'mark'){
        $notif = $notificationsDAO->getNotification($id);
        $read = $notif->isRead()? 0 : 1;
        $result = $notificationsDAO->markAsRead($read,$id);
	}
    else
        $result = $notificationsDAO->removeNotificationsById($id);
    echo $result;