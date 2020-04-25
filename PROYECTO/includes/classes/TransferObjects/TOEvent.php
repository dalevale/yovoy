<?php

class TOEvent{
    private $eventId = "";
    private $name = "";
    private $creator = "";
    private $imgName = "";
    private $creationDate = "";
    private $eventDate = "";
    private $capacity = "";
    private $location = "";
    private $tags = "";
    private $description = "";

    public function __construct($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description){
        $this->eventId = $eventId;
        $this->name = $name;
        $this->creator = $creator;
        $this->imgName = $imgName;
        $this->creationDate = $creationDate;
        $this->eventDate = $eventDate;
		$this->capacity = $capacity;
        $this->location = $location;
        $this->tags = $tags;
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

    public function getImgName(){
        return $this->imgName;
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

    public function getTags(){
        return $this->tags;
    }
}   
?>
