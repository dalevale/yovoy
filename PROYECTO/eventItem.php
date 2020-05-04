<?php
require_once __DIR__.'/includes/config.php';

     //OBTENEMOS EVENTO Y CREADOR
    $app = es\ucm\fdi\aw\Application::getSingleton();
    $conn = $app->bdConnection(); 
    $eventDAO = new EventDAO($conn);
    $userDAO = new UserDAO($conn);
    
    if(!empty($_GET))
        $_SESSION["event_id"] = $_GET["event_id"];

    $event = $eventDAO->getEvent($_SESSION["event_id"]);
    $eventId = $_SESSION["event_id"];
    $creatorId = $event->getCreator();
    
    $creator = $userDAO->getUser($creatorId);
    $creatorName = $creator->getName();
    $eventImgName = $event->getImgName();
    $creationDate = $event->getCreationDate();
    $eventDate = $event->getEventDate();
    $capacity = $event->getCapacity();
    $location = $event->getLocation();
    $descripcion = $event->getDescription();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
     <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />

    <?php echo '<title>'.$event->getName().'</title>';?>

</head>
<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>

    <div class = "evento">
        <?php 
            $eventImgDir = "includes/img/events/";
            $eventImgPath = $eventImgDir . $eventImgName;
            $currentUserId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
            echo '<h1>'.$event->getName().'</h1>'; 
            echo "<img src='" . $eventImgPath . "' alt='event' height='500' width='500'>";
            echo '<p>'.'Creador: '.$creatorName.'</p>';
            echo '<p>'.'Fecha de creación: '.$creationDate.'</p>';
            echo '<p>'.'Fecha del evento: '.$eventDate.'</p>';
            echo '<p>'.'Capacidad: '.$capacity.'</p>';
            echo '<p>'.'Lugar: '.$location.'</p>';
            echo '<p>'.'Descripción: '.$descripcion.'</p>';
            $attendees = $eventDAO->getAttendees($_SESSION["event_id"]);
            ?><div class="tarjeta_gris"><?php
            if(!count($attendees)==0){
                echo '<p>En este evento también van:</p>';
                for($i = 0; $i < count($attendees); $i++) {
                    $attendee =  $userDAO->getUser($attendees[$i]);
                    $attendeeName = $attendee->getUsername();
                    $attendeeId = $attendee->getUserId();
                    echo '<a href="profileView.php?profileId='.$attendeeId.'"><p>'.$attendeeName.'</p></a>'; 
                    
			    }
            }
            else{
                echo '<p>Se el primero en apuntar a este evento!</p>';
            }
            ?></div><?php
            
            
            
            if(isset($_SESSION["login"]) && $_SESSION["login"]){
                if($userDAO->isMyEvent($currentUserId, $eventId)){
                    echo '<form method="POST" action="editEvent.php"><input type="hidden" name="eventId" value="'.$eventId.'"/>';
                    echo '<input type="image" alt="Editar" src="includes/img/boton_EDITAR.png" title="Editar" name="Submit" id="frm1_submit" /></form>';
                    // echo '<input type="submit" value="Editar" name="Submit" id="frm1_submit" /></form>';
                }
            
                else if(!$userDAO->isAttending($currentUserId, $eventId)){
                    echo '<form method="POST" action="includes/joinEvent.php"><input type="hidden" name="eventId" value="'.$eventId.'"/>';
                    echo '<input type="image" alt="submit" src="includes/img/boton_UNIRSE_1.png" title="Me apunto!" name="Submit" id="frm1_submit" /></form>';
                }
                else {
                    echo '<p>Estas apuntado en este evento!</p>';        
				}
            }
            /*if (isset($_SESSION["login"]) && $_SESSION["login"] = true){
               echo '<form method="POST" action="includes/joinEvent.php"><input type="hidden" name="event_id" value="'.$_SESSION["event_id"].'">';
               echo '<input type="image" alt="submit" src="includes/img/boton_UNIRSE_1.png" title="Me apunto!" name="Submit" id="frm1_submit" /></form>';
            }*/
        ?>   
    </div>
    
    <?php
        if(isset($_SESSION["userId"]) && $_SESSION["userId"]){
            echo '<div class = "escribir_Comentario">';
        
            $form = new CommentsForm;
            $form->manage();
       
            echo '</div>';
        }
    ?>
    
    <div class = "tarjeta_naranja">
        <?php
            $app = es\ucm\fdi\aw\Application::getSingleton();
		    $conn = $app->bdConnection(); 
            //mostrar eventos de BBDD
            $userDAO = new UserDAO($conn);
            $commentsDAO = new CommentsDAO($conn);
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
                    
                    $date ="";
                    $dateInvert = explode("-", $comment->getDate());

                    for($i = sizeof($dateInvert)-1; $i >= 0; $i--){
                        $date .= $i == 0 ? $dateInvert[$i] : $dateInvert[$i]."-";
                    }

                    echo "Comentario de " .$username. " el ".$date. "</br>";

                    echo '<div class="tarjeta_blanca">';
                    echo $comment->getComment();
                    echo '</div>';
                    
                    if(isset($_SESSION["userId"]) && ($ownerId == $_SESSION["userId"])){
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


    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
