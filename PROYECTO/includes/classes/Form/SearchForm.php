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
		<div id="searchbar" class="tarjeta_gris">
        <p><input type="text" name="search" required placeholder="Busca por nombre, etiqueta o usuario"></p>
		<p>
			<input type="radio" name="option" value="username"> Usuario
			<input type="radio" name="option" value="eventName"> Nombre de Evento
			<input type="radio" name="option" value="creator"> Creador
			<input type="radio" name="option" value="tag"> Etiqueta
			<input type="radio" name="option" value="capacity"> Capacidad
			<input type="radio" name="option" value="location"> Ubicacion
		</p>
		<p class="searchBtns">
            <input type='image' title="Buscar" alt="submit" src='includes/img/boton_BUSCAR.png'>
            <input type="image" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
		</p>
		</div>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        $result = array();
        $search = isset($data['search']) ? $data['search'] : null;
		$option = isset($data['option']) ? $data['option'] : null;
		$event = new EventDAO();
		$user = new UserDAO();
		
		if ( empty($search) ) {
			 $result[] = "El campo de busqueda ha de tener algo escrito";
		}
		
		if ( empty($option) ) {
			 $result[] = "Elige un campo de opcion";
		}
		
		else{
			$eventName="";
			if ($option=="username"){
				$result = $user->searchUser($search);
			}
			else if ($option=="eventName"){
				$eventName="EVENT_NAME";
				$result = $event->searchEventBy($eventName , $search);
			}
			else if ($option=="creator"){
				$eventName="EVENT_CREATOR";
				$result = $event->searchEventBy($eventName , $search);
			}
			else if ($option=="tag"){
				$eventName="EVENT_TAGS";
				$result = $event->searchEventBy($eventName , $search);
			}
			else if ($option=="capacity"){
				$eventName="EVENT_CAPACITY";
				$result = $event->searchEventBy($eventName , $search);
			}
			else if ($option=="location"){
				$eventName="EVENT_LOCATION";
				$result = $event->searchEventBy($eventName , $search);
			}
			else{
				$eventName="eventName";
				$result = $event->searchEventBy($eventName , $search);
			}
			
			if($option == "eventName" ||$option == "creator" || 
				$option == "tag" || $option == "capacity" ||$option == "location"){

				while(sizeof($result) > 0){
					echo "<ul class = 'evento'>";
					$event = array_pop($result);
					$eventId = $event->getEventId();

					echo "<li><a href= 'eventItem.php?eventId=".$eventId."'>";
					echo "Evento: ".$event->getName()."</a></li>";
					echo "</ul>";
				}
			}

			else if ($option == "username"){
				while(sizeof($result) > 0){
					echo "<ul class = 'evento'>";
					$user = array_pop($result);
					$userId = $user->getUserId();

					echo "<li><a href= 'profileView.php?profileId=".$userId."'>";
					echo "Usuario: ".$user->getUsername()."</a></li>";
					echo "</ul>";
				}
			}

		}
	
        return $result;
    }
}