<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
   $app = es\ucm\fdi\aw\Application::getSingleton();
   $conn = $app->bdConnection(); 
   $commentsDAO = new CommentsDAO($conn);

   $eventId = $_POST["event_id"];

   $commentsDAO->deleteComment($_POST["comment_id"]);
   
  
    header("Location: ../eventItem.php?event_id=".$eventId."");

?>
