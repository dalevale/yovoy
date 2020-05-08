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
       
            $app = es\ucm\fdi\aw\Application::getSingleton();
		    $conn = $app->bdConnection(); 
            $eventDAO = new EventDAO($conn);
            $userDAO = new userDAO($conn);
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
                    echo "<a href= 'eventItem.php?event_id=".$eventId."'>";
                    echo "<img src='" . $eventImgPath . "' alt='event' height='50' width='50'>";
                    echo $event->getName() ." ";
                    echo "Date: ". $event->getEventDate() ." ";
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
