<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class NewEventForm extends Form
{
    public function __construct() {
        parent::__construct('newEventForm');
    }
    
    protected function generateFormFields($data)
    {
        if ($data) {
        }
        $html = <<<EOF
        <div class = "tarjeta_gris">	
				<p><label>Título: </label><input type="text" name="eventName"></p>
				<p>    
                    <label>Foto:</label> <input class="control" type="file" accept =".png, .jpg, .jpeg" name="img" />
                    <label>Fecha: </label><input type="date" name="eventDate" name="fecha" value="2020-01-01" min="2020-01-01" max="2020-12-31">
                    <label>Hora: </label><input type="time" name="eventHour" name="hora">
                    <label>Número máximo de asistentes: </label><input type="number" name="maxAssistants" required value="1" min="1" max="100">
				</p>    
                <label>Ubicación: </label><input type="text" name="eventLocation">
				<label>Etiquetas (separar por comas): </label><input type="text" name="eventTags">
				<p> <label for="description">Descripción del evento:</label> </p>
                <p> <textarea rows="9" cols="70" name="description"></textarea> </p>
                
                <input type="image" name="submit" alt="submit" title="Enviar" src='includes/img/boton_SUBIR.png'>
                <input type="image" id="newEventFormReset" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
                <input type="image" id="newEventFormCancel" alt="text" title="Cancelar" src='includes/img/boton_CANCELAR.png'>
	    </div>
        <script type="text/javascript" src="includes/js/validateNewEvent.js"></script>
EOF;
        //TODO: NO FUNCIONA EL RESET DEL FORMULARIO!!!
    /*<button type="submit"> Enviar </button>
	  <button type="reset"> Borrar Campos </button>
	  <button type="text" onClick="goBack()"> Cancelar </button>*/
        return $html;
    }
    
    protected function processForm($data) {
        $result = array();
        $success = false;

        //Valores introducidos por el creador del evento
        $eventTagsString= $data["eventTags"];
        $eventTagsArray = ($eventTagsString != "") ? explode(",", $data["eventTags"]) : null;
        //$email = $_REQUEST["email"];
        $text = isset($data["description"]) ? $data["description"] : null;
        
        //$result[] = var_dump($eventTagsString) . " " . var_dump($eventTagsArray);

        //Valores por defecto
        $creationDate = date("Y-m-d g:ia");
        $creator = $_SESSION["userId"];

        $eventName = isset($data['eventName']) ? $data['eventName'] : null;
                
        if ( empty($eventName) ) {
            $result[] = "El nombre del evento no puede estar vacío";
        }

        $eventDate = isset($data['eventDate']) ? $data['eventDate'] : null;
                
        if ( empty($eventDate) ) {
            $result[] = "La fecha del evento no puede estar vacío";
        }

        $eventHour = isset($data['eventHour']) ? $data['eventHour'] : null;
                
        if ( empty($eventHour) ) {
            $result[] = "La hora del evento no puede estar vacío";
        }

        $eventDate = $eventDate . ' ' . $eventHour;
      
        $eventLocation = isset($data['eventLocation']) ? $data['eventLocation'] : null;
                
        if ( empty($eventLocation) ) {
            $result[] = "La ubicación del evento no puede estar vacío";
        }
        
        $maxAssistants = isset($data['maxAssistants']) ? $data['maxAssistants'] : null;
                
        if ( empty($maxAssistants) ) {
            $result[] = "Numero afóro del evento no puede estar vacío";
        }    
        
        // Si no hay un foto subido por el usuario, se usa default-event.jpg
		$imgName = "default-event.png";
		
        

        if (count($result) === 0) {
            //Conectamos a BBDD
            
            $userDAO = new UserDAO();
            $eventDAO = new EventDAO();
            $notificationsDAO = new NotificationsDAO();

            $result = array();
            //Añadir el evento a la BBDD
	        if ($eventDAO->registerEvent($eventName, $creator, $imgName, $creationDate, $eventDate, $endDate, $maxAssistants, $eventLocation, $text, $eventTagsString, $eventTagsArray) === true) {
                $_SESSION["eventCreated"] = true;
                $eventId = $eventDAO->getLastEvent();
                $friends = $userDAO->getFriends($creator);
                $user = array_pop($friends);

                while(!empty($user)){
                    $notificationsDAO->notify(NotificationsDAO::HAS_NEW_EVENT, $user->getUserId(), $creator, $eventId);
                    $user = array_pop($friends);
                }

                $success = true;
            }
            else {
                $result[] = "Error en crear evento! Consulta un administrador.";
			}
        }

        if (count($result) == 0 && !empty($_FILES["img"]["name"])){
            $success = false;

			$targetDir = "/Yovoy/Proyecto/includes/img/events/";
			$imgName = $eventId . ".png";
			$targetFilePath = $_SERVER["DOCUMENT_ROOT"] . $targetDir . $imgName;
		
			// Mover el foto al directorio de fotos de usuarios
			if (!move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)){
				$result[] = "Error: Se produjo un error al subir su foto";
            }
            else if ($eventDAO->updateEvent($eventId, $eventName, $maxAssistants, $eventLocation, $text, $eventTagsString, $eventTagsArray, $imgName)){
                $success = true;
            }
            else{
                $result[] = "Error: Se produjo un error al subir su foto. ";
            }
        }

        if ($success){
            $result = "createEvent.php";
        }

        return $result;
    }
}