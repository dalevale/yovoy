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
            
            echo '<div class="tarjeta_blanca">';
            switch($type){
                case NotificationsDAO::NEW_FRIEND_REQUEST:
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a> quiere ser tu amigo.';
                break;

                case NotificationsDAO::FRIEND_REQUEST_ACCEPTED:
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a> ha aceptado tu solicitud de amistad.';
                break;

                case NotificationsDAO::NEW_EVENT_REQUEST:
                    echo '<div>';
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' quiere unirse al evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.';
                    echo '</div>';
                    
                    echo '<div class="accept_reject">';
                    echo '<form method="POST" action="includes/processUserInEvent.php">';
                    echo '<input type="hidden" name="userId" value="'.$userId.'">';
                    echo '<input type="hidden" name="event_id" value="'.$eventId.'">';
                    echo '<input type="hidden" name="source" value="notifications">';
                    echo '<input type="hidden" name="status" value="1">';
                    echo '<button type="submit">Aceptar</button></form>';
                    echo '</div>';

                    echo '<div class="accept_reject">';
                    echo '<form method="POST" action="includes/processUserInEvent.php">';
                    echo '<input type="hidden" name="userId" value="'.$userId.'">';
                    echo '<input type="hidden" name="event_id" value="'.$eventId.'">';
                    echo '<input type="hidden" name="source" value="notifications">';
                    echo '<input type="hidden" name="status" value="0">';
                    echo '<button type="submit">Rechazar</button></form>';
                    echo '</div>';

                break;

                case NotificationsDAO::EVENT_REQUEST_ACCEPTED:
                    echo 'Has sido aceptado en el evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.';
                break;

                case NotificationsDAO::EVENT_EDITED:
                    echo 'El evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a> ha sido modificado.';
                break;

                case NotificationsDAO::NEW_COMMENT:
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' ha comentado en el evento <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.';
                break;

                case NotificationsDAO::EVENT_IS_NEAR:
                    //pendiente
                break;

                case NotificationsDAO::HAS_NEW_EVENT:
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' ha creado un nuevo evento: <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a>.';
                break;

                default:
                    echo 'Ha habido un error';
                break;
            }
            echo '<div class = "right_button">';
            echo '<form method="POST" action="includes/deleteNotification.php">';
            echo '<input type="hidden" name="notificationId" value="'.$id.'">';
            echo '<button type="submit">Borrar notificación</button></form>';
            echo '</div>';
            echo '</div>';

            $empty = false;
        }

        if($empty)
            echo '<div class="tarjeta_blanca">No tienes nuevas notificaciones.</div>';
    ?>
    </div>
    
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>