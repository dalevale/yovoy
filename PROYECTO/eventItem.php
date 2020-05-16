<?php
require_once __DIR__.'/includes/config.php';

     //OBTENEMOS EVENTO Y CREADOR
    $eventDAO = new EventDAO();
    $userDAO = new UserDAO();
    $commentsDAO = new CommentsDAO();
    
    if(!empty($_GET))
        $_SESSION["event_id"] = $_GET["event_id"];

    $event = $eventDAO->getEvent($_SESSION["event_id"]);
    $event_id = $_SESSION["event_id"];
    $creatorId = $event->getCreator();
    
    $creator = $userDAO->getUser($creatorId);
    $creatorName = $creator->getName();
    $eventName = $event->getName();
    $eventImgName = $event->getImgName();
    $eventImgDir = "includes/img/events/";
    $eventImgPath = $eventImgDir . $eventImgName;
    $creationDate = $event->getCreationDate();
    $eventDate = $event->getEventDate();
    $capacity = $event->getCapacity();
    $location = $event->getLocation();
    $descripcion = $event->getDescription();

    //Assistentes del evento con id $event_id
    $attendees = $eventDAO->getAttendees($event_id,true);
    $currentUserId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <?php echo '<title>'.$event->getName().'</title>';?>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div class = "evento">
    <?php
        echo '<h2>'.$eventName.'</h2>';
        echo '<p>'.'Creador: <a href="profileView.php?profileId='.$creatorId.'">'.$creatorName.'</a></p>';
        echo "<img src='" . $eventImgPath . "' alt='event' height='500' width='500'>";

        //Condiciones para diferentes botones: Editar si es propio evento del usuario o Unirse si el contrario.
        if(isset($_SESSION["login"]) && $_SESSION["login"]){
            if($userDAO->isMyEvent($currentUserId, $event_id) || (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"])){
                echo '<form method="POST" action="editEvent.php"><input type="hidden" name="event_id" value="'.$event_id.'"/>';
                echo '<input type="image" alt="Editar" src="includes/img/boton_EDITAR.png" title="Editar" name="Submit" id="frm1_submit" /></form>';
            }
            else if($eventDAO->isEventFull($event_id,$capacity)){
                echo '<div class="tarjeta_blanca">Este evento ya está lleno.</div>';

                if($eventDAO->isUserInEvent($currentUserId, $event_id))
                    echo '<div class="tarjeta_blanca">¡Estás apuntado en este evento!</div>';  
			}
            else if(!$userDAO->isAttending($currentUserId, $event_id)){
                echo '<form method="POST" action="includes/joinEvent.php"><input type="hidden" name="event_id" value="'.$event_id.'"/>';
                echo '<input type="image" alt="submit" src="includes/img/boton_UNIRSE_1.png" title="Me apunto!" name="Submit" id="frm1_submit" /></form>';
            }
            else {
                echo '<div class="tarjeta_blanca">';
                if($eventDAO->isUserInEvent($currentUserId, $event_id))
                    echo '¡Estás apuntado en este evento!';
                else
                    echo 'Esperando respuesta del organizador...';
                
                $cancelForm = new CancelEventRequestForm;
                $cancelForm->manage(); 
                echo '</div>';
            }
        }
        echo '<p>'.'Fecha de creación: '.$creationDate.'</p>';
        echo '<p>'.'Fecha del evento: '.$eventDate.'</p>';
        echo '<p>'.'Capacidad: '.$capacity.'</p>';
        echo '<p>'.'Lugar: '.$location.'</p>';
        echo '<p>'.'Descripción: '.$descripcion.'</p>';
    ?>
    
        <div class="tarjeta_gris">
        <?php
            if(!count($attendees)==0){
                echo '<p>En este evento también van:</p>';
                for($i = 0; $i < count($attendees); $i++) {
                    $attendee =  $userDAO->getUser($attendees[$i]);
                    $attendeeName = $attendee->getUsername();
                    $attendeeId = $attendee->getUserId();
                    $imgDir = "includes/img/users/";
					$imgName = $attendee->getImgName();
					$imgPath = $imgDir . $imgName;
                    echo '<a href="profileView.php?profileId='.$attendeeId.'"><p><img src = "'.$imgPath.'" width="20px" height="20px">'.$attendeeName.'</p></a>'; 
			    }
            }
            else{
                echo '<p>Se el primero en apuntar a este evento!</p>';
            }
        ?>
        </div>
    </div>
    
    <!-- Parte de comentarios a la derecha-->
    <div id = "comentarios">
        <?php
            if(isset($_SESSION["login"]) && $_SESSION["login"] ){
                if($userDAO->isMyEvent($currentUserId, $event_id) || (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"])){
                    echo "<div class='tarjeta_naranja'>";
                    $waitingList = $eventDAO->getAttendees($event_id,false);
                    echo "<label>Lista de espera</label>";

                    if(!count($waitingList)==0){
                        echo '<div class="tarjeta_gris">';
                        for($i = 0; $i < count($waitingList); $i++) {
                            
                            echo '<div class="tarjeta_blanca">';
                            $waitingUser = $userDAO->getUser($waitingList[$i]);
                            $waitingUserName = $waitingUser->getUsername();
                            $waitingUserId = $waitingUser->getUserId();
                            echo '<a href="profileView.php?profileId='.$waitingUserId.'"><p>'.$waitingUserName.'</p></a>';
                            
                            $_SESSION["thatUserId"] = $waitingUserId;
                            $_SESSION["event_id"] = $event_id;
                            $_SESSION["source"] = "eventItem";
                            $form = new AcceptEventForm;
                            $form->manage();
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    else{
                        echo '<div class="tarjeta_blanca"><p>No hay nadie en lista de espera.</p></div>';
                    }

                    echo "</div>";
                }
            }
        ?>

   
        <?php
            if(isset($_SESSION["userId"]) && $_SESSION["userId"] && (isset($_SESSION["esAdmin"]) && !$_SESSION["esAdmin"])){
                
                echo "<div class = 'tarjeta_naranja'>";
                //echo '<div class = "escribir_Comentario">';
                $form = new CommentsForm;
                $form->manage();
                echo "</div>";
            }
        ?>

        <div class = "tarjeta_naranja">
            <?php
                $commentList = $commentsDAO->getComments($_SESSION["event_id"]);
                echo "<label>COMENTARIOS</label>";

                if(sizeof($commentList) == 0){
                    echo '<div class="tarjeta_blanca">';
                    echo 'Parece que aún no hay comentarios...';
                    echo '</div>';
                }
                else{
                    while(sizeof($commentList) > 0){
                        $comment = array_pop($commentList);
                        
                        $username = $userDAO->getUser($comment->getUserID())->getUsername();
                        $ownerId = $userDAO->getUser($comment->getUserID())->getUserId();

                        echo '<div class="tarjeta_gris">';
                        
                        $date = date("d-m-Y", strtotime($comment->getDate()));

                        echo "Comentario de <a href='profileView.php?profileId=$ownerId'>$username</a> el $date </br>";

                        echo '<div class="tarjeta_blanca">';
                        echo $comment->getComment();
                        echo '</div>';
                        
                        if(isset($_SESSION["userId"]) && ($ownerId == $_SESSION["userId"]) || (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"])){
                            echo '<form method="POST" action="includes/deleteComment.php">';
                            echo '<input type="hidden" name="comment_id" value="'.$comment->getID().'">';
                            echo '<input type="hidden" name="event_id" value="'.$_SESSION["event_id"].'">';
                            echo '<button type="submit">Borrar comentario</button></form>';
                        }
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
