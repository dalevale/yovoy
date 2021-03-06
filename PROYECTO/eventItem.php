<?php
    require_once __DIR__.'/includes/config.php';

     //OBTENEMOS EVENTO Y CREADOR
    $eventDAO = new EventDAO();
    $userDAO = new UserDAO();
    $commentsDAO = new CommentsDAO();
    $auxImgDAO = new AuxImgDAO();

    if(!empty($_GET))
        $_SESSION["eventId"] = $_GET["eventId"];
    $currentUserId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
   
    //Directorios de los imagenes
    $eventImgDir = "includes/img/events/";
    $userImgDir = "includes/img/users/";
    $auxImgDir = "includes/img/events_aux/";
        
    //Datos del evento
    $eventId = $_SESSION["eventId"];
    $event = $eventDAO->getEvent($eventId);
    $creatorId = $event->getCreator();
    $creator = $userDAO->getUser($creatorId);
    $creatorName = $creator->getName();
    $eventName = $event->getName();
    $eventImgName = $event->getImgName();
    $eventImgPath = $eventImgDir . $eventImgName;
    $creationDate = $event->getCreationDate();
    $eventDate = $event->getEventDate();
    $capacity = $event->getCapacity();
    $location = $event->getLocation();
    $descripcion = $event->getDescription();

    //Condiciones del evento
    $eventFull = $eventDAO->isEventFull($eventId,$capacity);
    $eventOver = $event->isEventOver();
    
    //Lista de los comentarios, la lista de espera, la colección de fotos, y la lista de los asistentes
    $commentList = $commentsDAO->getComments($_SESSION["eventId"]);
    $waitingList = $eventDAO->getAttendees($eventId,false);
    $auxImages = $auxImgDAO->getAuxImgs($eventId);
    $attendees = $eventDAO->getAttendees($eventId,true);

    //Condiciones necesarias para ver el contenido
    $loggedIn = isset($_SESSION["login"]) && $_SESSION["login"];
    $adminLoggedIn = isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"];
?>

