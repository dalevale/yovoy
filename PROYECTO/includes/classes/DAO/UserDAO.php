<?php
require_once __DIR__.'/../TransferObjects/TOUser.php';
require_once __DIR__.'/DAO.php';
class UserDAO extends DAO{

    public function __construct($conn){
        parent::__construct($conn);
	}
    public function registerUser($email, $password, $username, $name, $imgName, $creationDate, $type){        
        //VALORES A INSERTAR EN LA BBDD
        $queryValues =  
            "'".$email."',"
            ."'".self::hashPassword($password)."',"
			."'".$username."',"
            ."'".$name."',"
            ."'".$imgName."',"
            ."'".$creationDate."',"
            ."'".$type."'";

        $registerUser= "INSERT INTO user (email, password, username, name, img_name, creation_date, type) 
                VALUES(".$queryValues.")";

        return $this->dbConn->query($registerUser);
    }

    public function getId($email){
        $loginUserQuery = "SELECT user_id FROM user WHERE email = '".$email."';";
        
        $result = $this->dbConn->query($loginUserQuery);
        if( $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $result = $row["user_id"];        
        }
        
        return $result;
    }

    public function userExists($email){
        $loginUserQuery = "SELECT email FROM user WHERE email = '".$email."';";
        $result = $this->dbConn->query($loginUserQuery);

        return $result->num_rows > 0;
    }

    public function getUser($userId){
        $loginUserQuery = "SELECT * FROM user WHERE user_id = ".$userId."";
        $result = $this->dbConn->query($loginUserQuery);

        while($row = $result->fetch_assoc()) {
            $userId= $row["user_id"];
            $email = $row["email"];
            $username = $row["username"];
            $password = $row["password"];
            $creationDate = $row["creation_date"];
            $imgName = $row["img_name"];
            $name = $row["name"];
            $type = $row["type"];
        }

        return new TOUser($userId, $username, $password, $creationDate, $name, $email, $imgName, $type);
    }
	
	public function changeName($userId, $name){
		$changeNameQuery = "UPDATE user SET name = '" . $name . "' WHERE user_id = '" . $userId . "';";
		
		return $this->dbConn->query($changeNameQuery);
	}
	
	public function changeImg($userId, $imgName){
		$changeImgQuery = "UPDATE user SET img_name = '" . $imgName . "' WHERE user_id = '" . $userId . "';";
		
		return $this->dbConn->query($changeImgQuery);
	}
	
	public function changePassword($userId, $newPass){
		$changePassQuery = "UPDATE user SET password = '" . self::hashPassword($newPass) . "' WHERE user_id = '" . $userId . "';";
		
		return $this->dbConn->query($changePassQuery);
	}

    public function joinEvent($userId, $eventId, $date){
        $joinEventQuery = "INSERT INTO join_event VALUES ('.$eventId.', '.$userId.', '.$date.', false);"; 
        /*".$userId.", ".$eventId.", ".$date.", false);";*/

        return $this->dbConn->query($joinEventQuery);
	}
	
	private function hashPassword($password){
		return password_hash($password, PASSWORD_DEFAULT);
	}

/*    public function joinIsAccepted($conn, $userId, $eventId){
        joinPendQuery = "SELECT accepted FROM joinEvent WHERE user_id = '" . $userId . "' AND event_id = '". $eventId."';";

        $result = $conn->query($joinPendQuery);
        if($row = $result->fetch_assoc()) {
            $status = $row["accepted"];
        }
        return $status;
	}*/
}
?>
