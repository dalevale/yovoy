<?php

class TOEvent{
    private $eventId = "";
    private $name = "";
    private $creator = "";
    private $creationDate = "";
    private $eventDate = "";
    private $capacity = "";
    private $location = "";
    private $description = "";

    public function __construct($eventId, $name, $creator, $creationDate, $eventDate, $capacity, $location, $description){
        $this->eventId = $eventId;
        $this->name = $name;
        $this->creator = $creator;
        $this->creationDate = $creationDate;
        $this->eventDate = $eventDate;
		$this->capacity = $capacity;
        $this->location = $location;
        $this->description = $description;
    }

    public function getEventId(){
        return $this->eventId;
	}
    
    public function getName(){
        return $this->name;
    }

    public function getCreator(){
        return $this->creator;
    }

    public function getCreationDate(){
        return $this->creationDate;
    }

    public function getEventDate(){
        return $this->eventDate;
	}
    	
    public function getCapacity(){
        return $this->capacity;
    }

    public function getLocation(){
        return $this->location;
    }

    public function getDescription(){
        return $this->description;
    }
}   
?>
