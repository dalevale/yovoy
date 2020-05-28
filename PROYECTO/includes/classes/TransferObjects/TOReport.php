<?php

class TOReport  {

    private $reportId;
    private $userId;
    private $objType;
    private $objUserId;
    private $objEventId;
    private $reportDate;
    private $resolved;
    private $reportText;

    public function __construct($reportId,$userId,$objType,$objUserId,$objEventId,$reportDate,$resolved,$reportText){
        $this->reportId = $reportId;
        $this->userId = $userId;
        $this->objType = $objType;
        $this->objUserId = $objUserId;
        $this->objEventId = $objEventId;
        $this->reportDate = $reportDate;
        $this->resolved = $resolved;
        $this->reportText = $reportText;
    }

    public function getId(){
        return $this->reportId;
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

    public function getReportDate(){
        return $this->reportDate;
    }

    public function isResolved(){
        return $this->resolved;
	}

    public function getReportText(){
        return $this->reportText;
    }

}
?>