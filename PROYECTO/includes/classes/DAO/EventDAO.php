<?php
require_once __DIR__.'/../TransferObjects/TOEvent.php';
require_once __DIR__.'/DAO.php';

class EventDAO extends DAO{
    //Constantes a usar en searchEventBy()
    public const EVENT_TAGS = "EVENT_TAGS";
    public const EVENT_NAME = "EVENT_NAME";
    public const EVENT_CREATOR = "EVENT_CREATOR";
    public const EVENT_CAPACITY = "EVENT_CAPACITY";
    public const EVENT_LOCATION = "EVENT_LOCATION";
    public const EVENT_DATE = "EVENT_DATE";
    public const DEFAULT = "EVENT_NAME";
	
    public function __construct($conn){
        parent::__construct($conn);
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
          $queryValues =  
               "'".$name."'". "," 
              ."'".$creator."'". "," 
              ."'".$imgName."'". "," 
              ."'".$creationDate."'". ","
              ."'".$eventDate."'". ","
              ."'".$capacity."'". ","
              ."'".$current_attendees."'". ","  
              ."'".$location."'". ","
              ."'".$eventTagsString."'". ","
              ."'".$description."'";

          $registerEvent = "INSERT INTO event (name, creator, img_name, creation_date, event_date, capacity, current_attendees,location, tags, description) 
                      VALUES(".$queryValues.");";

          if($this->dbConn->query($registerEvent)) $eventInserted = true;

          //Adding to tags table
          //Cambair la manera de coger el ultimo ID insertado, esto puede tener conflictos con nombres de eventos iguales etc.
          $eventQuery = "SELECT event_id FROM event WHERE name =" ."'".$name."'"." AND creator=" ."'".$creator."'". " AND creation_date="."'".$creationDate."'". " AND event_date="."'". $eventDate."'".";";
          $result = $this->dbConn->query($eventQuery);
      
          $eventId ="";
          while($row = $result->fetch_assoc()) {
              $eventId= $row["event_id"];
              $tagInserted = $this->addTag($eventId, $eventTagsArray);
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
        $tagsInserted = false;
        for($i = 0; $i < count($eventTags); $i++){
                $queryValues =  
                     "'".$eventId."'". "," 
                    ."'".$eventTags[$i]."'";

                $insertTags = "INSERT INTO event_tags (event_id, tag) VALUES(".$queryValues.");";

                if($this->dbConn->query($insertTags)) $tagsInserted = true;
                else $tagsInserted = false;
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
        $tagsInserted = false;
        $insertTags = "DELETE FROM event_tags WHERE event_id = '".$eventId."';";
        $result = $this->dbConn->query($insertTags);

        return $result;
	}


    /**
    * Devolver un objeto TOEvent tras un query a la BBDD.
    *
    * @param int $eventId       Id del evento
    * @return TOEvent $event     Objeto TOEvent creado con los datos desde la BBDD
    */
    public function getEvent($eventId){
        $eventQuery = "SELECT * FROM event WHERE event_id = ".$eventId."";
        $result = $this->dbConn->query($eventQuery);

        while($row = $result->fetch_assoc()) {
            $eventId= $row["event_id"];
            $name = $row["name"];
            $creator = $row["creator"];
            $imgName = $row["img_name"];
            $creationDate = $row["creation_date"];
            $eventDate = $row["event_date"];
            $capacity = $row["capacity"];
            $location = $row["location"];
            $tags = $row["tags"];
            $description = $row["description"];
        }
        return new TOEvent($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description);
    }

    /**
    * Devolver todos los eventos de la tabla events en la BBDD
    * Hay que cambiar la estructura para no romper memoria a la hora de
    * sacar mucha fila de la BBDD.
    *
    * @return array $eventsArray    Array de objetos TOEvent creados con los datos de la BBDD.
    */
    public function getAllEvents(){
        $query = "SELECT * FROM event";
        $result = $this->dbConn->query($query);
        $eventsArray = array();

        while($row = $result->fetch_assoc()) {
            $eventId= $row["event_id"];
            $name = $row["name"];
            $creator = $row["creator"];
            $imgName = $row["img_name"];
            $creationDate = $row["creation_date"];
            $eventDate = $row["event_date"];
            $capacity = $row["capacity"];
            $location = $row["location"];
            $tags = $row["tags"];
            $description = $row["description"];

            array_push($eventsArray, new TOEvent($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description));
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
            case "EVENT_TAGS": 
                $eventQuery = "SELECT DISTINCT * FROM event JOIN event_tags WHERE event_tags.tag='".$value."' AND event.event_id=event_tags.event_id;"; 
                break;
            case "EVENT_NAME":
                $eventQuery = "SELECT DISTINCT * FROM event WHERE name='".$value."';"; 
                break;
            case "EVENT_CREATOR":
                $eventQuery = "SELECT DISTINCT event_id, event.name, creator, event.img_name, event.creation_date, event_date, capacity, current_attendees, location, tags, description FROM event JOIN user WHERE username = '$value' AND creator=user_id;"; 
                break;
            case "EVENT_CAPACITY":
                $eventQuery = "SELECT DISTINCT * FROM event WHERE capacity='".$value."';"; 
                break;
            case "EVENT_LOCATION":
                $eventQuery = "SELECT DISTINCT * FROM event WHERE location='".$value."';"; 
                break;
            case "EVENT_DATE":
                $eventQuery = "SELECT DISTINCT * FROM event WHERE event_date='".$value."';"; 
                break;
            default:
                $eventQuery = "SELECT DISTINCT * FROM event WHERE name='".$value."';"; 
                break;
        }

        $result = $this->dbConn->query($eventQuery);
        $eventsArray = array();

        while($row = $result->fetch_assoc()) {
            $eventId= $row["event_id"];
            $name = $row["name"];
            $creator = $row["creator"];
			$imgName = $row["img_name"];
            $creationDate = $row["creation_date"];
            $eventDate = $row["event_date"];
            $capacity = $row["capacity"];
            $location = $row["location"];
            $tags = $row["tags"];
            $description = $row["description"];

            array_push($eventsArray, new TOEvent($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description));
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
        if($accepted)
            $eventQuery = "SELECT * FROM join_event WHERE event_id='".$eventId."' AND accepted=1;";
        else
            $eventQuery = "SELECT * FROM join_event WHERE event_id='".$eventId."' AND accepted=0;";
        $result = $this->dbConn->query($eventQuery);
        $attendees = array();
        while($row = $result->fetch_assoc()) {
            array_push($attendees, $row["user_id"]);
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
    public function updateEvent($id, $name, $capacity, $location, $description, $tagsStr, $tags){        
        //VALORES A INSERTAR EN LA BBDD
        $eventInserted = false;
        $tagInserted = false;
        $updateStr = 
            "name ='".$name."'". "," 
                ."capacity ='".$capacity."'". "," 
                ."location ='".$location."'". "," 
                ."description ='".$description."'". ","
                ."tags ='".$tagsStr."'";
        $updateQuery = "UPDATE event SET ".$updateStr." WHERE event_id = '".$id."';";

        $eventInserted = $this->dbConn->query($updateQuery);
        $tagsInserted = $this->removeTag($id) && $this->addTag($id, $tags);
          

        return $eventInserted && $tagsInserted;
    }

    public function userInEvent($userId,$eventId,$accepted){
        if($accepted)
            $query = "UPDATE join_event SET accepted='1' WHERE event_id='$eventId' AND user_id='$userId'";
        else
            $query = "DELETE FROM join_event WHERE event_id='$eventId' AND user_id='$userId'";
        
        return $this->dbConn->query($query);
    }
}
?>
