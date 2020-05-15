<?php

class TONotifications{
    
    private $id;
    private $thisUser;
    private $thatUser;
    private $eventId;
    private $type;
    private $date;
    private $isRead;

    public function __construct($id,$thisUser,$thatUser,$eventId,$type,$date,$isRead){
        $this->id = $id;
        $this->$thisUser = $thisUser;
        $this->thatUser = $thatUser;
        $this->eventId = $eventId;
        $this->type = $type;
        $this->date = $date;
        $this->isRead = $isRead;
    }

    public function getId(){
        return $this->id;
    }

    public function getThisUser(){
        return $this->thisUser;
    }

    public function getThatUser(){
        return $this->thatUser;
    }

    public function getEventId(){
        return $this->eventId;
    }

    public function getType(){
        /*switch($this->type){
            case 0: return "NEW_FRIEND_REQUEST"; break;
            case 1: return "FRIEND_REQUEST_ACCEPTED"; break;
            case 2: return "NEW_EVENT_REQUEST"; break;
            case 3: return "EVENT_REQUEST_ACCEPTED"; break;
            case 4: return "EVENT_EDITED"; break;
            case 5: return "NEW_COMMENT"; break;
            case 6: return "EVENT_IS_NEAR"; break;
            case 7: return "HAS_NEW_EVENT"; break;
            default: return 0; break;
        }
        */
        return $this->type;
    }

    public function getDate(){
        return $this->date;
    }

    public function isRead(){
        return $this->isRead;
    }

}
?>