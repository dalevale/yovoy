<!DOCTYPE html>

<html>
<head>
    <title>NOTIFICACIONES</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php';
		?>
    </header>
	<h3>Notificaciones</h3>
    <div class="tarjeta_gris">
    <?php ; 
        $eventDAO = new EventDAO();
        $userDAO = new UserDAO();
        $notificationsDAO = new NotificationsDAO();

        $createdEvents = $userDAO->getCreatedEvents($_SESSION["userId"]);
        $friendRequests= $userDAO->getFriendRequests($_SESSION["userId"]);
        $empty = true;

        $notificationsList = $notificationsDAO->getNotificationsByUser($_SESSION["userId"]);
        
        foreach($notificationsList as &$notification){
            $id = $notification->getId();
            $thatUser = $notification->getThatUser();
            $eventId = $notification->getEventId();
            $type = $notification->getType();
            $date = $notification->getDate();
            $isRead = $notification->isRead();
            
            if(!$isRead)
                $notificationsDAO->setRead(true);

            if($thatUser != NULL){
                $user= $userDAO->getUser($thatUser);
                $userId = $user->getUserId();
                $username = $user->getUsername();
            }

            if($eventId != NULL){
                $event = $eventDAO->getEvent($eventId);
                $eventName = $event->getName();
            }
        
            switch($type){
                case NotificationsDAO::NEW_FRIEND_REQUEST:
                    echo '<div class="tarjeta_blanca"><a href="profileView.php?profileId='.$userId.'">'.$username.'</a> quiere ser tu amigo.</div>';
                break;

                case NotificationsDAO::FRIEND_REQUEST_ACCEPTED:
                    echo '<div class="tarjeta_blanca"><a href="profileView.php?profileId='.$userId.'">'.$username.'</a> ha aceptado tu solicitud de amistad.</div>';
                break;

                case NotificationsDAO::NEW_EVENT_REQUEST:
                    echo '<div class="tarjeta_blanca"><a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' quiere unirse al evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.</div>';
                break;

                case NotificationsDAO::EVENT_REQUEST_ACCEPTED:
                    echo '<div class="tarjeta_blanca">Has sido aceptado en el evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.</div>';
                break;

                case NotificationsDAO::EVENT_EDITED:
                    echo '<div class="tarjeta_blanca">El evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a> ha sido modificado.</div>';
                break;

                case NotificationsDAO::NEW_COMMENT:
                    echo '<div class="tarjeta_blanca"><a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' ha comentado en el evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.</div>';
                break;

                case NotificationsDAO::EVENT_IS_NEAR:
                    //pendiente
                break;

                case NotificationsDAO::HAS_NEW_EVENT:
                    echo '<div class="tarjeta_blanca"><a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' ha creado un nuevo evento: <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.</div>';
                break;

                default:
                    echo 'Ha habido un error';
                break;
            }


            $empty = false;
        }


























       /* echo '<label> Solicitudes de eventos</label>';
        for($i = 0; $i < count($createdEvents); $i++) {
            $eventId = $createdEvents[$i]->getEventId();
            $waitingList = $eventDAO->getAttendees($eventId,false);
            $event = $eventDAO->getEvent($eventId);
            $eventName = $event->getName();

            for($j = 0; $j < count($waitingList); $j++) {
                echo '<div class="tarjeta_blanca">';
                $waitingUser = $userDAO->getUser($waitingList[$j]);
                $waitingUserName = $waitingUser->getUsername();
                $waitingUserId = $waitingUser->getUserId();
                echo '<a href="profileView.php?profileId='.$waitingUserId.'">'.$waitingUserName.'</a>';
                echo ' quiere unirse al evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.';

                echo '<form method="POST" action="includes/processUserInEvent.php">';
                echo '<input type="hidden" name="userId" value="'.$waitingUserId.'">';
                echo '<input type="hidden" name="event_id" value="'.$eventId.'">';
                echo '<input type="hidden" name="source" value="notifications">';
                echo '<input type="hidden" name="status" value="1">';
                echo '<button type="submit">Aceptar</button></form>';

                echo '<form method="POST" action="includes/processUserInEvent.php">';
                echo '<input type="hidden" name="userId" value="'.$waitingUserId.'">';
                echo '<input type="hidden" name="event_id" value="'.$eventId.'">';
                echo '<input type="hidden" name="source" value="notifications">';
                echo '<input type="hidden" name="status" value="0">';
                echo '<button type="submit">Rechazar</button></form>';
                echo '</div>';
                $empty = false;
            }  
        }
        */
        if($empty)
            echo '<div class="tarjeta_blanca">No tienes nuevas solicitudes de nada.</div>';
    ?>
    </div>
    
    

    <?php
       /* $empty = true;
        echo '<label> Solicitudes de amistad</label>';
        while(sizeof($friendRequests) != 0){
            $user = $userDAO->getUser(array_pop($friendRequests));
            $userId = $user->getUserId();
            $username = $user->getUsername();

            echo '<div class="tarjeta_blanca"><a href="profileView.php?profileId='.$userId.'">'.$username.'</a> quiere ser tu amigo.</div>'; 

            $empty = false;
        }

        if($empty)
            echo '<div class="tarjeta_blanca">No tienes nuevas solicitudes de amistad.</div>';
        */
    ?>


    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>