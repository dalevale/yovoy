<?php
require_once __DIR__.'/includes/config.php';

     //OBTENEMOS EVENTO Y CREADOR
    $app = es\ucm\fdi\aw\Application::getSingleton();
    $conn = $app->bdConnection(); 
    $eventDAO = new EventDAO($conn);
    $creatorDAO = new UserDAO($conn);

    $eventId = $_GET["event_id"];

    $event = $eventDAO->getEvent($eventId);
    $creatorId = $event->getCreator();
    
    $creator = $creatorDAO->getUser($creatorId);
    $creatorName = $creator->getName();

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

           

            //$currentUserId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
            echo '<h1>'.$event->getName().'</h1>';
            echo '<p>'.'Creador: '.$creatorName.'</p>';
            echo '<p>'.'Fecha de creación: '.$creationDate.'</p>';
            echo '<p>'.'Fecha del evento: '.$eventDate.'</p>';
            echo '<p>'.'Capacidad: '.$capacity.'</p>';
            echo '<p>'.'Lugar: '.$location.'</p>';
            echo '<p>'.'Descripción: '.$descripcion.'</p>';
            if (isset($_SESSION["login"]) && $_SESSION["login"] = true){
               // echo "<input type="submit" value="Go to my link location" onclick="window.location='includes/joinEvent.php?event_id=".$eventId."';" />" 
               //echo '<input type="button" onclick=header('Location: includes/joinEvent.php?event_id=".$eventId."')>Me apunto!</input>';            
               echo '<form method="POST" action="/includes/joinEvent.php"><input type="hidden" name="event_id" value="'.$eventId.'"/>';
               echo '<input type="submit" value="Me apunto!" name="Submit" id="frm1_submit" /></form>';
			}
        ?>   
    </div>

    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
