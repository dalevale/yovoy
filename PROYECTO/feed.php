<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>

<html>
<head>
    <title>FEED</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div>
        <label>Eventos promocionados</label>
        <div class="tarjeta_naranja">
        <?php
        $userDAO = new UserDAO;
        $eventDAO = new EventDAO;
        $promotedEventsList = $userDAO->getPromotedEvents($_SESSION["userId"]);
        
        $eventImgDir = "includes/img/events/";
       

        foreach($promotedEventsList as $promotedEvent){
            echo '<div class="tarjeta_blanca"';
            
            $eventId=$promotedEvent->getEventId();
            $eventName = $promotedEvent->getName();
            $creatorId = $promotedEvent->getCreator();
            $creator = $userDAO->getUser($creatorId);
            $creatorName = $creator->getName();
            $eventDate = $promotedEvent->getEventDate();
            $eventImgPath =  $eventImgDir.$promotedEvent->getImgName();
            $location = $promotedEvent->getLocation();

            echo '<p> Evento: <a href="eventItem.php?event_id='.$eventId.'">'.$eventName.'</a></p>';
            echo '<p>'.'Creador: <a href="profileView.php?profileId='.$creatorId.'">'.$creatorName.'</a></p>';
            echo '<p> Fecha: '.$eventDate.'</p>';
            echo '<p> Lugar: '.$location.'</p>';
            echo '<a href="eventItem.php?event_id='.$eventId.'">'."<img src='" . $eventImgPath . "' alt='event' height='200' width='200'></a>";

            echo '</div>';
        }
        
        
        
        ?>
        </div>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>