<?php
require_once __DIR__.'/config.php';

   //Gestión de procesamiento de eventos.
   $eventsDAO = new EventDAO();
   $notificationsDAO = new NotificationsDAO();
   $eventId = $_POST["event_id"];
   $userId = $_POST["userId"];
   $status = $_POST["status"];
   $source = $_POST["source"];

   $event = $eventsDAO->getEvent($eventId);
   $ownerId = $event->getCreator();

   $eventsDAO->userInEventRequest($userId,$eventId,$status);
   $notificationsDAO->removeNotificationsByEvent($ownerId,$userId, $eventId);
   $notificationsDAO->notify(NotificationsDAO::EVENT_REQUEST_ACCEPTED,$userId,'NULL',$eventId);
   if($source == "eventItem")
      header("Location: ../eventItem.php?event_id=$eventId");
   else if($source == "notifications")
      header("Location: ../notifications.php");
