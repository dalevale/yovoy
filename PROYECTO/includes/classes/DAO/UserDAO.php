<?php
require_once __DIR__.'/../TransferObjects/TOUser.php';
require_once __DIR__.'/DAO.php';
class UserDAO extends DAO{

    public function __construct(){
        parent::__construct();
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

        return parent::executeInsert($registerUser);
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
        
        $dataArray=parent::executeQuery($loginUserQuery);
        $data = array_pop($dataArray);
        return $data["user_id"];
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

        $dataArray=parent::executeQuery($loginUserQuery);
        $data = array_pop($dataArray);

        return !empty($data["email"]);
    }

    /**
    * Devolver un objeto TOUser tras un query a la BBDD.
    *
    * @param int $userId       Id del evento
    * @return TOUser $user     Objeto TOUser creado con los datos desde la BBDD
    */
    public function getUser($userId){
        $loginUserQuery = "SELECT * FROM user WHERE user_id = ".$userId."";
        
        $dataArray= parent::executeQuery($loginUserQuery);
        $data= array_pop($dataArray);
        
        $userId= $data["user_id"];
        $username= $data["username"];
        $password= $data["password"];
        $creationDate= $data["creation_date"];
        $name= $data["name"];
        $email= $data["email"];
        $imgName= $data["img_name"];
        $type= $data["type"];

        return new TOUser($userId, $username, $password, $creationDate, $name, $email, $imgName, $type);
    }
	

	public function changeName($userId, $name){
		$changeNameQuery = "UPDATE user SET name = '" . $name . "' WHERE user_id = '" . $userId . "';";
		
		return parent::executeModification($changeNameQuery);
	}
	
	public function changeImg($userId, $imgName){
		$changeImgQuery = "UPDATE user SET img_name = '" . $imgName . "' WHERE user_id = '" . $userId . "';";
		
		return parent::executeModification($changeImgQuery);
	}
	
	public function changePassword($userId, $newPass){
		$changePassQuery = "UPDATE user SET password = '" . self::hashPassword($newPass) . "' WHERE user_id = '" . $userId . "';";
		
		return parent::executeModification($changePassQuery);
	}
	
