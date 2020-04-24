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

    public function registerEvent($name, $creator, $creationDate, $eventDate, $capacity, $location, $description, $eventTags){        
      //VALORES A INSERTAR EN LA BBDD
      $eventInserted = false;
      $tagInserted = false;

      $queryValues =  
           "'".$name."'". "," 
          ."'".$creator."'". "," 
          ."'".$creationDate."'". ","
          ."'".$eventDate."'". ","
          ."'".$capacity."'". "," 
          ."'".$location."'". ","
          ."'".$description."'";

      $registerEvent = "INSERT INTO event (`name`, `creator`, `creation_date`, `event_date`, `capacity`, `location`, `description`) 
                  VALUES(".$queryValues.");";

      if($this->dbConn->query($registerEvent)) $eventInserted = true;

      $eventQuery = "SELECT event_id FROM event WHERE name =" ."'".$name."'"." AND creator=" ."'".$creator."'". " AND creation_date="."'".$creationDate."'". " AND event_date="."'". $eventDate."'".";";
      $result = $this->dbConn->query($eventQuery);
      
      $eventId ="";
      while($row = $result->fetch_assoc()) {
          $eventId= $row["event_id"];
      } 
      
      for($i = 0; $i < count($eventTags); $i++){
          $queryValues =  
               "'".$eventId."'". "," 
              ."'".$eventTags[$i]."'";

          $insertTags = "INSERT INTO event_tags (`event_id`, `tag`) VALUES(".$queryValues.");";

          if($this->dbConn->query($insertTags)) $tagInserted = true;
          else $tagInserted = false;
      }

      return $eventInserted && $tagInserted;
    }

    public function getEvent($eventId){
        $eventQuery = "SELECT * FROM event WHERE event_id = ".$eventId."";
        $result = $this->dbConn->query($eventQuery);

        while($row = $result->fetch_assoc()) {
            $eventId= $row["event_id"];
            $name = $row["name"];
            $creator = $row["creator"];
            $creationDate = $row["creation_date"];
            $eventDate = $row["event_date"];
            $capacity = $row["capacity"];
            $location = $row["location"];
            $description = $row["description"];
        }

        return new TOEvent($eventId, $name, $creator, $creationDate, $eventDate, $capacity, $location, $description);
    }

    public function getAllEvents(){
        $eventQuery = "SELECT * FROM event";
        $result = $this->dbConn->query($eventQuery);
        return $result;
	}
	
    /**
     * @param $filter buscar por filtro
     * @param $value valor a buscar
     */
    public function searchEventBy($filter, $value){

        switch($filter){
            case "EVENT_TAGS": 
                $eventQuery = "SELECT * FROM event JOIN event_tags WHERE event_tags.tag='".$value."' AND event.event_id=event_tags.event_id;"; 
                break;
            case "EVENT_NAME":
                $eventQuery = "SELECT * FROM event WHERE name='".$value."';"; 
                break;
            case "EVENT_CREATOR":
                $eventQuery = "SELECT * FROM event WHERE creator='".$value."';"; 
                break;
            case "EVENT_CAPACITY":
                $eventQuery = "SELECT * FROM event WHERE capacity='".$value."';"; 
                break;
            case "EVENT_LOCATION":
                $eventQuery = "SELECT * FROM event WHERE location='".$value."';"; 
                break;
            case "EVENT_DATE":
                $eventQuery = "SELECT * FROM event WHERE event_date='".$value."';"; 
                break;
            default:
                $eventQuery = "SELECT * FROM event WHERE name='".$value."';"; 
                break;
        }

        $result = $this->dbConn->query($eventQuery);

        $eventsArray = array();

        while($row = $result->fetch_assoc()) {
            $eventId= $row["event_id"];
            $name = $row["name"];
            $creator = $row["creator"];
            $creationDate = $row["creation_date"];
            $eventDate = $row["event_date"];
            $capacity = $row["capacity"];
            $location = $row["location"];
            $description = $row["description"];

            array_push($eventsArray, new TOEvent($eventId, $name, $creator, $creationDate, $eventDate, $capacity, $location, $description));
        }

        return $eventsArray;
    }
}
?>
