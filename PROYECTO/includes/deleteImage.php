<?php
require_once __DIR__.'/config.php';

    $auxImgDAO = new AuxImgDAO;
    $eventId = $_POST["event_id"];
    $imgId = $_POST["img_id"];

    $auxImgDir = "/Yovoy/Proyecto/includes/img/events_aux/";

    $result = $auxImgDAO->deleteImg($eventId,$imgId);

    //if ($result){
        $imgName = $eventId . "_" . $imgId . ".php";
        unlink ($_SERVER['DOCUMENT_ROOT'] . $auxImgDir . $imgName);
    //}

    echo $result;