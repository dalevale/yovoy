<?php

require_once __DIR__.'/../TransferObjects/TOReport.php';
require_once __DIR__.'/DAO.php';



class ReportDAO extends DAO{
    const USER = 0;
    const EVENT = 1;

    const UNRESOLVED = 0;
    const RESOLVED = 1;

    public function __construct(){
        parent::__construct();
    }

    public function addReport($userId, $objType, $objUserId, $objEventId, $resolved, $reportText){
        $query = "INSERT INTO report (user_id, object_type, obj_user_id, obj_event_id, report_date, resolved, report_text) 
                 VALUES ($userId, $objType, $objUserId, $objEventId, now(), $resolved, '$reportText');";
        parent::executeInsert($query);
    }

    public function removeReport($reportId){
        $query = "DELETE FROM report WHERE report_id = '$reportId'";
        parent::executeModification($query);
    }

    public function removeReportByObject($userId, $objType, $objId){
        $query = "DELETE FROM report WHERE 
        user_id = '$userId' AND
        ((obj_user_id = '$objId') OR
        (obj_event_id = '$objId')) AND
        object_type = '$objType';";
        
        parent::executeModification($query);
    }

    public function getReports(){
        $query = "SELECT * FROM report WHERE 1;";
        $dataArray = parent::executeQuery($query);
       
        $reportArray = array();

        $data = array_pop($dataArray);
        while(!empty($data)){
            $reportId = $data["report_id"];
            $userId = $data["user_id"];
            $objType = $data["object_type"];
            $objUserId = $data["obj_user_id"];
            $objEventId = $data["obj_event_id"];
            $reportDate = $data["report_date"];
            $resolved = $data["resolved"];
            $reportText = $data["report_text"];

            array_push($reportArray, new TOReport($reportId,$userId,$objType,$objUserId,$objEventId,$reportDate,$resolved, $reportText));
            $data = array_pop($dataArray);
        }

        return $reportArray;
    }

    public function resolveReport($reportId, $status){
        $query = "UPDATE report SET resolved = '$status' WHERE report_id = '$reportId';";
        
		return parent::executeModification($query);
	}

    public function isResolved($reportId){
        $eventQuery = "SELECT * FROM report WHERE report_id = ".$reportId.";";

        $dataArray=parent::executeQuery($eventQuery);
        $data = array_pop($dataArray);

        return ($data["resolved"]);
    }
}

?>