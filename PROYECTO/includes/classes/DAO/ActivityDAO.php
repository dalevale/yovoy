<?php

require_once __DIR__.'/../TransferObjects/TOActivity.php';
require_once __DIR__.'/DAO.php';



class ActivityDAO extends DAO{
    const NEW_FRIEND = 0;
    const NEW_EVENT = 1;
    const PROMOTED_EVENT = 2;
    const JOINED_EVENT = 3;
    const UPLOAD_PHOTO = 4;

    const USER = 0;
    const EVENT = 1;

    public function __construct(){
        parent::__construct();
    }

    public function addActivity($userId, $objType, $objUserId, $objEventId, $activityType){
        $activityDate = date("Y-m-d g:ia");
        $query = "INSERT INTO activity (user_id, object_type, obj_user_id, obj_event_id, activity_date, activity_type) 
                 VALUES ($userId, $objType, $objUserId, $objEventId, now(), $activityType);";
        parent::executeInsert($query);
    }

    public function removeActivity($activityId){
        $query = "DELETE FROM activity WHERE id = '$activityId'";
        parent::executeModification($query);
    }

    public function removeActivityByObject($userId, $objType, $objId, $activityType){
        $query = "DELETE FROM activity WHERE 
        user_id = '$userId' AND
        ((obj_user_id = '$objId') OR
        (obj_event_id = '$objId')) AND
        object_type = '$objType' AND
        activity_type = '$activityType';";
        
        parent::executeModification($query);
    }

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

    public function getActivityString($activityType){
        switch ($activityType){
            case self::NEW_FRIEND:
                $html = ' has a new friend: ';
            break;
            case self::NEW_EVENT:
                $html = ' has made a new event: ';
            break;
            case self::PROMOTED_EVENT:
                $html = ' has a promoted an event: ';
            break;
            case self::JOINED_EVENT:
                $html = ' has joined an event: ';
            break;
            case self::UPLOAD_PHOTO:
                $html = ' has a uplaoded a new photo.';
            break;
		}
        return $html;
	}
}

?>