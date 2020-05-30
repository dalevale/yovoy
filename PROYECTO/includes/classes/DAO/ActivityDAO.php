<?php
require_once __DIR__.'/../TransferObjects/TOActivity.php';
require_once __DIR__.'/DAO.php';

class ActivityDAO extends DAO{
    //Constantes para el tipo de actividad de los usuarios
    const NEW_FRIEND = 0;
    const NEW_EVENT = 1;
    const PROMOTED_EVENT = 2;
    const JOINED_EVENT = 3;
    const UPLOAD_PHOTO = 4;

    //Constantes para el tipo de objeto de una actividad
    const USER = 0;
    const EVENT = 1;

    public function __construct(){
        parent::__construct();
    }

    /**
    * Meter una fila de actividad a la Base de Datos
    *
    * @param int $userId         Id del dueño de la actividad
    * @param int $objType        Tipo de objeto de la actividad o USER o EVENT
    * @param int $objUserId      Si tipo USER, id de algun usuario
    * @param int $objEventId     Si tipo EVENT, id de algun evento
    * @param int $activityType   Tipo de la actividad que occurio  

    * @return int $result          Devuelve el id si se ha insertado la actividad en la BBDD con exito.
    */
    public function addActivity($userId, $objType, $objUserId, $objEventId, $activityType){
        $activityDate = date("Y-m-d g:ia");
        $query = "INSERT INTO activity (user_id, object_type, obj_user_id, obj_event_id, activity_date, activity_type) 
                 VALUES ($userId, $objType, $objUserId, $objEventId, now(), $activityType);";
        parent::executeInsert($query);
    }

    /**
    * Borrar una fila de actividad de la Base de Datos
    *
    * @param int $activityId    Id de la actividad a Borrar
    *
    * @return int $result       Devuelve el numero total de las filas que se han borrado.
    */
    public function removeActivity($activityId){
        $query = "DELETE FROM activity WHERE id = '$activityId'";
        parent::executeModification($query);
    }

    /**
    * Borrar una fila de actividad de la Base de Datos al borrar un evento o un usuario.
    *
    * @param int $userId         Id del dueño de la actividad
    * @param int $objType        Tipo de objeto de la actividad o USER o EVENT
    * @param int $objId          Id de algun usuario/evento
    * @param int $activityType   Tipo de la actividad que occurio  
    *
    * @return int $result       Devuelve el numero total de las filas que se han borrado.
    */
    public function removeActivityByObject($userId, $objType, $objId, $activityType){
        $query = "DELETE FROM activity WHERE 
        user_id = '$userId' AND
        ((obj_user_id = '$objId') OR
        (obj_event_id = '$objId')) AND
        object_type = '$objType' AND
        activity_type = '$activityType';";
        
        parent::executeModification($query);
    }

    /**
    * Recoger todas las actividades de los amigos de un usuario en orden
    *
    * @param int $userId            Id del usuario con la sesion iniciada en la aplicación
    *
    * @return array $activityArray  Array de tipo TOActivity de las actividades recogidas de la Base de Datos
    */
    public function getFriendsActivity($userId){
        $query = "SELECT * FROM activity a JOIN relationship r WHERE ((r.user_one_id = '$userId' AND r.user_two_id = a.user_id)
            OR (r.user_one_id = a.user_id AND r.user_two_id = '$userId')) AND r.status = 1;";
        $dataArray = parent::executeQuery($query);
       
        $activityArray = array();

        $data = array_pop($dataArray);
        while(!empty($data)){
            $activityId = $data["activity_id"];
            $userId = $data["user_id"];
            $objType = $data["object_type"];
            $objUserId = $data["obj_user_id"];
            $objEventId = $data["obj_event_id"];
            $activityDate = $data["activity_date"];
            $activityType = $data["activity_type"];

            array_push($activityArray, new TOActivity($activityId,$userId,$objType,$objUserId,$objEventId,$activityDate,$activityType));
            $data = array_pop($dataArray);
        }
        return $activityArray;
    }

    /**
    * Funcion para devolver el string a imprimir dependiendo del tipo de la actividad.
    *
    * @param int $activityType  Tipo de la actividad
    *
    * @return string str        String a devolver para imprimir
    */
    public function getActivityString($activityType){
        switch ($activityType){
            case self::NEW_FRIEND:
                $str = ' has a new friend: ';
            break;
            case self::NEW_EVENT:
                $str = ' has made a new event: ';
            break;
            case self::PROMOTED_EVENT:
                $str = ' has a promoted an event: ';
            break;
            case self::JOINED_EVENT:
                $str = ' has joined an event: ';
            break;
            case self::UPLOAD_PHOTO:
                $str = ' has a uplaoded a new photo.';
            break;
		}
        return $str;
	}
}
?>