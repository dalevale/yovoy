<?php 
    require_once __DIR__.'/includes/config.php';
?>

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
	<div class="container">
    <h1>Notificaciones</h1>
    <div class="tarjeta_gris">

    <?php 
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
            $date = date("d-m-Y", strtotime($notification->getDate()));
            $isRead = $notification->isRead();

            if($thatUser != NULL){
                $user= $userDAO->getUser($thatUser);
                $userId = $user->getUserId();
                $username = $user->getUsername();
                $_SESSION["thatUserId"] = $userId;
            }

            if($eventId != NULL){
                $event = $eventDAO->getEvent($eventId);
                $eventName = $event->getName();
                $_SESSION["eventId"] = $eventId;
            }

            echo '<div>';
            echo "<label>".$date."</label>";
            echo '</div>';
            
            echo '<div class="tarjeta_blanca">';
            echo '<div class="notificationLeft">';

            if(!$isRead)
                echo '<div class="notificationLeft" id="circle"></div>';

            echo '<div class="notificationRight">';
            switch($type){
                case NotificationsDAO::NEW_FRIEND_REQUEST:
                    echo '<div>';
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a> quiere ser tu amigo.';
                    echo '</div>';
                break;

                case NotificationsDAO::FRIEND_REQUEST_ACCEPTED:
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a> ha aceptado tu solicitud de amistad.';
                break;

                case NotificationsDAO::NEW_EVENT_REQUEST:
                    echo '<div>';
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' quiere unirse al evento <a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a>.';
                    echo '</div>';

                break;

                case NotificationsDAO::EVENT_REQUEST_ACCEPTED:
                    echo 'Has sido aceptado en el evento <a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a>.';
                break;

                case NotificationsDAO::EVENT_EDITED:
                    echo 'El evento <a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a> ha sido modificado.';
                break;

                case NotificationsDAO::NEW_COMMENT:
                    echo '<a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' ha comentado en el evento <a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a>.';
                break;

                case NotificationsDAO::EVENT_IS_NEAR:
                    //pendiente
                break;

                case NotificationsDAO::HAS_NEW_EVENT:
                    echo 'Tu amigo <a href="profileView.php?profileId='.$userId.'">'.$username.'</a>';
                    echo ' ha creado un nuevo evento: <a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a>.';
                break;

                default:
                    echo 'Ha habido un error';
                break;
            }
            echo '</div>';
            echo '</div>'; //div notificationLeft
            echo '<div class = "notificationRight">';

            if($isRead){
                echo '<div><form method="POST" action="includes/markAsRead.php">';
                echo '<input type="hidden" name="read" value="0">';
                echo '<input type="hidden" name="id" value='.$id.'>';
                echo '<button type="submit">Marcar como no leído</button></form></div>';
            }
            else{
                echo '<div><form method="POST" action="includes/markAsRead.php">';
                echo '<input type="hidden" name="read" value="1">';
                echo '<input type="hidden" name="id" value='.$id.'>';
                echo '<button type="submit">Marcar como leído</button></form></div>';
            }

            echo '<div><form method="POST" action="includes/deleteNotification.php">';
            echo '<input type="hidden" name="notificationId" value="'.$id.'">';
            echo '<button type="submit">Borrar notificación</button></form></div>';

            echo '</div>';
            echo '</div>';

            $empty = false;
        }
        
        if($empty)
            echo '<div class="tarjeta_blanca">No tienes nuevas notificaciones.</div>';
    ?>
    </div></div>
    
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>