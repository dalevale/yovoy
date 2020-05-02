<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class SearchForm extends Form
{
    public function __construct() {
        parent::__construct('searchForm');
    }
    
    protected function generateFormFields($data)
    {	
		$search="";
        if ($data) {
            $search = isset($data['search']) ? $data['search'] : $search;
        }
        $html = <<<EOF
		<div class="tarjeta_gris">
        <p><input type="text" name="search" required placeholder="Busca por nombre, etiqueta o usuario">
			<p><input type="radio" name="option" value="Nombre de Evento"> Nombre de Evento
			<input type="radio" name="option" value="Creador"> Creador
			<input type="radio" name="option" value="Etiqueta"> Etiqueta
			<input type="radio" name="option" value="Capacidad"> Capacidad
			<input type="radio" name="option" value="Ubicacion"> Ubicacion
			</p>
            <input type='image' title="Buscar" alt="submit" src='includes/img/boton_BUSCAR.png'>
            <input type="image" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
			</p>
		</div>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        $app = es\ucm\fdi\aw\Application::getSingleton();
        $result = array();
        $search = isset($data['search']) ? $data['search'] : null;
		$option = isset($data['option']) ? $data['option'] : null;
        $conn = $app->bdConnection(); 
		$evento = new EventDAO($conn);
		
		if ( empty($search) ) {
			 $result[] = "El campo de busqueda ha de tener algo escrito";
		}
		
		if ( empty($option) ) {
			 $result[] = "Elige un campo de opcion";
		}
		
		else{
			$eventName="";
			if ($option=="Nombre de Evento"){
				$eventName="EVENT_NAME";
			}
			else if ($option=="Creador"){
				$eventName="EVENT_CREATOR";
			}
			else if ($option=="Etiqueta"){
				$eventName="EVENT_TAGS";
			}
			else if ($option=="Capacidad"){
				$eventName="EVENT_CAPACITY";
			}
			else if ($option=="Ubicacion"){
				$eventName="EVENT_LOCATION";
			}
			else{
				$eventName="EVENT_NAME";
			}
			
			$result = $evento->searchEventBy($eventName , $search);
			while(sizeof($result) > 0){
				echo "<ul class = 'evento'>";
				$event = array_pop($result);
				$eventId = $event->getEventId();

				echo "<li><a href= '/eventItem.php?event_id=".$eventId."'>";
				echo "Evento: ".$event->getName()."</a></li>";
				//echo "<p> ID: ".$event->getEventId()."</p>";
				echo "</ul>";
			}

		}
		
	
		
        return $result;
    }
}