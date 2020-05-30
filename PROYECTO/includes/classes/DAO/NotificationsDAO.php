<?php

require_once __DIR__.'/../TransferObjects/TONotifications.php';
require_once __DIR__.'/DAO.php';



class NotificationsDAO extends DAO{
    //Constantes que definen el tipo de la notificación
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
    * Función para crear la notificación con los datos sacados de la Base de datos
    *
    * @param array $data                Datos de la notificación
    *
    * @return TONotifications notif     Notificación creada
    */
    public function createNotificaction($data){
        $id = $data["id"];
        $thisUser = $data["this_user_id"];
        $thatUser = $data["that_user_id"];
        $eventId = $data["event_id"];
        $type = $data["type"];
        $date = $data["date"];
        $isRead = $data["isRead"];

        return new TONotifications($id,$thisUser,$thatUser,$eventId,$type,$date,$isRead);
	}

    /** 
    * Función para meter una fila de notificación en la Base de datos
    *
    * @param int $type          Tipo de notificación
    * @param int $thisUser      ID del usuario que recibe la notificación
    * @param int $thatUser      ID del usuario que aparece en la notificación
    * @param int $eventId       ID del evento
    *
    * @return int $notifId      ID de la notificación que se ha metido en la Base de Datos
    */
    public function notify($type, $thisUser, $thatUser, $eventId){
        $date = date("Y-m-d");
        $query = "INSERT INTO notifications (this_user_id, that_user_id, event_id, type, date, isRead) 
                  VALUES ($thisUser, $thatUser, $eventId, $type, '$date', false)";
        parent::executeInsert($query);
    }

    /**
    * Función para eliminar una fila de notificación de la Base de datos
    * Se usa cuando el usuario quiere borrar la notificación desde la aplicación
    *
    * @param int $notificationId    Id de la notificación
    *
    * @return int $num              Numero de filas que se han eliminado de la Base de Datos
    */
    public function removeNotificationsById($notificationId){
        $query = "DELETE FROM notifications WHERE id = '$notificationId'";
        parent::executeModification($query);
    }

    /**
    * Función para eliminar una fila de notificación de la Base de datos
    * Se usa cuando se elimina el propio objeto de la notificación
    *
    * @param int $thisUser  Id del usuario que recibe la notificación
    * @param int $thatUser  Id del usuario que aparece en la notificación
    * @param int $type      Tipo de la notificación
    *
    * @return int $num              Numero de filas que se han eliminado de la Base de Datos
    */
    public function removeNotificationsByUsers($thisUser, $thatUser, $type){
        $query = "DELETE FROM notifications WHERE 
        ((this_user_id = '$thisUser' AND that_user_id = '$thatUser') OR
        (this_user_id = '$thatUser' AND that_user_id = '$thisUser')) AND
        type = $type";
        
        parent::executeModification($query);
    }

    /**
    * Función para eliminar una fila de notificación de la Base de datos
    * Se usa cuando se elimina el propio objeto de la notificación en este caso, el evento
    *
    * @param int $thisUser  Id del usuario que recibe la notificación
    * @param int $thatUser  Id del usuario que aparece en la notificación
    * @param int $eventId   Id del evento
    * @param int $type      Tipo de la notificación
    *
    * @return int $num              Numero de filas que se han eliminado de la Base de Datos
    */
    public function removeNotificationsByEvent($thisUser, $thatUser,$eventId,$type){
        $query = "DELETE FROM notifications WHERE this_user_id = '$thisUser' AND that_user_id = '$thatUser' AND event_id='$eventId' AND type = '$type'";
        parent::executeModification($query);
    }

    /** 
    * @param int $userId                        ID del usuario que recibe la notificación
    *
    * @return array $notificationsArray         Array de notificaciones
    */
    public function getNotificationsByUser($userId){
        $query = "SELECT * FROM notifications WHERE this_user_id = '$userId'";
        $dataArray = parent::executeQuery($query);
       
        $notificationsArray = array();
        $data = array_pop($dataArray);
        while(!empty($data)){
            array_push($notificationsArray, $this->createNotificaction($data));
            $data = array_pop($dataArray);
        }
        return $notificationsArray;
    }

    /**
    * Función para sacar una fila de notificación desde la Base de datos
    * 
    * @param int $notifId   Id de la notificación a sacar
    *
    * @return TONotifications $notification     Objeto notificacíón encontrada en la Base de datos
    */
    public function getNotification($notifId){
        $query = "SELECT * FROM notifications WHERE id = '$notifId'";
        $dataArray = parent::executeQuery($query);
        $data = array_pop($dataArray);

        return $this->createNotificaction($data);
	}

    /** 
    * Función para modificar el estado de una notificación: Leído o no leído
    *
    * @param bool $status   Estado de lectura de la notificación
    * @param int $notifId   Id de la notificación
    * 
    * @return int $num      Numero de filas que se han modificado en la Base de Datos
    */
    public function markAsRead($status,$notifId){
        $query = "UPDATE notifications SET isRead = $status WHERE id = $notifId";
        parent::executeModification($query);
    }
}

?>