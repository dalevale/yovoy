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
        $html = '<div id="profileViewButtons">';
        if($this->status === null){
               $html .= 
				'<button id="addFriendBtn" type ="button" title="A�adir amigo" value="'.$this->userTwoId.'">Añadir</button>
                <button id="blockUserBtn" type ="button" title="Bloquear usuario" value="'.$this->userTwoId.'">Bloquear</button>';
		}
        else {
        switch($this->status){
            case self::USERONEADD:
                $html .= '<button type="button" id="cancelAddFriendBtn"  value="'.$this->userTwoId.'">Cancel Friend Request</button>';
                break;
            case self::USERTWOADD:
                $html .= '<button type="button" id="acceptFriendBtn" value="'.$this->userTwoId.'">Accept Friend Request</button>
                <button type="button" id="rejectFriendBtn" value="'.$this->userTwoId.'">Reject Friend Request</button>';
                break;
            case self::USERONEACCEPT:
                $html .= '<button type="button" id="unfriendBtn" value="'.$this->userTwoId.'">Unfriend</button>';
                break;
            case self::USERTWOACCEPT:
                $html .= '<button type="button" id="unfriendBtn" value="'.$this->userTwoId.'">Unfriend</button>';
                break;
            case self::USERONEBLOCK:
                $html .= '<p>YOU BLOCKED THIS USER</p>
                <button id="unblockUserBtn" type="button" value="'.$this->userTwoId.'">Unblock</button>';
                break;
            case self::USERTWOBLOCK:
                $html .= '<p>THIS USER BLOCKED YOU</p>';
                break;
            default:
                $html .= '
				<input type="image" alt="submit" src="includes/img/icono_FRIENDS.png" title="A�adir amigo"/></form>';
                break;
		}
		}
        $html.= '</div>';
        return $html;
	}
}
?>