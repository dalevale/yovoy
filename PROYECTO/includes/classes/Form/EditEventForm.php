<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class EditEventForm extends Form
{

    private $eventId;
    public function __construct($eventId) {
        parent::__construct('editEventForm');
        $this->eventId = $eventId;
    }
    
    protected function generateFormFields($data)
    {
        $eventId = $this->eventId;
        $eventDAO = new EventDAO();
        $event = $eventDAO->getEvent($eventId);
        $eventName = $event->getName();
        $eventLocation = $event->getLocation();
        $eventEventDate = $event->getEventDate();
        $eventCapacity = $event->getCapacity();
        $eventTags = $event->getTags();
        $eventDescription = $event->getDescription();
        $html = <<<EOF
        <div class='tarjeta_gris'>
            <input type="hidden" name="eventId" value="$eventId"/>
            <p><label>Título: </label><input type="text" name="eventName"  value="$eventName" ></p>
            <p><label>Foto de evento</label></p>
            <p>
                <li><input type="radio" name="imgChoice" value="noChange" checked/><label>No cambiar la foto </label></li>
                <li><input type="radio" name="imgChoice" value="upload"/><label>Subir una foto para usar </label><input type="file" accept =".png, .jpg, .jpeg" name="img" /></li>
                <li><input type="radio" name="imgChoice" value="defaultImg"/><label>Cambiar foto a la predeterminada </label></li>
            </p>
            <p>
                <label>Fecha: </label><input type="date" name="eventDate" name="fecha" value="$eventEventDate" min="2020-01-01" max="2020-12-31">
                <label>Número máximo de asistentes: </label><input type="number" name="maxAssistants" value="$eventCapacity" min="1" max="100">
            </p>
            <label>Ubicación: </label><input type="text" name="eventLocation" value="$eventLocation" >
            <label>Etiquetas (separar por comas): </label><input type="text" name="eventTags" value="$eventTags">
            <p> <label for="address">Descripción del evento:</label> </p>
            <p> <textarea rows="9" cols="70" name="description">$eventDescription</textarea> </p>
            <input type="image" name="submit" alt="submit" title="Enviar" src='includes/img/boton_SUBIR.png'>
            <input type="image" id="editEventFormReset" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
            <input type="image" id="editEventFormCancel" alt="text" title="Cancelar" src='includes/img/boton_CANCELAR.png'>
	    </div>
        <script type="text/javascript" src="includes/js/validateEditEvent.js"></script>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        //Conectamos a BBDD
        $eventDAO = new EventDAO();
        $eventId = $this->eventId;
        $event = $eventDAO->getEvent($eventId);

        $result = array();
        //Valores introducidos por el creador del evento
        $eventTags = null;
        $eventTagsStr = null;
        if(isset($data["eventTags"]) && $data["eventTags"] != ""){
            $eventTagsStr = $data["eventTags"];
            $eventTags = explode(",", $data["eventTags"]);
        }
        //$email = $_REQUEST["email"];
        $text = isset($data["description"]) ? $data["description"] : null;

        //Valores por defecto
        $creationDate = date("Y-m-d");
        $creator = $_SESSION["userId"];

        $eventName = isset($data['eventName']) ? $data['eventName'] : null;
                
        if ( empty($eventName) ) {
            $result[] = "El nombre del evento no puede estar vacío";
        }

        $eventDate = isset($data['eventDate']) ? $data['eventDate'] : null;
                
        if ( empty($eventDate) ) {
            $result[] = "La fecha del evento no puede estar vacío";
        }
      
        $eventLocation = isset($data['eventLocation']) ? $data['eventLocation'] : null;
                
        if ( empty($eventLocation) ) {
            $result[] = "La ubicación del evento no puede estar vacío";
        }
        
        $maxAssistants = isset($data['maxAssistants']) ? $data['maxAssistants'] : null;
                
        if ( empty($maxAssistants) ) {
            $result[] = "Numero afóro del evento no puede estar vacío";
        }
        
        $changeImg = isset($data['imgChoice']) && $data['imgChoice'] !="noChange";

        if ($changeImg){
			$defaultImgName = "default-event.png"; // Nombre de la foto predeterminada

            // Si la foto anterior no es default.jpg, borrarla
            $currImgName = $event->getImgName();
            if ($currImgName != $defaultImgName){
                unlink ($_SERVER['DOCUMENT_ROOT'] . $targetDir . $currImgName);
            }

			if ($data['imgChoice'] == "defaultImg"){
				$imgName = $defaultImgName;
			}
			else{
				// Si hay una foto subida por el usuario, cambiarlo
				if (isset($_FILES['img'])){
					$targetDir = "/Yovoy/Proyecto/includes/img/events/";
					$imgName = $eventId . ".png";
					
					// Conseguir la dirección en que se guarda la foto subida
					$targetFilePath = $_SERVER['DOCUMENT_ROOT'] . $targetDir . $imgName;
					
					if ($imgName != $defaultImgName){
						// Mover la foto al directorio especificada en $targetDir
						if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)){
							$result[] = "Error: Se produjo un error al subir su foto.";
						}
					}
				}
				else{
					$result[] = "Error: No hay ninguna foto subida.";
				}
			}
		}

        if (count($result) === 0) {
            if(!$changeImg){ 
				$imgName = $event->getImgName();
            }
            
            $result = array();
            //Actualizar el evento en la BBDD
            if($eventDAO->updateEvent($eventId, $eventName, $maxAssistants, $eventLocation, $text, $eventTagsStr, $eventTags, $imgName)){
                $notificationsDAO = new NotificationsDAO();
                $eventsDAO = new EventDAO();
                $attendees = $eventsDAO->getAttendees($this->eventId,true);

                $user = array_pop($attendees);
                while(!empty($user)){
                    $notificationsDAO->notify(NotificationsDAO::EVENT_EDITED, $user, 'NULL', $this->eventId);
                    $user = array_pop($attendees);
                }
               
                $result = "eventItem.php?eventId=".$eventId;
            }
            else {
                $result[] = "¡Error al editar el evento! Consulta un administrador.";
			}
        }
        return $result;
    }
}