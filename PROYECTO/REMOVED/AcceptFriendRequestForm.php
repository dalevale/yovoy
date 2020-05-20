<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class AcceptFriendRequestForm extends Form
{
    public function __construct() {
        parent::__construct('acceptFriendRequestForm');
    }
    
    protected function generateFormFields($data)
    {
        $userId = $_SESSION["thatUserId"];
        $source = $_SESSION["source"];

        $html = <<<EOF
     
        <div class="accept_reject">
        <input type="hidden" name="userId" value="$userId">
        <input type="hidden" name="source" value="$source">
        <input type="hidden" name="status" value="1">
        <button type="submit">Aceptar</button>
        </div>
       
EOF;

        return $html;
    }
    
    protected function processForm($data)
    {
        $notificationsDAO = new NotificationsDAO();
        $u1 = $_SESSION["userId"];
        $u2 = $_POST["userId"];
        $source = $_POST["source"];

        $relMan = new UserDAO;

        $relMan->deleteRelationship($u1, $u2);
        $relMan->insertRelationship($u1, $u2, RelationManager::ACCEPT, $u1);
        $notificationsDAO->notify(NotificationsDAO::FRIEND_REQUEST_ACCEPTED,$u2, $u1, 'NULL');
        $notificationsDAO->removeNotificationsByUsers($u1,$u2, NotificationsDAO::NEW_FRIEND_REQUEST);

        if($source == "profileView")
           $result = "profileView.php?event_id=$u2";
        else if($source == "notifications")
           $result = "notifications.php";
        
        return $result;
    }
}
