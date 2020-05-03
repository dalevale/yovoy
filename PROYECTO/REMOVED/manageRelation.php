<?php
require_once __DIR__.'/config.php';

//metemos el user y el evento en la tabla de joinEvent
   $app = es\ucm\fdi\aw\Application::getSingleton();
   $conn = $app->bdConnection(); 
   $userDAO = new UserDAO($conn);
  // $currDate = date("Y-m-d");
   $userId = $_SESSION["userId"];
   $profileId = $_POST["profileId"];
   
   $userDAO->addFriend($userId, $profileId);
   header("Location: ../profileView.php?profileId=".$profileId."");

