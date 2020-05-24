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

}

?>