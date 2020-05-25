<?php
require_once __DIR__.'/../TransferObjects/TOEvent.php';
require_once __DIR__.'/UserDAO.php';
require_once __DIR__.'/DAO.php';

class EventDAO extends DAO{
    //Constantes a usar en searchEventBy()
    /*public const EVENT_TAGS = "EVENT_TAGS";
    public const EVENT_NAME = "EVENT_NAME";
    public const EVENT_CREATOR = "EVENT_CREATOR";
    public const EVENT_CAPACITY = "EVENT_CAPACITY";
    public const EVENT_LOCATION = "EVENT_LOCATION";
    public const EVENT_DATE = "EVENT_DATE";
    public const DEFAULT = "EVENT_NAME";*/
	
    public function __construct(){
        parent::__construct();
	}

    /**
    * Meter una fila de evento a la Base de Datos
    *
    * @param string $name               Nombre del evento
    * @param int $creator               Id del usuario TOUser
    * @param string $imgName            Nombre de la imagen en /includes/img/eventos
    * @param Date $creationDate         Fecha de creaci�n
    * @param Date $eventDate            Fecha del evento
    * @param int $capacity              Aforo del evento
    * @param string $location           Ubicaci�n del evento
    * @param string $description        Descripci�n del evento
    * @param string $eventTagsString    Cadena de string entera de los tags separado por ',' , se usa para la edici�n del evento
    * @param array $eventTagsArray      Array de string de los tags sin el caracter ','
    * @return bool $tagsInserted        Devuelve true si se ha insertado el evento con exito a la BBDD.
    */
    public function registerEvent($name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $description, $eventTagsString,$eventTagsArray){        
          //VALORES A INSERTAR EN LA BBDD
        $eventInserted = false;
        $tagInserted = false;

          //currentAttendees es un valor provisional
        $current_attendees = 0;
        $aux_autoinc = 1;
        $queryValues =  
               "'".$name."'". "," 
              ."'".$creator."'". "," 
              ."'".$imgName."'". "," 
              ."'".$aux_autoinc."'". "," 
              ."'".$creationDate."'". ","
              ."'".$eventDate."'". ","
              ."'".$capacity."'". ","
              ."'".$current_attendees."'". ","  
              ."'".$location."'". ","
              ."'".$eventTagsString."'". ","
              ."'".$description."'";

        $registerEvent = "INSERT INTO event (name, creator, img_name, aux_autoinc, creation_date, event_date, capacity, current_attendees,location, tags, description) 
                          VALUES(".$queryValues.");";

        if(parent::executeInsert($registerEvent)) {
            $eventInserted = true;          
            if (is_null($eventTagsArray)){
                $tagInserted = true;
            }
            else{  
                $eventId= $this->getLastEvent();
                $tagInserted = $this->addTag($eventId, $eventTagsArray);
            }
        }
        
            return $eventInserted && $tagInserted;
    }


    /**
    * Meter en la tabla de una fila del id del evento con cada tags en el array.
    *
    * @param int $eventId           Id del evento
    * @param array $eventTags       Array de string de tags
    * @return bool $tagsInserted    Devuelve true si se ha insertado los tags con exito. 
    */
    private function addTag($eventId, $eventTags){
        $tagsInserted = true;
        for($i = 0; $i < count($eventTags); $i++){
                $queryValues =  
                     "'".$eventId."'". "," 
                    ."'".$eventTags[$i]."'";

                $insertTags = "INSERT INTO event_tags (event_id, tag) VALUES(".$queryValues.");";
                $ret = parent::executeInsert($insertTags);
                if($ret != 0)
                    $tagsInserted = false;
        }
        return $tagsInserted;   
	}

    /**
    * Eliminar todos los tags de un evento en la tabla tags
    * Se usa para la edici�n de un evento. Primero se usa esta funci�n para
    * eliminar todos los tags y a�adirlos de nuevo.
    * 
    * @param int $eventId    Id del evento
    * @return bool $result   Devuelve true si se ha eliminado con exito los tags del evento con id $eventId
    */
    private function removeTag($eventId){
  
        $insertTags = "DELETE FROM event_tags WHERE event_id = '$eventId'";
        return parent::executeModification($insertTags);
	}

    private function createEvent($data){
        $eventId= $data["event_id"];
        $name = $data["name"];
        $creator = $data["creator"];
        $imgName = $data["img_name"];
        $creationDate = $data["creation_date"];
        $eventDate = $data["event_date"];
        $capacity = $data["capacity"];
        $location = $data["location"];
        $tags = $data["tags"];
        $description = $data["description"];

        return new TOEvent($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description);
	}

