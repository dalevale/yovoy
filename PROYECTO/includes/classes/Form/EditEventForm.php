<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class EditEventForm extends Form
{

    private $eventId;
    public function __construct($eventId) {
        parent::__construct('newEventForm');
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
            <input type="hidden" name="event_id" value="$eventId"/>'
            <p><label>Título: </label><input type="text" name="eventName"  value="$eventName"required ></p>
            <p><label>Foto de evento</label></p>
            <p>
                <li><input type="radio" name="imgChoice" value="noChange" checked/><label>No cambiar la foto </label></li>
                <li><input type="radio" name="imgChoice" value="upload"/><label>Subir una foto para usar </label><input type="file" accept =".png, .jpg, .jpeg" name="img" /></li>
                <li><input type="radio" name="imgChoice" value="defaultImg"/><label>Cambiar foto a la predeterminada </label></li>
            </p>
            <p>
                <label>Fecha: </label><input type="date" name="eventDate" name="fecha" value="$eventEventDate" min="2020-01-01" max="2020-12-31">
                <label>Número máximo de asistentes: </label><input type="number" name="maxAssistants" required value="$eventCapacity" min="1" max="100">
            </p>
            <label>Ubicación: </label><input type="text" name="eventLocation" value="$eventLocation" required >
            <label>Etiquetas (separar por comas): </label><input type="text" name="eventTags" value="$eventTags" required>
            <p> <label for="address">Descripción del evento:</label> </p>
            <p> <textarea rows="9" cols="70" name="description">$eventDescription</textarea> </p>
            <button type="submit"> Enviar </button>
            <button type="reset"> Borrar Campos </button>
            <button type="text" onClick="goBack()"> Cancelar </button>
	    </div>
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
        if(isset($data["eventTags"])){
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

			if ($data['imgChoice'] == "defaultImg"){
				$imgName = $defaultImgName;
			}
			else{
				// Si hay una foto subida por el usuario, cambiarlo
				if (isset($_FILES['img'])){
					$targetDir = "/Yovoy/Proyecto/includes/img/events/";
					$imgName = basename($_FILES['img']['name']);
					
					// Conseguir la dirección en que se guarda la foto subida
					$targetFilePath = $_SERVER['DOCUMENT_ROOT'] . $targetDir . $imgName;
					
					// Si la foto anterior no es default.jpg, borrarla
					$currImgName = $event->getImgName();
					if ($currImgName != $defaultImgName){
						unlink ($_SERVER['DOCUMENT_ROOT'] . $targetDir . $currImgName);
					}
					
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
                $result = "eventItem.php?event_id=".$eventId;
            }
            else {
                $result[] = "Error en crear evento! Consulta un administrador.";
			}
        }
        return $result;
    }
}