<?php
require_once __DIR__.'/Form/Form.php';

class RelationManager extends Form {
    const USERONEADD = 0; //PENDING
    const USERTWOADD = 1;
    const USERONEACCEPT = 2;//ACCEPTED
    const USERTWOACCEPT = 3;
    const USERONEBLOCK = 4; //BLOCKED
    const USERTWOBLOCK = 5;
    const USERONEUNFR = 6; //UNFRIEND
    const USERTWOUNFR = 7;
    const USERONEUNBL = 8; //UNBLOCK
    const USERTWOUNBL = 9;

    public $dbConn;
    public $userOneId;
    public $userTwoId;
    private $status;

    public function __construct($conn, $userOneId, $userTwoId){
        parent::__construct('relationForm');
        $this->dbConn = $conn;
        $this->userOneId = $userOneId;
        $this->userTwoId = $userTwoId;
        $this->status = $this->relationStatus($this->userOneId, $this->userTwoId);
        $this->action.= "?profileId=".$userTwoId;
	}

    /**
    * Función para comprabar la columna 'status' en la tabla 'relationship' en la BBDD
    *
    * @param int $userId        Id del usuario con el que la sesion se inicia
    * @param int $profileId     Id del usuario de la perfil que se esta viendo
    * @return enum $ret         Valor int que va a corresponder a los enums definidos
    */
    private function relationStatus($userId, $profileId){
        $query = "SELECT status, action_user_id FROM relationship WHERE user_one_id = ".min($userId, $profileId)." AND user_two_id = ".max($userId, $profileId).";";
        $result =  $this->dbConn->query($query);
        $ret = null;
        if($row = $result->fetch_assoc()){
            $ret=0;
            $status = $row["status"];
            $actionId = $row["action_user_id"];
            $ret = $status * 2;
            if($actionId == $profileId)
                $ret++;
			  
		}     
        return $ret;
    }

    /**
    * Genera los campos (en este caso los botones) dependiendo del valor devuelto
    * por la funcion self::relationStatus
    *
    * @param array $initialDate     Se ignora
    * @return string $html          Cadenas de html a generar en la pagina
    */
    protected function generateFormFields($initialData){

        if($this->status === null){
               $html = <<<EOF
				<input type="submit" name="addFriend" value="Add Friend" title="Añadir amigo">
EOF;
		}
        else {
        switch($this->status){
            case self::USERONEADD:
                $html = <<<EOF
                <input type="submit" name="cancelAddFriend" value="Friend Request Pending - Cancel">
EOF;
                break;
            case self::USERTWOADD:
                $html = <<<EOF
                <input type="submit" name="acceptFriend" value="Accept Friend Request">
EOF;
                break;
            case self::USERONEACCEPT:
                $html = <<<EOF
                <input type="submit" name="unfriend" value="Unfriend">
EOF;
                break;
            case self::USERTWOACCEPT:
                $html = <<<EOF
                <input type="submit" name="unfriend" value="Unfriend">
EOF;
                break;
            case self::USERONEBLOCK:
                $html = <<<EOF
                <p>YOU BLOCKED THIS USER</p>
EOF;
                break;
            case self::USERTWOBLOCK:
                $html = <<<EOF
                <p>THIS USER BLOCKED YOU</p>
EOF;
                break;
            default:
                $html = <<<EOF
				<input type="image" alt="submit" src="includes/img/icono_FRIENDS.png" title="Añadir amigo"/></form> 
EOF;
                break;
		}
		}
        return $html;
	}
    

    protected function processForm($data) {
        $result = array();
       
       if(isset($data['addFriend'])){
            $this->insertRow($this->userOneId, $this->userTwoId, 0, $this->userOneId);
	   }
       else if(isset($data['cancelAddFriend'])){
            $this->deleteRow($this->userOneId, $this->userTwoId);
	   }
       else if(isset($data['acceptFriend'])){
            $this->deleteRow($this->userOneId, $this->userTwoId);
            $this->insertRow($this->userOneId, $this->userTwoId, 1, $this->userOneId);
	   }
       else if(isset($data['unfriend'])){
            $this->deleteRow($this->userOneId, $this->userTwoId);
	   }
       
       $result = 'profileView.php?profileId=3';
       return $result;
    }

    /**
    * Insertar una fila en la BBDD en la tabla relationship para establecer relación
    * entre dos cuentas de usuario con id´s $userOneId y $userTwoId
    *
    * @param int $userOneId         Id del usuario con el que la sesion se inicia
    * @param int $userTwoId         Id del otro usuario con que se quiere establecer relación
    * @param int $status            Estado de relacion de las cuentas (0 - Pendiente, 1 - Amigos, 2 - Cuenta bloqueada)
    * @param int $action_user_id    Id del usuario ($userOneId o $userTwoId) que hizo el ultimo gesto (cambiar el estado)
    * @return bool $result          Devuelve true si se ha insertado correctamenta la fila.
    */
    private function insertRow($userOneId, $userTwoId, $status, $action_user_id){
        $queryValues =  
                "'".min($userOneId, $userTwoId)."',"
			    ."'".max($userOneId, $userTwoId)."',"
                ."".$status.","
                ."'".$userOneId."'";
        $query = "INSERT INTO relationship (user_one_id, user_two_id, status, action_user_id) VALUES (".$queryValues.")";
        $result = $this->dbConn->query($query);

        return $result;
	}

    /**
    * Función para eliminar una fila en la tabla relationship
    *
    * @param int $userOneId         Id del usuario con el que la sesion se inicia
    * @param int $userTwoId         Id del otro usuario.
    * @return bool $result          Devuelve true si se ha insertado correctamenta la fila.
    */
    private function deleteRow($userOneId, $userTwoId){
        $query = "DELETE FROM relationship WHERE user_one_id = '".min($userOneId, $userTwoId)."' AND user_two_id = '".max($userOneId, $userTwoId)."';";
        $result = $this->dbConn->query($query);

        return $result;
	}
}
?>