    /**
    * Devolver un objeto TOEvent tras un query a la BBDD.
    *
    * @param int $eventId       Id del evento
    * @return TOEvent $event     Objeto TOEvent creado con los datos desde la BBDD
    */
    public function getEvent($eventId){
        $eventQuery = "SELECT * FROM event WHERE event_id = ".$eventId."";
        $dataArray= parent::executeQuery($eventQuery);
        $data= array_pop($dataArray);
        
        return $this->createEvent($data);
    }

    /**
    * Devolver todos los eventos de la tabla events en la BBDD
    * Hay que cambiar la estructura para no romper memoria a la hora de
    * sacar mucha fila de la BBDD.
    *
    * @return array $eventsArray    Array de objetos TOEvent creados con los datos de la BBDD.
    */
    public function getAllEvents(){
        $eventQuery = "SELECT * FROM event";
        $eventsArray = array();

        $dataArray = parent::executeQuery($eventQuery);
        $data = array_shift($dataArray);

        while(!empty($data)) {
            array_push($eventsArray, $this->createEvent($data));
            
            $data = array_shift($dataArray);
        }
        return $eventsArray;
	}
	
    /**
    * Funcion para buscar eventos por filtros.
    *
    * @param enum $filter           Buscar por filtro de valores enum que se usa para distinguir los distintos
    *                               queries a ejecutar.
    * @param string $value          Valor a buscar
    * @return array $eventsArray    Array de objetos TOEvent creados con los datos de la BBDD.
    */
    public function searchEventBy($filter, $value){

        switch($filter){
            case "tags": 
                $eventQuery = "SELECT DISTINCT * FROM event JOIN event_tags WHERE event_tags.tag LIKE '%".$value."%' AND event.event_id=event_tags.event_id;"; 
                break;
            case "name":
                $eventQuery = "SELECT DISTINCT * FROM event WHERE name LIKE '%".$value."%'"; 
                break;
            case "creator":
                $eventQuery = "SELECT DISTINCT event_id, event.name, creator, event.img_name, event.creation_date, event_date, capacity, current_attendees, location, tags, description FROM event JOIN user WHERE username LIKE '%".$value."%' AND creator=user_id;"; 
                break;
            case "capacity":
                $eventQuery = "SELECT DISTINCT * FROM event WHERE capacity='".$value."';"; 
                break;
            case "location":
                $eventQuery = "SELECT DISTINCT * FROM event WHERE location LIKE '%".$value."%';"; 
                break;
            //case "date":
               // $eventQuery = "SELECT DISTINCT * FROM event WHERE event_date='".$value."';"; 
               // break;
            case "latest":
                $eventQuery = "SELECT DISTINCT * FROM event ORDER BY creation_date DESC;";
                break;
            default:
                $eventQuery = "SELECT DISTINCT * FROM event WHERE name LIKE '%".$value."%';"; 
                break;

        }

        $eventsArray = array();

        $dataArray = parent::executeQuery($eventQuery);
        $data = array_shift($dataArray);

        while(!empty($data)) {
            array_push($eventsArray, $this->createEvent($data));
            $data = array_shift($dataArray);
        }
        return $eventsArray;
    }

    /**
    * Funci�n para sacar los assistentes de un evento desde la tabla join_event.
    * @param bool $accepted     Muestran los usuarios aceptados en evento si TRUE y los pendientes si FALSE
    * @param int $eventId       Id del evento
    * @return array $attendees  Array de int de los id�s de los usuarios apuntados en dicho evento
    */
    public function getAttendees($eventId,$accepted){

        $accepted = $accepted? 1:0;
        $attendees = array();
        $eventQuery = "SELECT * FROM join_event WHERE event_id='".$eventId."' AND accepted=$accepted ORDER by join_date" ;

        $dataArray = parent::executeQuery($eventQuery);
        $data = array_shift($dataArray);

        $userDAO = new UserDAO;

        while(!empty($data)) {
            $dataArrayToReturn = array("userId"=>$data["user_id"], "joinDate"=>$data["join_date"]);
            $user = $userDAO->getUser($data["user_id"]);
            $type = $user->getUserType();
            
            if($type == 1)
                array_push($attendees, $dataArrayToReturn);
            else if($type == 2)
                array_unshift($attendees, $dataArrayToReturn);

            $data = array_shift($dataArray);
		}
        return $attendees;
    }

