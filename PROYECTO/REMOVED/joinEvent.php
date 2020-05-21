<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
   $userDAO = new UserDAO();
   $notificationsDAO = new NotificationsDAO();
   $eventDAO = new EventDAO();
   $currDate = date("Y-m-d");
   $userId = $_SESSION["userId"];
   $event_id = $_POST["event_id"];

   $event = $eventDAO->getEvent($event_id);
   $ownerId = $event->getCreator();

   $userDAO->joinEvent($event_id, $userId, $currDate);
   $notificationsDAO->notify(NotificationsDAO::NEW_EVENT_REQUEST, $ownerId, $userId, $event_id);
   header("Location: ../eventItem.php?event_id=".$event_id."");

   
