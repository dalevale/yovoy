<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
   $notificationsDAO = new NotificationsDAO();

   $read = $_POST["read"];
   $id = $_POST["id"];
   $notificationsDAO->markAsRead($read,$id);

    header("Location: ../notifications.php");
