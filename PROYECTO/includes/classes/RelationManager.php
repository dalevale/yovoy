<?php

class RelationManager{
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
    //constates para la columna STATUS de la tabla relationship
    const ADD = 0;
    const ACCEPT = 1;
    const BLOCK = 2;

    private $userOneId;
    private $userTwoId;
    private $userDAO;
    private $status;
    public function __construct($userOneId, $userTwoId){

        $this->userOneId = $userOneId;
        $this->userTwoId = $userTwoId;
        $this->userDAO = new UserDAO();
        $this->status = $this->userDAO->relationStatus($userOneId, $userTwoId);
	}

    /**
    * Genera los campos (en este caso los botones) dependiendo del valor devuelto
    * por la funcion self::relationStatus
    *
    * @param array $initialDate     Se ignora
    * @return string $html          Cadenas de html a generar en la pagina
    */
    public function printButtons(){
        $html = '';
        if($this->status === null){
               $html .= 
				'<input type="image" src="includes/img/boton_AMIGO.png" width="40%" length="40%" id="addFriendBtn" alt="Añadir amigo" title="Añadir amigo" value="'.$this->userTwoId.'">
                <input type="image" src="includes/img/boton_BLOQUEAR.png" width="40%" length="40%" id="blockUserBtn" type ="button" alt="Bloquear Usuario" title="Bloquear usuario" value="'.$this->userTwoId.'">';
		}
        else {
        switch($this->status){
            case self::USERONEADD:
                $html .= '<input type="image" src="includes/img/boton_QUITARAMIGO.png" width="40%" length="40%" alt="Cancelar Solicitud" title="Cancelar Solicitud" id="cancelAddFriendBtn"  value="'.$this->userTwoId.'">';
                break;
            case self::USERTWOADD:
                $html .= '<p>Aceptar amigo?</p><input type="image" src="includes/img/boton_OK.png" alt="Aceptar Solicitud" title="Aceptar Solicitud" width="40%" length="40%" id="acceptFriendBtn" value="'.$this->userTwoId.'">
                <input type="image" src="includes/img/boton_CANCELAR.png" alt="Rechazar Solicitud" title="Rechazar Solicitud" width="40%" length="40%" id="rejectFriendBtn" value="'.$this->userTwoId.'">';
                break;
            case self::USERONEACCEPT:
                $html .= '<input type="image" src="includes/img/boton_QUITARAMIGO.png" width="40%" length="40%" alt="Quitar Amigo" title="Quitar Amigo" id="unfriendBtn" value="'.$this->userTwoId.'">';
                break;
            case self::USERTWOACCEPT:
                $html .= '<input type="image" src="includes/img/boton_QUITARAMIGO.png" width="40%" length="40%" alt="Quitar Amigo" title="Quitar Amigo" id="unfriendBtn" value="'.$this->userTwoId.'">';
                break;
            case self::USERONEBLOCK:
                $html .= '<p>YOU BLOCKED THIS USER</p>
                <input type="image" src="includes/img/boton_DESBLOQUEAR.png" id="unblockUserBtn" alt="Desbloquear" title="Desbloquear" width="40%" length="40%" value="'.$this->userTwoId.'">';
                break;
            case self::USERTWOBLOCK:
                $html .= '<p>THIS USER BLOCKED YOU</p>';
                break;
            default:
                $html .= '
				<input type="image" alt="submit" src="includes/img/AMIGO.png" title="A�adir amigo"/></form>';
                break;
		}
		}
        return $html;
	}
}
?>