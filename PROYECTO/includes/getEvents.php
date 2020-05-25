<?php
require_once __DIR__.'/config.php';

    $eventDAO = new EventDAO();
    $userDAO = new UserDAO();
    
    $filter = $_POST["filter"];
    $searchVal = $_POST["searchVal"];
    
    $eventsArray = $eventDAO->searchEventBy($filter , $searchVal);
    $dataArray = array();
    
    while(sizeof($eventsArray) > 0){
        $event = array_pop($eventsArray);
        $creatorId = $event->getCreator();
        $user = $userDAO->getUser($creatorId);
        $username = $user->getUsername();
        $eventJson = array(
            'id' => $event->getEventId(),
            'name' => $event->getName(),
            'date' => $event->getEventDate(),
            'eventImgName' => $event->getImgName(),
            'creator' => $username,
            'capacity' => $event->getCapacity(),
            'location' => $event->getLocation()
		);
        array_push($dataArray, $eventJson);
	}

    echo json_encode($dataArray);

?>