<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class CancelEventRequestForm extends Form
{
    public function __construct() {
        parent::__construct('cancelEventRequestForm');
    }
    
    protected function generateFormFields($data)
    {
        $userId = $_SESSION["userId"];
        $eventId = $_SESSION["event_id"];

        $html = <<<EOF
        <div class="accept_reject">
        <input type="hidden" name="userId" value="$userId">
        <input type="hidden" name="event_id" value="$eventId">
        <input type="hidden" name="status" value="0">
        <button type="submit">YaNoVoy</button>
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
     
        $event = $eventsDAO->getEvent($eventId);
        $ownerId = $event->getCreator();

        $eventsDAO->userInEventRequest($userId,$eventId,$status);
        $notificationsDAO->removeNotificationsByEvent($ownerId,$userId, $eventId, NotificationsDAO::NEW_EVENT_REQUEST);
        $notificationsDAO->notify(NotificationsDAO::EVENT_REQUEST_ACCEPTED,$userId,'NULL',$eventId);

        $result = "eventItem.php?event_id=$eventId";

        return $result;
    }
}
