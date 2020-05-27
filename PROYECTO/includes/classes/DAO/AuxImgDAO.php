<?php
require_once __DIR__.'/DAO.php';

class AuxImgDAO extends DAO{

    public function __construct(){
        parent::__construct();
    }
    
    public function getAuxImgs($event_id){
        $query = "SELECT img_id FROM event_aux_imgs WHERE event_id=" . $event_id . "";
        
        $auxImgArray = array();
        $dataArray = parent::executeQuery($query);

        $data = array_shift($dataArray);

        while(!empty($data)){
            $auxImgName = $event_id . "_" . $data["img_id"] . ".png";

            array_push($auxImgArray, $auxImgName);
            $data = array_shift($dataArray);
        }

        return $auxImgArray;
    }

    public function getNextImgName($event_id){
        $query = "SELECT aux_autoinc FROM event WHERE event_id=" . $event_id . ";";
        $result = null;

        $dataArray = parent::executeQuery($query);
        $data = array_shift($dataArray);

        if(!empty($data)){
            $result = $event_id . "_" . $data["aux_autoinc"] . ".png";
        }

        // Si la función devuelve null, significa que el evento no existe
        return $result;
    }

    public function addImg($event_id){
        $img_id = -1;

        $query1 = "SELECT aux_autoinc FROM event WHERE event_id=" . $event_id . ";";

        $dataArray = parent::executeQuery($query1);
        $data = array_shift($dataArray);

        if(!empty($data)){
            $img_id = $data["aux_autoinc"];
        }

        if($img_id == -1){
            return false;
        }

        $queryValues = 
            "'".$event_id."'". "," 
            ."'".$img_id."'";

        $query2 = "INSERT INTO event_aux_imgs (event_id, img_id) VALUES (" . $queryValues . ");";

        return parent::executeInsert($query2);
    }

    public function deleteImg($event_id, $img_id){
        $query = "DELETE FROM event_aux_imgs WHERE event_id=" . $event_id . " AND img_id=" . $img_id . ";";

        return parent::executeModification($query);
    }

}

?>