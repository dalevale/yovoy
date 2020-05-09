<?php
require_once __DIR__.'/config.php';

   //Gestión de procesamiento de eventos.
   $eventsDAO = new EventDAO();

   $eventId = $_POST["event_id"];
   $userId = $_POST["userId"];
   $status = $_POST["status"];
   $source = $_POST["source"];

   $eventsDAO->userInEventRequest($userId,$eventId,$status);
   
   if($source == "eventItem")
      header("Location: ../eventItem.php?event_id=$eventId");
   else if($source == "notifications")
      header("Location: ../notifications.php");
