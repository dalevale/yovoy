<?php

require_once __DIR__.'/../TransferObjects/TONotifications.php';
require_once __DIR__.'/DAO.php';



class NotificationsDAO extends DAO{
    const NEW_FRIEND_REQUEST = 0;
    const FRIEND_REQUEST_ACCEPTED = 1;
    const NEW_EVENT_REQUEST = 2;
    const EVENT_REQUEST_ACCEPTED = 3;
    const EVENT_EDITED = 4;
    const NEW_COMMENT = 5;
    const EVENT_IS_NEAR = 6;
    const HAS_NEW_EVENT = 7;

    public function __construct(){
        parent::__construct();
    }

    /** 
    * @param int $type          Tipo de notificación
    * @param int $thisUser      ID del usuario que recibe la notificación
    * @param int $thatUser      ID del usuario que aparece en la notificación
    * @param int $eventId       ID del evento
    */
    public function notify($type, $thisUser, $thatUser, $eventId){
        $date = date("Y-m-d");
        $query = "INSERT INTO notifications (this_user_id, that_user_id, event_id, type, date, isRead) 
                  VALUES ($thisUser, $thatUser, $eventId, $type, '$date', false)";
        parent::executeInsert($query);
    }

    public function removeNotificationsById($notificationId){
        $query = "DELETE FROM notifications WHERE id = '$notificationId'";
        parent::executeModification($query);
    }

    public function removeNotificationsByUsers($thisUser, $thatUser, $type){
        $query = "DELETE FROM notifications WHERE 
        ((this_user_id = '$thisUser' AND that_user_id = '$thatUser') OR
        (this_user_id = '$thatUser' AND that_user_id = '$thisUser')) AND
        type = $type";
        
        parent::executeModification($query);
    }

    public function removeNotificationsByEvent($thisUser, $thatUser,$eventId,$type){
        $query = "DELETE FROM notifications WHERE this_user_id = '$thisUser' AND that_user_id = '$thatUser' AND event_id='$eventId' AND type = '$type'";
        parent::executeModification($query);
    }

    /** 
    * @param int $userId                        ID del usuario que recibe la notificación
    * @return array $notificationsArray         Array de notificaciones
    */
    public function getNotificationsByUser($userId){
        $query = "SELECT * FROM notifications WHERE this_user_id = '$userId'";
        $dataArray = parent::executeQuery($query);
       
        $notificationsArray = array();

        $data = array_pop($dataArray);
        while(!empty($data)){
            $id = $data["id"];
            $thisUser = $data["this_user_id"];
            $thatUser = $data["that_user_id"];
            $eventId = $data["event_id"];
            $type = $data["type"];
            $date = $data["date"];
            $isRead = $data["isRead"];

            array_push($notificationsArray, new TONotifications($id,$thisUser,$thatUser,$eventId,$type,$date,$isRead));
            $data = array_pop($dataArray);
        }

        return $notificationsArray;
    }

    public function getNotification($notifId){
        $query = "SELECT * FROM notifications WHERE id = '$notifId'";
        $dataArray = parent::executeQuery($query);
        $data = array_pop($dataArray);

        $id = $data["id"];
        $thisUser = $data["this_user_id"];
        $thatUser = $data["that_user_id"];
        $eventId = $data["event_id"];
        $type = $data["type"];
        $date = $data["date"];
        $isRead = $data["isRead"];

        return new TONotifications($id,$thisUser,$thatUser,$eventId,$type,$date,$isRead);

        return $notificationsArray;
	}
    /** 
    * @param bool $status   Estado de lectura de la notificación
    */
    public function markAsRead($status,$id){
        $query = "UPDATE notifications SET isRead = $status WHERE id = $id";
        parent::executeModification($query);
    }
}

?>