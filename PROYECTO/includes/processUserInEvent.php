<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent

   $app = es\ucm\fdi\aw\Application::getSingleton();
   $conn = $app->bdConnection(); 
   $eventsDAO = new EventDAO($conn);

   $eventId = $_POST["event_id"];
   $userId = $_POST["userId"];
   $status = $_POST["status"];

   $eventsDAO->userInEventRequest($userId,$eventId,$status);
   
    header("Location: ../eventItem.php?event_id=".$eventId."");