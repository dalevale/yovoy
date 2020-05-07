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
    <?php 
		$app = es\ucm\fdi\aw\Application::getSingleton();
		$conn = $app->bdConnection(); 
        $eventDAO = new EventDAO($conn);
        $userDAO = new UserDAO($conn);
    
        $createdEvents = $userDAO->getCreatedEvents($_SESSION["userId"]);
        $friendRequests= $userDAO->getFriendRequests($_SESSION["userId"]);

        $empty = true;

        echo '<label> Solicitud de eventos</label>';
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

        echo '</div>';

        echo '<div class="tarjeta_gris">';
        echo '<label> Solicitudes de amistad</label>';
        while(sizeof($friendRequests) != 0){
            $user = $userDAO->getUser(array_pop($friendRequests));
            $userId = $user->getUserId();
            $username = $user->getUsername();

            echo '<div class="tarjeta_blanca"><a href="profileView.php?profileId='.$userId.'">'.$username.'</a> quiere ser tu amigo.</div>'; 

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