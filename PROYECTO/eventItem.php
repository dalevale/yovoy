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
    $eventClass = $event->isEventOver()? 'eventoOver' : 'evento';
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

    //Conseguir los nombres de fotos auxiliares del evento (TODO: acceder la BBDD)
    $auxImages = array();

    //La siguiente línea es para probar la funcionalidad de carousel
    $auxImages[] = "default-event.png";
?>

<!DOCTYPE html>
<html>
<head>
    <!-- FOR BOOTSTRAP POSITIONING -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- -->
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

    <div class="col-md-6 col-12  <?php echo $eventClass?>">
        <?php
            echo '<input type="hidden" id="eventId" value="'. $eventId.'">';
            echo '<h2>'.$eventName.'</h2>';
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
                            <img class='d-block w-100' src='" . $eventImgDir . $img . "?random=" . rand(0, 100000) . "' alt='' >
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

                        else{
                            echo '<div id="joinCancelEventBtns">
                                <button type="button" class="cancelEventBtn">YaNoVoy</button>
                            </div>';
                        }
                        if($eventDAO->isUserInEvent($currentUserId, $eventId)){
                            echo '¡Estás apuntado en este evento!';
                        }
                        echo '</div>';

                    }
                }
                echo '<div id="promoteEventBtns" class="tarjeta_blanca">';
                if(!$userDAO->isPromoting($currentUserId, $eventId)){
                    echo '<button type="button" class="promoEventBtn">Promocionar</button>';
                }
                else {
                    echo '<button type="button" class="unpromoEventBtn">No Promocionar</button>';
                }
                echo '</div>';
            }
            echo '<p>'.'Fecha de creación: '.$creationDate.'</p>';
            echo '<p>'.'Fecha del evento: '.$eventDate.'</p>';
            echo '<p>'.'Capacidad: '.$capacity.'</p>';
            echo '<p>'.'Lugar: '.$location.'</p>';
            echo '<p>'.'Descripción: '.$descripcion.'</p>';
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
                        if($event->getCreator() != $currentUserId)
                            echo '<p>Se el primero en apuntar a este evento!</p>';
                        else
                            echo '<p>Aún no hay nadie en tu evento</p>';
                    }
                ?>
                <!-- Parte de comentarios a la derecha-->
        </div>
    </div>

    <div class = "col-md-5 col-12 comentarios">
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
                            $joinDate = date("Y-m-d g:ia", strtotime($waitingList[$i]["joinDate"]));
                            $waitingUserName = $waitingUser->getUsername();
                            $waitingUserId = $waitingUser->getUserId();
                            $imgDir = "includes/img/users/";
                            $imgName = $waitingUser->getImgName();
                            $imgPath = $imgDir . $imgName;
                            echo '<div class="tarjeta_blanca user'.$waitingUserId.'">';
                            echo '<p><img src="'.$imgPath.'" width="20px" height="20px">';
                            echo '<a href="profileView.php?profileId='.$waitingUserId.'">'.$waitingUserName.'</a>'. $joinDate.'</p>';
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

        <div class = "lista_coments">
            <?php
                $commentList = $commentsDAO->getComments($_SESSION["eventId"]);
                echo "<label>COMENTARIOS</label>";

                echo '<div id="commentsSection">';

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

    

       

    </div>
</div>



<footer>
    <?php include 'includes/comun/footer.php' ?>
</footer>
</body>
</html>