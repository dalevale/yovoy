<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Eventos - YoVoY</title>
    <script>
     function crearEvento(){
            window.location.href = "createEvent.php";
        }
    </script>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div>
        <?php
        if(isset($_SESSION["login"]))
            echo "<input type='image' src='includes/img/boton_CREAREVENTO.png' title='Crear un nuevo evento' onclick='crearEvento();'>";
        
            $eventDAO = new EventDAO();
            $userDAO = new userDAO();
            $eventsList = $eventDAO->getAllEvents();

            //Mostrar eventos de BBDD
            echo "<ul>";
            while(sizeof($eventsList) > 0){
                $event = array_pop($eventsList);
                $eventImgName = $event->getImgName();
                $eventImgDir = "includes/img/events/";
                $eventImgPath = $eventImgDir . $eventImgName;
                $eventId = $event->getEventId();
                echo "<div class = 'eventos'>";
                    echo "<a href= 'eventItem.php?eventId=".$eventId."'>";
                    echo "<img src='" . $eventImgPath . "?random=" . rand(0, 100000) . "' alt='event' height='50' width='50'>";
                    echo "<div class = 'nombreEvento'>";
                    echo $event->getName() ." ";
                    echo "</div>";
                    $date = date("Y-m-d g:ia", strtotime( $event->getEventDate() ));
                    echo "  Date: ".$date." ";
                    echo "Created by: ". $userDAO->getUser($event->getCreator())->getUsername()." ";
                    echo "Capacity: ". $event->getCapacity()." ";
                    echo "Location: ". $event->getLocation()." ";
                    echo "</a>";
                echo "</div>";
			    }
            echo "</ul>";
        ?>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
