<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
   $userDAO = new UserDAO();
   $currDate = date("Y-m-d");
   $userId = $_SESSION["userId"];
   $event_id = $_POST["event_id"];

   $userDAO->joinEvent($event_id, $userId, $currDate);
   header("Location: ../eventItem.php?event_id=".$event_id."");

   
