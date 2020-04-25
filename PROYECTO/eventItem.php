<?php
require_once __DIR__.'/includes/config.php';

     //OBTENEMOS EVENTO Y CREADOR
    $app = es\ucm\fdi\aw\Application::getSingleton();
    $conn = $app->bdConnection(); 
    $eventDAO = new EventDAO($conn);
    $userDAO = new UserDAO($conn);

    $eventId = $_GET["event_id"];

    $event = $eventDAO->getEvent($eventId);
    $creatorId = $event->getCreator();
    
    $creator = $userDAO->getUser($creatorId);
    $creatorUsername = $creator->getUsername();
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

    <div>
        <?php 
            $eventImgDir = "includes/img/events/";
            $eventImgPath = $eventImgDir . $eventImgName;

            $currentUserId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
            echo '<h1>'.$event->getName().'</h1>';
            echo "<img src='" . $eventImgPath . "' alt='event' height='500' width='700'>";
            echo '<p>'.'Creador: '.$creatorUsername.'</p>';
            echo '<p>'.'Fecha de creación: '.$creationDate.'</p>';
            echo '<p>'.'Fecha del evento: '.$eventDate.'</p>';
            echo '<p>'.'Capacidad: '.$capacity.'</p>';
            echo '<p>'.'Lugar: '.$location.'</p>';
            echo '<p>'.'Descripción: '.$descripcion.'</p>';
            $attendees = $eventDAO->getAttendees($eventId);
            if(!count($attendees)==0){
                echo '<p>En este evento también van:</p>';
                for($i = 0; $i < count($attendees); $i++) {
                    $attendeeName = $userDAO->getUser($attendees[$i])->getUsername();
                    echo '<p>'.$attendeeName.'<p>';  
			    }
			}
            else{
                echo '<p>Se el primero en apuntar a este evento!</p>';
			}
            if (isset($_SESSION["login"]) && $_SESSION["login"] = true){
               // echo "<input type="submit" value="Go to my link location" onclick="window.location='includes/joinEvent.php?event_id=".$eventId."';" />" 
               // echo '<input type="button" onclick=header('Location: includes/joinEvent.php?event_id=".$eventId."')>Me apunto!</input>';            
               if($userDAO->isMyEvent($currentUserId, $eventId)){
                   echo '<form method="POST" action="editEvent.php"><input type="hidden" name="eventId" value="'.$eventId.'"/>';
                   echo '<input type="submit" value="Editar" name="Submit" id="frm1_submit" /></form>';
			   }
               else{
                   echo '<form method="POST" action="includes/joinEvent.php"><input type="hidden" name="event_id" value="'.$eventId.'"/>';
                   echo '<input type="submit" value="Me apunto!" name="Submit" id="frm1_submit" /></form>';
			   }
			}
        ?>   
    </div>

    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
