<?php
require_once __DIR__.'/../TransferObjects/TOReport.php';
require_once __DIR__.'/DAO.php';

class ReportDAO extends DAO {
    //Constantes que definen el objeto de un report
    const USER = 0;
    const EVENT = 1;
    
    //Constantes que definen el estado de un report
    const UNRESOLVED = 0;
    const RESOLVED = 1;

    public function __construct(){
        parent::__construct();
    }

    /**
    * Función para añadir una fila de report en la Base de Datos
    *
    * @param int $userId        Id del usuario que hizo el report
    * @param int $objType       Tipo del objeto del report: o USER o EVENT
    * @param int $objUserId     Si tipo USER, Id del usuario
    * @param int $objEventId    Si tipo EVENT, Id del evento
    * @param int $resolved      Estado del report, o resuelto o no resuelto
    * @param int $reportText    Texto incluido en el report
    *
    * @return int $reportId     Id del report recien metido en la Base de Datos
    */
    public function addReport($userId, $objType, $objUserId, $objEventId, $resolved, $reportText){
        $query = "INSERT INTO report (user_id, object_type, obj_user_id, obj_event_id, report_date, resolved, report_text) 
                 VALUES ($userId, $objType, $objUserId, $objEventId, now(), $resolved, '$reportText');";
        parent::executeInsert($query);
    }

    /**
    * Función para eliminar un report de la Base de Datos
    *
    * @param int $reportId  Id del report
    *
    * @return int $num      Numero de filas eliminadas en la Base de Datos
    */
    public function removeReport($reportId){
        $query = "DELETE FROM report WHERE report_id = '$reportId'";
        parent::executeModification($query);
    }

    /**
    * Función para eliminar un report 
    */
    public function removeReportByObject($userId, $objType, $objId){
        $query = "DELETE FROM report WHERE 
        user_id = '$userId' AND
        ((obj_user_id = '$objId') OR
        (obj_event_id = '$objId')) AND
        object_type = '$objType';";
        
        parent::executeModification($query);
    }

    /**
    * Función para recoger todos los reports
    *
    * @return array TOReport    Array de objetos TOReport de la Base de Datos
    */
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

    /**
    * Función para cambiar el estado de un report
    *
    * @param int $reportId      Id del report
    * @param int $status        Estado del report
    *
    * @return int $num          Numero de filas modificadas en la Base de Datos
    */
    public function resolveReport($reportId, $status){
        $query = "UPDATE report SET resolved = '$status' WHERE report_id = '$reportId';";
        
		return parent::executeModification($query);
	}

    /**
    * Función para comprobar el estado de un report
    *
    * @param int $reportId      Id del report
    *
    * @return bool $status      Booleano devuelto, TRUE si resuelto, FALSE si no.
    */
    public function isResolved($reportId){
        $eventQuery = "SELECT * FROM report WHERE report_id = ".$reportId.";";

        $dataArray=parent::executeQuery($eventQuery);
        $data = array_pop($dataArray);

        return ($data["resolved"]);
    }
}
?>