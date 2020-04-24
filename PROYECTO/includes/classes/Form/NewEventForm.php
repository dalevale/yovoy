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
        $email = '';
        if ($data) {
            $eventName = isset($data['eventName']) ? $data['eventName'] : $eventName;
            $eventLocation = isset($data['eventLocation']) ? $data['eventLocation'] : eventLocation;
            $description = isset($data['description']) ? $data['description'] : description;
            $eventTags = isset($data['eventTags']) ? $data['eventTags'] : eventTags;
        }
        $html = <<<EOF
        <fieldset>
				<legend>Detalles del evento</legend>
				<label>Título: </label><input type="text" name="eventName" required >
				<p>
					<label>Fecha: </label><input type="date" name="eventDate" name="fecha" value="2020-01-1" min="2020-01-01" max="2020-12-31">
					<label>Ubicación: </label><input type="text" name="eventLocation" required >
					<label>Número máximo de asistentes: </label><input type="number" name="maxAssistants" required value="1" min="1" max="100">
					<!--<p><label>Email del organizador: <input type="email" id="email" placeholder="Introduce una dirección válida"required></label></p>
				</p>-->
				<label>Etiquetas (separar por comas): </label><input type="text" name="eventTags" required>
				<p> <label for="address">Descripción del evento:</label> </p>
				<p> <textarea rows="9" cols="70" name="description"></textarea> </p>
				<button type="submit"> Enviar </button>
				<button type="reset"> Borrar Campos </button>
				<button type="text" onClick="goBack()"> Cancelar </button>
                
	    </fieldset>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        
        $result = array();
        //Valores introducidos por el creador del evento
        $eventTags = isset($data["eventTags"]) ? explode(",", $data["eventTags"]) : null;
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
            $userDAO = new UserDAO($conn);
            $eventDAO = new EventDAO($conn);
            $result = array();
            //Añadir el evento a la BBDD
	        if ($eventDAO->registerEvent($eventName, $creator, $creationDate, $eventDate, $maxAssistants, $eventLocation, $text, $eventTags) === true) {
		    $_SESSION["eventCreated"] = true;
            $result = "crearEvento.php";
            }
            else {
                $result[] = "Error en crear evento! Consulta un administrador.";
			}
        }
        return $result;
    }
}