	public function updateUser($id, $password, $name, $imgName){
		//VALORES A INSERTAR EN LA BBDD
        $userUpdated = false;

        $updateStr = 
        "name='".$name."',"
        ."img_name='".$imgName."'";

        // Si el valor de $password es null, podemos asumir que no se cambia la contraseña
        if (!is_null($password)){
            $updateStr .= ",password='" . self::hashPassword($password) . "'";
        }

        $updateQuery = "UPDATE user SET ".$updateStr." WHERE user_id = '".$id."';";

        return parent::executeModification($updateQuery);
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

        return parent::executeInsert($joinEventQuery);
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
        $eventQuery = "SELECT * FROM event WHERE creator = ".$userId.";";
        $eventArray = array();

        $dataArray = parent::executeQuery($eventQuery);
        $data = array_pop($dataArray);
        while(!empty($data)) {
            $eventId= $data["event_id"];
            $name = $data["name"];
            $creator = $data["creator"];
            $imgName = $data["img_name"];
            $creationDate = $data["creation_date"];
            $eventDate = $data["event_date"];
            $capacity = $data["capacity"];
            $location = $data["location"];
            $tags = $data["tags"];
            $description = $data["description"];
            array_push($eventArray, new TOEvent($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description));
            $data = array_pop($dataArray);
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
        $eventQuery = "SELECT event_id FROM event WHERE creator = ".$userId." AND event_id = ".$eventId.";";

        $dataArray=parent::executeQuery($eventQuery);
        $data = array_pop($dataArray);

        return !empty($data["event_id"]);
    }
	
    /**
    * Funci�n para verificar si el usuario con id $userId es un asistente del evento con id $eventId
    *
    * @param int $userId    Id del usuario
    * @param int $eventId   Id del evento
    * @return bool @result  Devuelve true si se encuentra la fila en la BBDD.
    */
    public function isAttending($userId, $eventId){
        $eventQuery = "SELECT event_id FROM join_event WHERE user_id = ".$userId." AND event_id = ".$eventId.";";

        $dataArray=parent::executeQuery($eventQuery);
        $data = array_pop($dataArray);

        return !empty($data["event_id"]);
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

        $dataArray=parent::executeQuery($query);
        $data = array_pop($dataArray);

        while(!empty($data)){
            $friendId= $data["user_one_id"] == $userId? $data["user_two_id"] : $data["user_one_id"];
            array_push($userArray, $this->getUser($friendId));

            $data = array_pop($dataArray);
        }

        return $userArray;
	
    }
    
    public function getFriendRequests($userId){
        $query = "SELECT * FROM relationship WHERE status = '0' AND (user_one_id='$userId' XOR user_two_id='$userId') AND action_user_id != '$userId'";
        
        $dataArray=parent::executeQuery($query);
        $data = array_pop($dataArray);

        $requests = array();
        
        while(!empty($data)) {
            if($data["user_one_id"] == $data["action_user_id"])
                array_push($requests, $data["user_one_id"]);
            else
                array_push($requests, $data["user_two_id"]);

            $data = array_pop($dataArray);
        }
        
        return $requests;
    }

    public function searchUser($filter, $searchVal){
    if($filter == "name")
        $loginUserQuery = "SELECT * FROM user WHERE name = '$searchVal'";
    else
        $loginUserQuery = "SELECT * FROM user WHERE username = '$searchVal'";

        $dataArray= parent::executeQuery($loginUserQuery);
        $data= array_pop($dataArray);
        $userArray= array();
        if(!empty($data)){
            $userId= $data["user_id"];
            $username= $data["username"];
            $password= $data["password"];
            $creationDate= $data["creation_date"];
            $name= $data["name"];
            $email= $data["email"];
            $imgName= $data["img_name"];
            $type= $data["type"];
    
            array_push($userArray, new TOUser($userId, $username, $password, $creationDate, $name, $email, $imgName, $type));
        }

        return $userArray;
    }

    public function promote($userId, $eventId){
        $query = "INSERT INTO promote_event VALUES ('".$userId."', '".$eventId."');";

        return parent::executeInsert($query);
	}

    public function unpromote($userId, $eventId){
        $query = "DELETE FROM promote_event WHERE user_id = '".$userId."' AND event_id = '".$eventId."';";

        return parent::executeInsert($query);
	}

    public function isPromoting($userId, $eventId){
        $eventQuery = "SELECT * FROM promote_event WHERE user_id = ".$userId." AND event_id = ".$eventId.";";

        $dataArray=parent::executeQuery($eventQuery);
        $data = array_pop($dataArray);

        return !empty($data["event_id"]);
    }

    public function getPromotedEvents($userId){
        $eventQuery = "SELECT e.event_id, name, creator, img_name, creation_date, event_date, capacity, location, tags, description
        FROM event e JOIN promote_event pe WHERE pe.user_id = ".$userId." AND pe.event_id = e.event_id;";
        $eventArray = array();

        $dataArray = parent::executeQuery($eventQuery);
        $data = array_pop($dataArray);
        while(!empty($data)) {
            $eventId= $data["event_id"];
            $name = $data["name"];
            $creator = $data["creator"];
            $imgName = $data["img_name"];
            $creationDate = $data["creation_date"];
            $eventDate = $data["event_date"];
            $capacity = $data["capacity"];
            $location = $data["location"];
            $tags = $data["tags"];
            $description = $data["description"];
            array_push($eventArray, new TOEvent($eventId, $name, $creator, $imgName, $creationDate, $eventDate, $capacity, $location, $tags, $description));
            $data = array_pop($dataArray);
        }
        return $eventArray;
	}

    
    /**
    * Insertar una fila en la BBDD en la tabla relationship para establecer relaci�n
    * entre dos cuentas de usuario con id�s $userOneId y $userTwoId
    *
    * @param int $userOneId         Id del usuario con el que la sesion se inicia
    * @param int $userTwoId         Id del otro usuario con que se quiere establecer relaci�n
    * @param int $status            Estado de relacion de las cuentas (0 - Pendiente, 1 - Amigos, 2 - Cuenta bloqueada)
    * @param int $action_user_id    Id del usuario ($userOneId o $userTwoId) que hizo el ultimo gesto (cambiar el estado)
    * @return bool $result          Devuelve true si se ha insertado correctamenta la fila.
    */
    public function insertRelationship($userOneId, $userTwoId, $status, $action_user_id){
        $queryValues =  
                "'".min($userOneId, $userTwoId)."',"
			    ."'".max($userOneId, $userTwoId)."',"
                ."".$status.","
                ."'".$action_user_id."'";
        $query = "INSERT INTO relationship (user_one_id, user_two_id, status, action_user_id) VALUES (".$queryValues.")";
        $result = parent::executeInsert($query);

        return $result;
	}

    /**
    * Funci�n para eliminar una fila en la tabla relationship
    *
    * @param int $userOneId         Id del usuario con el que la sesion se inicia
    * @param int $userTwoId         Id del otro usuario.
    * @return bool $result          Devuelve true si se ha insertado correctamenta la fila.
    */
    public function deleteRelationship($userOneId, $userTwoId){
        $query = "DELETE FROM relationship WHERE user_one_id = '".min($userOneId, $userTwoId)."' AND user_two_id = '".max($userOneId, $userTwoId)."';";
        $result = parent::executeModification($query);

        return $result;
	}

    /**
    * Funci�n para comprabar la columna 'status' en la tabla 'relationship' en la BBDD para generar botones
    *
    * @param int $userId        Id del usuario con el que la sesion se inicia
    * @param int $profileId     Id del usuario de la perfil que se esta viendo
    * @return enum $ret         Valor int que va a corresponder a los enums definidos
    */
    public function relationStatus($userId, $profileId){
        $query = "SELECT status, action_user_id FROM relationship WHERE user_one_id = ".min($userId, $profileId)." AND user_two_id = ".max($userId, $profileId).";";
        $dataArray=parent::executeQuery($query);
        if(empty($dataArray))
            $ret = null;
        else{
            $ret = 0;
            $data = array_pop($dataArray);
            $status = $data["status"];
            $actionId = $data["action_user_id"];
            $ret = $status * 2;
            if($actionId == $profileId)
                $ret++;
		}
        return $ret;
    }

    public function deleteUser($id){
        $query = "DELETE FROM user WHERE user_id = '$id'";
        return parent::executeModification($query);
    }
}
?>
