<?php

class TOActivity{

    private $activityId;
    private $userId;
    private $objType;
    private $objUserId;
    private $objEventId;
    private $activityDate;
    private $activityType;

    public function __construct($activityId,$userId,$objType,$objUserId,$objEventId,$activityDate,$activityType){
        $this->activityId = $activityId;
        $this->userId = $userId;
        $this->objType = $objType;
        $this->objUserId = $objUserId;
        $this->objEventId = $objEventId;
        $this->activityDate = $activityDate;
        $this->activityType = $activityType;
    }

    public function getId(){
        return $this->activityId;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function getObjType(){
        return $this->objType;
    }

    public function getObjUserId(){
        return $this->objUserId;
    }

    public function getObjEventId(){
        return $this->objEventId;
    }

    public function getActivityDate(){
        return $this->activityDate;
    }

    public function getActivityType(){
        return $this->activityType;
    }

}
?>