<!DOCTYPE html>
<html>
<head>
    <!-- FOR BOOTSTRAP POSITIONING -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <?php echo '<title>'.$event->getName().'</title>';?>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div class = "container">
	    <div class = "row justify-content-between">  

        <div class="col-md-6 col-12 evento">
            <?php
                echo '<input type="hidden" id="eventId" value="'. $eventId.'">';
                echo '<h2>'.$eventName;
                if($eventOver)
                    echo ' (Ha terminado)';
                else if($eventFull)
                    echo ' (Lleno)';
                echo '</h2>';
                echo '<p>'.'Creador: <a href="profileView.php?profileId='.$creatorId.'">'.$creatorName.'</a></p>';
            
                echo 
                    "<div id='imageCarousel' class='carousel slide' data-ride='carousel'>
                        <ol class='carousel-indicators'>
                            <li data-target='#imageCarousel' data-slide-to='0' class='active'></li>";
            
                for ($i = 1; $i <= count($auxImages); $i++){
                    echo   "<li data-target='#imageCarousel' data-slide-to='" . $i ."'></li>";
                }

                echo
                    "</ol>
                    <div class='carousel-inner'>
                        <div class='carousel-item active'>
                            <img class='d-block w-100' src='" . $eventImgDir . $eventImgName . "?random=" . rand(0, 100000) . "' alt='' >
                        </div>";

                foreach ($auxImages as $img){
                    echo
                        "<div class='carousel-item'>
                            <img class='d-block w-100' src='" . $auxImgDir . $img . "?random=" . rand(0, 100000) . "' alt='' >
                        </div>";
                }

                echo 
                    "</div>
                    <a class='carousel-control-prev' href='#imageCarousel' role='button' data-slide='prev'>
                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                        <span class='sr-only'>Previous</span>
                    </a>
                    <a class='carousel-control-next' href='#imageCarousel' role='button' data-slide='next'>
                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                        <span class='sr-only'>Next</span>
                    </a>
                    </div>";

                echo '<p>'.'Fecha del evento: '.$eventDate.'</p>';
                echo '<p>'.'Capacidad: '.$capacity.'</p>';
                echo '<p>'.'Lugar: '.$location.'</p>';
                echo '<p>'.'Descripción: '.$descripcion.'</p>';
            ?>
            
            <div id="attendeeList" class="tarjeta_gris">
                <?php
                        if(!count($attendees)==0){
                            if($eventOver)
                                echo '<h3>En este evento han ido:</h3>';
                            else
                                echo '<h3>En este evento también van:</h3>';
                            for($i = 0; $i < count($attendees); $i++) {
                                $attendee =  $userDAO->getUser($attendees[$i]["userId"]);
                                $userClass = $attendee->isPremium()? "tarjeta_premium" : "tarjeta_blanca";
                                $joinDate = $attendees[$i]["joinDate"];
                                $date = date("Y-m-d g:ia", strtotime($joinDate));
                                $attendeeName = $attendee->getUsername();
                                $attendeeId = $attendee->getUserId();
					            $imgName = $attendee->getImgName();
					            $imgPath = $userImgDir . $imgName;
                                echo '<div class="'.$userClass.'"><a href="profileView.php?profileId='.$attendeeId.'"><img src = "'.$imgPath.'" width="20px" height="20px">'.$attendeeName.'</a>  '.$date.'</div>'; 
			                }
                        }
                        else{
                            echo '<div class="noAttendeesMsg">';
                            if($eventOver)
                                echo '<h3>Este evento ya ha terminado</h3>';
                            else if ($event->getCreator() != $currentUserId)
                                echo '<h3>Se el primero en apuntar a este evento!</h3>';
                            else
                                echo '<h3>Aún no hay nadie en tu evento</h3>';
                            echo '</div>';
                        }
                ?>
            </div>

            <div id="eventItemBtns">
                <?php
                    //Condiciones para diferentes botones:
                    if($loggedIn){
                        echo '<span id="promoteEventBtns">';
                        if(!$eventOver){
                            if(!$userDAO->isPromoting($currentUserId, $eventId))
                                echo '<input type="image" src="includes/img/boton_PROMO.png" alt="Promocionar" title="Promocionar" class="promoEventBtn">';
                
                            else 
                                echo '<input type="image" src="includes/img/boton_UNPROMO.png" alt="No promocionar" title="No promocionar" class="unpromoEventBtn">';
				        }
                        echo '</span>';
                
                        if($userDAO->isMyEvent($currentUserId, $eventId) || $adminLoggedIn){
                            if(!$eventOver){
                                echo '<span class="editSpan">';
                                echo '<form method="POST" action="editEvent.php"><input type="hidden" name="eventId" value="'.$eventId.'"/>';
                                echo '<input type="image" alt="Editar" src="includes/img/boton_EDITAR.png" title="Editar" name="Submit" id="frm1_submit" /></form>';
                                echo '</span>';
                            }
                            echo '<span class="editSpan">';
                            echo '<input type="image" src="includes/img/boton_FOTOS.png" id="manageAuxImgBtn" alt="Subir Fotos" title="Subir Fotos" type="submit">';
                            echo '</span>';

                            echo '<span class="editSpan">';
                            echo '<input type="image" alt="Eliminar" src="includes/img/boton_CANCELAR.png" title="Eliminar" id="deleteEventBtn" value="'.$eventId.'"/>';
                            echo '</span>';
                        }
                        else {
                            echo '<span id="joinCancelEventBtns">';
                            if($eventFull)
                                echo '<p>Este evento ya está lleno.</p>';
                            else if(!$userDAO->isAttending($currentUserId, $eventId)){
                                if($userDAO->hasEventInSameHour($currentUserId, $eventDate))
                                    echo '<p>Tienes un evento para la misma fecha y hora. Cancela otro evento que tengas pendiente si quieres unirte a este.</p>';
                                else if(!$eventOver)
                                    echo '<input type="image" src="includes/img/boton_UNIRSE_2.png" alt="YoVoy" title="YoVoy" class="joinEventBtn">';
                            }
                            else
                                echo '<input type="image" src="includes/img/boton_UNIRSE_3.png" alt="YaNoVoy" title="YaNoVoy" class="cancelEventBtn">';
                    
                            if($eventDAO->isUserInEvent($currentUserId, $eventId))
                                echo '¡Estás apuntado en este evento!';
                            echo '</span>';
                        }
                    }
                ?>
            </div>
        </div>

        <div class = "col-md-5 col-12 comentarios">
            <?php
                if($loggedIn && !$eventOver){
                    if($userDAO->isMyEvent($currentUserId, $eventId) || $adminLoggedIn){
                        echo "<div id='userWaitingList' class='tarjeta_naranja'>";
                        echo "<label>Lista de espera</label>";

                        if(!count($waitingList)==0){
                            echo '<div class="tarjeta_gris">';
                            for($i = 0; $i < count($waitingList); $i++) {
                                $waitingUser = $userDAO->getUser($waitingList[$i]["userId"]);
                                $userClass = $waitingUser->isPremium()? 'tarjeta_premium' : 'tarjeta_blanca';
                                $waitingUserName = $waitingUser->getUsername();
                                $waitingUserId = $waitingUser->getUserId();
                                $joinDate = date("Y-m-d g:ia", strtotime($waitingList[$i]["joinDate"]));
                                $imgName = $waitingUser->getImgName();
                                $imgPath = $userImgDir . $imgName;
                                echo '<div class="'. $userClass . ' user'.$waitingUserId.'">';
                                echo '<p><img src="'.$imgPath.'" width="20px" height="20px">';
                                echo '<a href="profileView.php?profileId='.$waitingUserId.'">'. $waitingUserName.'</a>'. $joinDate.'</p>';
                                echo '<input type="image" src="includes/img/boton_OK.png" width="20%" length="20%" alt="Aceptar" title="Aceptar" class="acceptUserBtn" value="'.$waitingUserId.'">';
                                echo '<input type="image" src="includes/img/boton_CANCELAR.png" width="20%" length="20%" alt="Rechazar" title="Rechazar" class="rejectUserBtn" value="'.$waitingUserId.'">';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        else
                            echo '<div class="tarjeta_blanca"><p>No hay nadie en lista de espera.</p></div>';
                        echo "</div>";
                    }
                }

                if($loggedIn && !$adminLoggedIn){
                    echo '<div class = "tarjeta_naranja">
                        <label>Escribe un comentario: </label>
                        <div class="tarjeta_gris">
                            <textarea id="newCommentText" style="resize: none" required name="comment" maxlength="240" placeholder="Di lo que piensas..." /></textarea>
                            <input type="image" width="15%" length="15%" src="includes/img/boton_COMENTAR.png" alt="Enviar Comentario" title="Enviar Comentario" id="submitCommentBtn" value="'.$eventId.'">
                        </div>
                    </div>';
                }
            ?>

            <div class = "lista_coments">
                <?php
                    echo "<label>COMENTARIOS</label>";
                    echo '<div id="commentsSection">';

                    if(empty($commentList)){
                        echo '<div class="tarjeta_blanca" id="emptyCom">';
                        echo "Parece que aún no hay comentarios...";
                        echo '</div>';
                    }
                    else{
                        while(sizeof($commentList) > 0){
                            $comment = array_pop($commentList);
                            $username = $userDAO->getUser($comment->getUserID())->getUsername();
                            $ownerId = $userDAO->getUser($comment->getUserID())->getUserId();
                            $date = date("Y-m-d g:ia", strtotime($comment->getDate()));

                            echo '<div class="tarjeta_gris">';
                                echo "<p>Comentario de <a href='profileView.php?profileId=$ownerId'>$username</a> el $date </p>";
                                echo '<div class="tarjeta_blanca ">';
                                echo $comment->getComment();
                                echo '</div>';
                        
                            if($loggedIn && $ownerId == $_SESSION["userId"] || $adminLoggedIn)
                                echo '<input type="image"  width="15%" length="15%" src="includes/img/boton_BORRARCOMENTARIO.png" alt="Enviar Comentario" title="Enviar Comentario" class="deleteCommentBtn" type="submit" value="'.$comment->getID().'">';
                            echo "</div>";
                        }
                    }
                    echo '</div>';
                ?>
            </div>
        </div>
        </div>
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>