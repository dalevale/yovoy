<?php
    require_once __DIR__.'/includes/config.php';

     //OBTENEMOS EVENTO Y CREADOR
    $eventDAO = new EventDAO();
    $userDAO = new UserDAO();
    $commentsDAO = new CommentsDAO();

    if(!empty($_GET))
        $_SESSION["eventId"] = $_GET["eventId"];

    $event = $eventDAO->getEvent($_SESSION["eventId"]);
    $eventId = $_SESSION["eventId"];
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

    //Assistentes del evento con id $eventId
    $attendees = $eventDAO->getAttendees($eventId,true);
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
        echo '<input type="hidden" id="eventId" value="'. $eventId.'">';
        echo '<h2>'.$eventName.'</h2>';
        echo '<p>'.'Creador: <a href="profileView.php?profileId='.$creatorId.'">'.$creatorName.'</a></p>';
        echo "<img src='" . $eventImgPath . "?random=" . rand(0, 100000) . "' alt='event' height='500' width='500'>";

        //Condiciones para diferentes botones: Editar si es propio evento del usuario o Unirse si el contrario.
        if(isset($_SESSION["login"]) && $_SESSION["login"]){
            if($userDAO->isMyEvent($currentUserId, $eventId) || (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"])){
                echo '<form method="POST" action="editEvent.php"><input type="hidden" name="eventId" value="'.$eventId.'"/>';
                echo '<input type="image" alt="Editar" src="includes/img/boton_EDITAR.png" title="Editar" name="Submit" id="frm1_submit" /></form>';
            }
            else {
                echo '<div class="tarjeta_blanca">';
                if($eventDAO->isEventFull($eventId,$capacity))
                    echo '<p>Este evento ya está lleno.</p>';
               
                else if(!$userDAO->isAttending($currentUserId, $eventId)){
                    echo '<div id="joinCancelEventBtns">
                    <button type="button" class="joinEventBtn">YoVoy</button>
                    </div>';
                }
                else {
                    if($eventDAO->isUserInEvent($currentUserId, $eventId))
                        echo '¡Estás apuntado en este evento!';
                    else
                        echo '<div id="joinCancelEventBtns">
                            <button type="button" class="cancelEventBtn" value="'.$eventId.'">YaNoVoy</button>
                        </div>';
                }
                echo '</div>';
                echo '<div id="promoteEventBtns" class="tarjeta_blanca">';
                if(!$userDAO->isPromoting($currentUserId, $eventId)){
                    //echo '<form method="POST" action="includes/promoteEvent.php"><input type="hidden" name="eventId" value="'.$eventId.'"/>';
                    //echo '<input type="image" alt="submit" src="includes/img/boton_PROMO.png" title="Promocionar!" name="promoBtn"/></form>';
                    echo '<button type="button" class="promoEventBtn">Promocionar</button>';
                }
                else {
                    //echo '<form method="POST" action="includes/promoteEvent.php"><input type="hidden" name="eventId" value="'.$eventId.'"/>';
                    //echo '<input type="image" alt="submit" src="includes/img/boton_UNPROMO.png" title="Quitar promocion!" name="unpromoBtn"/></form>';
                    echo '<button type="button" class="unpromoEventBtn">No Promocionar</button>';
                }
                echo '</div>';
            }
            echo '<p>'.'Fecha de creación: '.$creationDate.'</p>';
            echo '<p>'.'Fecha del evento: '.$eventDate.'</p>';
            echo '<p>'.'Capacidad: '.$capacity.'</p>';
            echo '<p>'.'Lugar: '.$location.'</p>';
            echo '<p>'.'Descripción: '.$descripcion.'</p>';
        }
    ?>
    
        <div id="attendeeList" class="tarjeta_gris">
        <?php
            if(!count($attendees)==0){
                echo '<p>En este evento también van:</p>';
                for($i = 0; $i < count($attendees); $i++) {
                    $attendee =  $userDAO->getUser($attendees[$i]["userId"]);
                    $joinDate = $attendees[$i]["joinDate"];
                            $date = date("Y-m-d g:ia", strtotime($joinDate));
                    $attendeeName = $attendee->getUsername();
                    $attendeeId = $attendee->getUserId();
                    $imgDir = "includes/img/users/";
					$imgName = $attendee->getImgName();
					$imgPath = $imgDir . $imgName;
                    echo '<a href="profileView.php?profileId='.$attendeeId.'"><p><img src = "'.$imgPath.'" width="20px" height="20px">'.$attendeeName.'</a>  '.$date.'</p>'; 
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
                if($userDAO->isMyEvent($currentUserId, $eventId) || (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"])){
                    echo "<div id='userWaitingList' class='tarjeta_naranja'>";
                    $waitingList = $eventDAO->getAttendees($eventId,false);
                    echo "<label>Lista de espera</label>";

                    if(!count($waitingList)==0){
                        echo '<div class="tarjeta_gris">';
                        for($i = 0; $i < count($waitingList); $i++) {
                            $waitingUser = $userDAO->getUser($waitingList[$i]["userId"]);
                            $joinDate = $waitingList[$i]["joinDate"];
                            $date = date("Y-m-d g:ia", strtotime($joinDate));
                            $waitingUserName = $waitingUser->getUsername();
                            $waitingUserId = $waitingUser->getUserId();
                            $imgDir = "includes/img/users/";
				            $imgName = $waitingUser->getImgName();
				            $imgPath = $imgDir . $imgName;
                            echo '<div class="tarjeta_blanca user'.$waitingUserId.'">';
                            echo '<p><img src="'.$imgPath.'" width="20px" height="20px">';
                            echo '<a href="profileView.php?profileId='.$waitingUserId.'">'.$waitingUserName.'</a> se ha puntado en '.$date.'</p>';
                            echo '<button type="button" class="acceptUserBtn" value="'.$waitingUserId.'">Aceptar</button>';
                            echo '<button type="button" class="rejectUserBtn" value="'.$waitingUserId.'">Rechazar</button>';
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

                echo '<div class = "tarjeta_naranja">
                 <label>Escribe un comentario: </label>
        
                    <div class="tarjeta_gris">
                        <div><textarea id="newCommentText" style="resize: none" required name="comment" maxlength="240" placeholder="Di lo que piensas..." rows="5" cols="50"/></textarea></div>
                        <div><button id="submitCommentBtn" type="button" value="'.$eventId.'">Enviar comentario</button></div>
                    </div>
                </div>';
            }
        ?>

        <div class = "tarjeta_naranja">
            <?php
                $commentList = $commentsDAO->getComments($_SESSION["eventId"]);
                echo "<label>COMENTARIOS</label>";

                echo '<div id="commentsSection" class="tarjeta_blanca">';

                    while(sizeof($commentList) > 0){
                        $comment = array_pop($commentList);
                        
                        $username = $userDAO->getUser($comment->getUserID())->getUsername();
                        $ownerId = $userDAO->getUser($comment->getUserID())->getUserId();

                        echo '<div class="tarjeta_gris">';
                        
                        $date = date("Y-m-d g:ia", strtotime($comment->getDate()));

                        echo "<p>Comentario de <a href='profileView.php?profileId=$ownerId'>$username</a> el $date </p>";

                        echo '<div class="tarjeta_blanca ">';
                        echo $comment->getComment();
                        echo '</div>';
                        
                        if(isset($_SESSION["userId"]) && ($ownerId == $_SESSION["userId"]) || (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"])){
                            echo '<button class="deleteCommentBtn" type="submit" value="'.$comment->getID().'">Borrar comentario</button>';
                        }
                        echo "</div>";
                    }
                
                 echo '</div>';
            ?>
        </div>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
