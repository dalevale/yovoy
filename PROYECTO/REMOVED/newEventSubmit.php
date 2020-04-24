<?php
require_once __DIR__.'/config.php';

//Valores introducidos por el creador del evento
$eventName = $_REQUEST["eventName"];
$eventDate = $_REQUEST["eventDate"];
$eventLocation = $_REQUEST["eventLocation"];
$eventAssistants = $_REQUEST["maxAssistants"];
$eventTags = explode(",", $_REQUEST["eventTags"]);
//$email = $_REQUEST["email"];
$text = $_REQUEST["description"];

//Valores por defecto
$creationDate = date("Y-m-d");
$creator = $_SESSION["userId"];

/*CREATE TABLE `event` (
  `eventId` int(11) NOT NULL, -FALTA - GENERADO DESDE EL ANTERIOR 
  `name` int(11) NOT NULL, -eventName
  `creator` varchar(20) NOT NULL, -email
  `creationDate` date NOT NULL, -FALTA -
  `eventDate` date NOT NULL, -eventDate
  `capacity` int(11) NOT NULL, -eventAssistants
  `location` varchar(50) NOT NULL -eventLocation
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

//-FALTA - DESCRIPCION DEL EVENTO

ASEGURAMOS QUE NO DEJAMOS HUECOS EN EL FORMULARIO
No pueden estar vacios ni titulo, ni ubicacion ni correo. La fecha puede ser variable. Los asistentes tienen ya un minimo por defecto
*/
if($eventLocation == "" || $eventName== "" /* || $email == ""*/){
   $_SESSION["noBlanks"] = false;
    header("Location: /crearEvento.php");
}

else { //INICIAMOS CONEXIÓN CON MYSQL

    $app = es\ucm\fdi\aw\Application::getSingleton();
	$conn = $app->bdConnection(); 

    $eventDAO = new EventDAO($conn);
    $_SESSION["noBlanksEvent"] = true;
	
	//Añadir el evento a la BBDD
	if ($eventDAO->registerEvent($eventName, $creator, $creationDate, $eventDate, $eventAssistants, $eventLocation, $text, $eventTags) === true) {
		$_SESSION["eventCreated"] = true;
        header("Location: /crearEvento.php");
	} 
	else {
        $_SESSION["eventCreated"] = false;
		echo "Error: " . $conn->error;
		header("Location: /crearEvento.php");
	}
}

?>