    /**
    * Funci�n para actualizar una fila de evento cuando se edita.
    * Diferencia con self::registerEvent: Esta tiene menos argumentos. (Argumentos que no se tiene que modificar)
    *
    * @param int $id                Id del evento 
    * @param string $name           Nombre del evento
    * @param int $capacity          Capacidad del evento
    * @param string $location       Ubicaci�n del evento
    * @param string $description    Descripci�n del evento
    * @param string $tagsStr        Cadena de string con los tags separado por ','.   
    * @param array $tags            Array de string con los tags.
    * @return bool $success         Devuelve true si se ha modificado bien la fila del evento en la BBDD.
    */
    public function updateEvent($id, $name, $capacity, $location, $description, $tagsStr, $tags, $imgName){        
        //VALORES A INSERTAR EN LA BBDD
        $eventInserted = false;
        $updateStr = 
                 "name ='".$name."'". "," 
                ."capacity ='".$capacity."'". "," 
                ."location ='".$location."'". "," 
                ."description ='".$description."'". ","
                ."tags ='".$tagsStr."'". ","
                ."img_name ='".$imgName."'";
        $updateQuery = "UPDATE event SET ".$updateStr." WHERE event_id = '".$id."';";

        $eventInserted = parent::executeModification($updateQuery);
        $this->removeTag($id);
        if (is_null($tags))
            $tagsInserted = true;
        else{
            $tagsInserted = $this->addTag($id, $tags);
            // $this->removeTag($id) && No valido, puede intentar borrar una fila que no existe y asi devuelve 0;
        }
        return $eventInserted && $tagsInserted;
    }

    public function userInEventRequest($userId,$eventId,$accepted,$currDate){
        $accepted = $accepted == "1"? true:false;
        if($accepted)
            $query = "UPDATE join_event SET accepted='1', join_date='$currDate' WHERE event_id='$eventId' AND user_id='$userId'";
        else
            $query = "DELETE FROM join_event WHERE event_id='$eventId' AND user_id='$userId'";
        
        return parent::executeModification($query);
    }

    public function isUserInEvent($userId,$eventId){
        $query = "SELECT accepted FROM join_event WHERE event_id='$eventId' AND user_id='$userId'";

        $dataArray = parent::executeQuery($query);
        $data = array_pop($dataArray);
        $confirmed = false;

        if(!empty($data))
            $confirmed = $data["accepted"] == 1 ? true : false;
        
        return $confirmed;
    }

    public function isEventFull($eventId,$capacity){
        $total = "";

        $query = "SELECT count(event_id) AS total FROM join_event WHERE event_id='$eventId' AND accepted='1'";
        
        $dataArray = parent::executeQuery($query);
        $data = array_pop($dataArray);

        $total = $data["total"];
        
        return $total >= $capacity;
    }

    public function getLastEvent(){
        $query = "SELECT event_id FROM event ORDER BY event_id DESC LIMIT 1";
        $dataArray = parent::executeQuery($query);

        $data = array_pop($dataArray);

        return $data["event_id"];
    }

    /*public function getLastNoPremiumUserInEvent($eventId){
        $query = "SELECT join_event.user_id FROM join_event JOIN user WHERE event_id = '$eventId' AND user.type != 2 AND accepted = 1 ORDER BY join_date DESC LIMIT 1";
        $dataArray = parent::executeQuery($query);

        $data = array_pop($dataArray);

        return $data["user_id"];
    }*/

    public function getPremiumEvents(){
        $query = "SELECT *,event.img_name,event.name FROM event JOIN user WHERE creator = user_id AND type = '2'";
        
        $eventArray = array();

        $dataArray = parent::executeQuery($query);
        $data = array_pop($dataArray);
        while(!empty($data)) {
            array_push($eventArray, $this->createEvent($data));
            $data = array_pop($dataArray);
        }
        return $eventArray;
    }

    public function getPromotedEvents(){
        $query = "SELECT event_id, COUNT(*) as total FROM `promote_event` GROUP BY event_id ORDER BY COUNT(*) DESC;";

        $eventArray = array();
        $dataArray = parent::executeQuery($query);
        $data = array_pop($dataArray);
        while(!empty($data)) {
            $eventId = $data["event_id"];
            $total = $data["total"];
            
            $evtWtTotalArray = [
                "event" => $this->getEvent($eventId),
                "total" => $total,
            ];
            array_unshift($eventArray, $evtWtTotalArray);
            $data = array_pop($dataArray);
        }
        return $eventArray;
	}
}
?>
