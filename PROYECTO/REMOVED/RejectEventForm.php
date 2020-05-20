<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class RejectEventForm extends Form
{
    public function __construct() {
        parent::__construct('rejectEventForm');
    }
    
    protected function generateFormFields($data)
    {
        $userId = $_SESSION["thatUserId"];
        $eventId = $_SESSION["event_id"];
        $source = $_SESSION["source"];

        $html = <<<EOF
        <div class="accept_reject">
        <input type="hidden" name="userId" value="$userId">
        <input type="hidden" name="event_id" value="$eventId">
        <input type="hidden" name="source" value="$source">
        <input type="hidden" name="status" value="0">
        <button type="submit">Rechazar</button>
        </div>
       
EOF;

        return $html;
    }
    
    protected function processForm($data)
    {
        $eventsDAO = new EventDAO();
        $notificationsDAO = new NotificationsDAO();
        $eventId = $_POST["event_id"];
        $userId = $_POST["userId"];
        $status = $_POST["status"];
        $source = $_POST["source"];
     
        $event = $eventsDAO->getEvent($eventId);
        $ownerId = $event->getCreator();

        $eventsDAO->userInEventRequest($userId,$eventId,$status);
        $notificationsDAO->removeNotificationsByEvent($ownerId,$userId, $eventId, NotificationsDAO::NEW_EVENT_REQUEST);
        $notificationsDAO->notify(NotificationsDAO::EVENT_REQUEST_ACCEPTED,$userId,'NULL',$eventId);
        if($source == "eventItem")
           $result = "eventItem.php?event_id=$eventId";
        else if($source == "notifications")
           $result = "notifications.php";
        
        
        return $result;
    }
}
