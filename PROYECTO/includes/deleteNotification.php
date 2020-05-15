<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
   $notificationsDAO = new NotificationsDAO();

   $id = $_POST["notificationId"];

   $notificationsDAO->removeNotificationsById($id);
   
    header("Location: ../notifications.php");

