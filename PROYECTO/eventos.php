<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <title>Ver Eventos - YoVoY</title>
    <script>
     function crearEvento(){
            window.location.href = "crearEvento.php";
        }
    </script>
</head>
<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>

    <div class = "lista_eventos">
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
                        $eventId = $row["event_id"]; //Hay que poner un class de css por aqui para cada evento
                        echo "<ul>";
                            echo "<a href= 'eventItem.php?event_id=".$eventId."'>";
                            echo "<li>". $row["name"] . " </li>";
                            echo "<li>Date: ". $row["event_date"] ." </li>";
                            echo "<li>Created by: ". $userDAO->getUser($row["creator"])->getUsername() . " </li>";
                            echo "<li>Capacity: ". $row["capacity"] ." </li>";
                            echo "<li>Location: ". $row["location"] ." </li>";
                            echo "</a>";
                        echo "</ul>";
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
