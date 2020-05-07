<?php
require_once __DIR__.'/../TransferObjects/TOUser.php';
require_once __DIR__.'/DAO.php';
class UserDAO extends DAO{

    public function __construct($conn){
        parent::__construct($conn);
	}

    /**
    * Meter una fila de user a la Base de Datos
    *
    * @param string $email          Email del usuario
    * @param string $password       Password del usuario
    * @param string $username       Username del usuario, se usa como identificador de los creadores del evento
    *                               Hay que modificarlo a un valor UNIQUE en la BBDD
    * @param string $name           Nombre del usuario
    * @param string $imgName        Nombre de la imagen en /includes/img/usuarios  
    * @param Date $creationDate     Fecha del evento
    * @param int $type              Tipo del usuario (Admin, Normal, Premium)
    * @return bool $result          Devuelve true si se ha insertado el user en la BBDD con exito.
    */
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
        $result = $this->dbConn->query($registerUser);

        return $result;
    }

    /**
    * Recoger el id del usuario correspondiente al su email cuando se inicia sesi�n.
    * Se usa para despu�s recoger el objeto TOUser con el Id recogido.
    *
    * @param string $email  Email del usuario
    * @return int $result   Devuelve el identificador del usuario
    */
    public function getId($email){
        $loginUserQuery = "SELECT user_id FROM user WHERE email = '".$email."';";
        
        $result = $this->dbConn->query($loginUserQuery);
        if( $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $result = $row["user_id"];        
        }
        return $result;
    }

    /**
    * Funci�n para verificar existencia de la fila correspondiente al email 
    * integrado por el usuario. Para verificar existencia de su cuenta en la BBDD.
    * 
    * @param string $email          Email del usuario
    * @return bool $emailExists     Devuelve true si se encuentra la fila en la BBDD.
    */
    public function userExists($email){
        $loginUserQuery = "SELECT email FROM user WHERE email = '".$email."';";
        $result = $this->dbConn->query($loginUserQuery);

        return $result->num_rows > 0;
    }

    /**
    * Devolver un objeto TOUser tras un query a la BBDD.
    *
    * @param int $userId       Id del evento
    * @return TOUser $user     Objeto TOUser creado con los datos desde la BBDD
    */
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
	
	public function updateUser($id, $email, $password, $username, $name, $imgName, $creationDate, $type){
		//VALORES A INSERTAR EN LA BBDD
        $userUpdated = false;

        $updateStr = 
            "'".$email."',"
            ."'".self::hashPassword($password)."',"
			."'".$username."',"
            ."'".$name."',"
            ."'".$imgName."',"
            ."'".$creationDate."',"
            ."'".$type."'";
        $updateQuery = "UPDATE user SET ".$updateStr." WHERE user_id = '".$id."';";

        $userUpdated = $this->dbConn->query($updateQuery);

        return $userUpdated;
	}

    /**
    * Funci�n para meter una fila en la BBDD en la tabla join_event
    * cuando un usuario con id $userId se apunta en un evento con id $eventId
    *
    * @param int $eventId   Id del evento
    * @param int $userId    Id del usuario
    * @param Date $date     Fecha de la actividad
    * @return bool $success Devuelve true si se ha insertado correctamente la fila en la BBDD.
    */
    public function joinEvent($eventId, $userId, $date){
        $joinEventQuery = "INSERT INTO join_event (event_id, user_id, join_date,accepted) VALUES ('$eventId','$userId' , '$date', '0');"; 

        return $this->dbConn->query($joinEventQuery);
	}
	
	private function hashPassword($password){
		return password_hash($password, PASSWORD_DEFAULT);
	}

    /**
    * Funci�n para recoger todos los eventos creados por el usuario con id $userId en la BBDD.
    * 
    * @param int $userId            Id del usuario
    * @return array $eventArray     Array de objetos TOEvent creados con los datos en la BBDD.
    */
    public function getCreatedEvents($userId){
        $eventsQuery = "SELECT * FROM event WHERE creator = ".$userId.";";
        $eventArray = array();
        $result = $this->dbConn->query($eventsQuery);
        while($row = $result->fetch_assoc()) {
            $eventId= $row["event_id"];
            $name = $row["name"];
            $creator = $row["creator"];
            $imgName = $row["img_name"];
            $creationDate = $row["creation_date"];
            $eventDate = $row["event_date"];
            $capacity = $row["capacity"];
            $location = $row["location"];
            $tags = $row["tags"];
            $description = $row["description"];
            array_push($eventArray, new TOEvent($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description));
        }
        return $eventArray;
	}
    
    /**
    * Funci�n para verificar si el evento con id $eventId es propio del usuario con id $userId
    *
    * @param int $userId    Id del usuario
    * @param int $eventId   Id del evento
    * @return bool @result  Devuelve true si se encuentra la fila en la BBDD.
    */
    public function isMyEvent($userId, $eventId){
        $eventQuery = "SELECT * FROM event WHERE creator = ".$userId." AND event_id = ".$eventId.";";
        $result = $this->dbConn->query($eventQuery);
        
        return $result->fetch_assoc() !== null;
    }
	
    /**
    * Funci�n para verificar si el usuario con id $userId es un asistente del evento con id $eventId
    *
    * @param int $userId    Id del usuario
    * @param int $eventId   Id del evento
    * @return bool @result  Devuelve true si se encuentra la fila en la BBDD.
    */
    public function isAttending($userId, $eventId){
        $eventQuery = "SELECT * FROM join_event WHERE user_id = ".$userId." AND event_id = ".$eventId.";";
        $result = $this->dbConn->query($eventQuery);
        return $result->fetch_assoc() !== null;
	}

    /**
    * Funci�n para recoger todos los amigos del usuario con un query en la
    * tabla relationship en la BBDD.
    *
    * @param int $userId            Id del usuario
    * @return array @$userArray     Devuelve un array de los identificadores de los usuarios.
    */
    public function getFriends($userId){
        $query = "SELECT * FROM relationship WHERE status = 1 AND (user_one_id = ".$userId." OR user_two_id =  ".$userId.");";
        $userArray = array();
        $result = $this->dbConn->query($query);
        while($row = $result->fetch_assoc()) {
            $friendId= $row["user_one_id"] == $userId? $row["user_two_id"] : $row["user_one_id"];
            array_push($userArray, $this->getUser($friendId));
        }
        return $userArray;
	
	}
}
?>
