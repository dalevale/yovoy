<?php

class TOComments{
    private $id;
    private $event_id;
    private $user_id;
    private $date;
    private $comment;

    public function __construct($id, $event_id, $user_id, $date, $comment){
        $this->id = $id;
        $this->event_id = $event_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->comment = $comment;
    }

    public function getID(){
        return $this->id;
    }

    public function getEventID(){
        return $this->event_id;
    }

    public function getUserID(){
        return $this->user_id;
    }

    public function getDate(){
        return $this->date;
    }

    public function getComment(){
        return $this->comment;
    }
}
?>