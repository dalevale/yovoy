<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <title>Ver Eventos - YoVoY</title>
    <script>
     function crearEvento(){
            window.location.href = "createEvent.php";
        }
    </script>
</head>
<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>

    <div>
        <?php
        if(isset($_SESSION["login"]))
            echo "<input type='image' src='includes/img/boton_CREAREVENTO.png' title='Crear un nuevo evento' onclick='crearEvento();'>";
       
            $app = es\ucm\fdi\aw\Application::getSingleton();
		    $conn = $app->bdConnection(); 
            //mostrar eventos de BBDD
            $eventDAO = new EventDAO($conn);
            $userDAO = new userDAO($conn);
          
            $result = $eventDAO->getAllEvents();
            if($result->num_rows > 0){
                    echo "<ul>";
                while($row = $result->fetch_assoc()){
                        $eventId = $row["event_id"];
                        $eventImgName = $eventDAO->getEvent($eventId)->getImgName();
                        $eventImgDir = "includes/img/events/";
                        $eventImgPath = $eventImgDir . $eventImgName;
                        $eventId = $row["event_id"];
                        echo "<li><ul class = 'evento'>";
                            echo "<a href= 'eventItem.php?event_id=".$eventId."'>";
                            echo "<img src='" . $eventImgPath . "' alt='event' height='50' width='50'>";
                            echo $row["name"] ." ";
                            echo "Date: ". $row["event_date"] ." ";
                            echo "Created by: ". $userDAO->getUser($row["creator"])->getUsername()." ";
                            echo "Capacity: ". $row["capacity"]." ";
                            echo "Location: ". $row["location"]." ";
                            echo "</a>";
                        echo "</ul></li>";
			    }
            echo "</ul>";
            }
        ?>
    </div>


    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
