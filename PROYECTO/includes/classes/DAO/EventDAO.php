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
          $eventQuery = "SELECT event_id FROM event WHERE name =" ."'".$name."'"." AND creator=" ."'".$creator."'". " AND creation_date="."'".$creationDate."'". " AND event_date="."'". $eventDate."'".";";
          $result = $this->dbConn->query($eventQuery);
      
          $eventId ="";
          while($row = $result->fetch_assoc()) {
              $eventId= $row["event_id"];
              $tagInserted = $this::addTag($eventId, $eventTagsArray);
          } 

          return $eventInserted && $tagInserted;
    }

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

    private function removeTag($eventId){
        $tagsInserted = false;
        $insertTags = "DELETE FROM event_tags WHERE event_id = '".$eventId."';";
        return $this->dbConn->query($insertTags);
	}

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

    public function getAttendees($eventId){
        $eventQuery = "SELECT * FROM join_event WHERE event_id='".$eventId."' AND accepted=1;";
        $result = $this->dbConn->query($eventQuery);
        $attendees = array();
        while($row = $result->fetch_assoc()) {
            array_push($attendees, $row["user_id"]);
		}
        return $attendees;
	}
    public function updateEvent($id, $name, $capacity, $location, $description, $tagsStr, $tags){        
        //VALORES A INSERTAR EN LA BBDD , $creator, $capacity, $location, $description, $eventTags
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
        $tagsInserted = self::removeTag($id) && self::addTag($id, $tags);
          

        return $eventInserted && $tagsInserted;
    }
}
?>
