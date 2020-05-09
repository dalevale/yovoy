<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
   $commentsDAO = new CommentsDAO();

   $eventId = $_POST["event_id"];

   $commentsDAO->deleteComment($_POST["comment_id"]);
   
  
    header("Location: ../eventItem.php?event_id=".$eventId."");

?>
