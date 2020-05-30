<?php
require_once __DIR__.'/config.php';

    $eventDAO = new EventDAO;
    $eventId = $_POST["eventId"];

    $result = $eventDAO->deleteEvent($eventId);

    echo $result;
