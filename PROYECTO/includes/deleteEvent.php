<?php
require_once __DIR__.'/config.php';

    $eventDAO = new EventDAO;
    $eventId = $_POST["eventId"];

    
    $eventDAO->deleteEvent($eventId);

    echo 0;
