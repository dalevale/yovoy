<?php
require_once __DIR__.'/config.php';

    $commentsDAO = new CommentsDAO();
    $notificationsDAO = new NotificationsDAO();
    $eventDAO = new EventDAO();
    $userDAO = new UserDAO();
    $action = $_POST["action"];
    
    if(isset($_SESSION["userId"]) && $_SESSION["userId"]){
        if($action == "submit"){
        
            $eventId = $_POST["eventId"];
            $comment = $_POST["commentText"];
            $userId = $_SESSION["userId"];
            $event = $eventDAO->getEvent($eventId);
            $ownerId = $event->getCreator();
  
            $commentId = $commentsDAO->postComment($eventId, $userId, date("Y-m-d H:i:s"), $comment);

            if($_SESSION["userId"] != $ownerId)
                $notificationsDAO->notify(NotificationsDAO::NEW_COMMENT, $ownerId, $userId, $eventId);
        
            $username = $userDAO->getUser($userId)->getUsername();

            $arr = array ('userId'=> $userId, 'username'=> $username,'id'=> $commentId);
            echo json_encode($arr);
		}
        else if ($action == "delete"){
            $commentId = $_POST["commentId"];
            $result = $commentsDAO->deleteComment($commentId);
            echo $result;
		}
    }

