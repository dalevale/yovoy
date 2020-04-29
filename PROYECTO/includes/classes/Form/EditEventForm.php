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
        $app = es\ucm\fdi\aw\Application::getSingleton();
        $conn = $app->bdConnection();
        $eventDAO = new EventDAO($conn);
        $event = $eventDAO->getEvent($eventId);
        $eventName = $event->getName();
        $eventLocation = $event->getLocation();
        $eventEventDate = $event->getEventDate();
        $eventCapacity = $event->getCapacity();
        $eventTags = $event->getTags();
        $eventDescription = $event->getDescription();
        $html = <<<EOF
        <div class='tarjeta_gris'>
                <input type="hidden" name="eventId" value="$eventId">
				<label>Título: </label><input type="text" name="eventName" value="$eventName"required >
                <p>
                    <label>Fecha: </label><input type="date" name="eventDate" name="fecha" value="$eventEventDate" min="2020-01-01" max="2020-12-31">
					<label>Ubicación: </label><input type="text" name="eventLocation" value="$eventLocation" required >
					<label>Número máximo de asistentes: </label><input type="number" name="maxAssistants" required value="$eventCapacity" min="1" max="100">
					<!--<p><label>Email del organizador: <input type="email" id="email" placeholder="Introduce una dirección válida"required></label></p>
				</p>-->
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

        if (count($result) === 0) {
            //Conectamos a BBDD
            
            $app = es\ucm\fdi\aw\Application::getSingleton();
            $conn = $app->bdConnection(); 
            $eventDAO = new EventDAO($conn);
            $result = array();
            //Actualizar el evento en la BBDD
	        //if ($eventDAO->updateEvent($this->eventId, $eventName, $creator, $creationDate, $eventDate, $maxAssistants, $eventLocation, $text, $eventTags) === true) {
		    $id = $data["eventId"];
            if($eventDAO->updateEvent($id, $eventName, $maxAssistants, $eventLocation, $text, $eventTagsStr, $eventTags)){
            $result = "eventos.php";
            }
            else {
                $result[] = "Error en crear evento! Consulta un administrador.";
			}
        }
        return $result;
    }
}