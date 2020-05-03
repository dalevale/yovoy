<?php
require_once __DIR__.'/Form/Form.php';

class RelationManager extends Form {
    //define('USERONEADD', '0');//PENDING
    /*define("USERTWOADD", 1);
    define("USERONEACCEPT", 2);//ACCEPTED
    define("USERTWOACCEPT", 3);
    define("USERONEBLOCK", 4);//BLOCKED
    define("USERTWOBLOCK", 5);
    define("USERONEUNFR", 6);//UNFRIEND
    define("USERTWOUNFR", 7);
    define("USERONEUNBL", 8);//UNBLOCK
    define("USERTWOUNBL", 9);*/

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


    //first check status
    //print buttons
    //process
    /*public function manage($userOneId, $userTwoId){
        $status = $this->relationStatus($userOneId, $userTwoId);
        echo $this->printHTML($status, $userTwoId);
	}
        public function manage()
    {   
        $this->status = $this->relationStatus($this->userOneId, $this->userTwoId);
        if ( ! $this->formSent($_POST) ) {
            echo $this->generateForm();
        } else {
            $result = $this->processForm($_POST);
            if ( is_array($result) ) {
                echo $this->generateForm($result, $_POST);
            } else {
                header('Location: '.$result);
                exit();
            }
        }  
    }*/

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

    private function insertRow($userOneId, $userTwoId, $status, $action_user_id){
        $queryValues =  
                "'".min($userOneId, $userTwoId)."',"
			    ."'".max($userOneId, $userTwoId)."',"
                ."".$status.","
                ."'".$userOneId."'";
        $query = "INSERT INTO relationship (user_one_id, user_two_id, status, action_user_id) VALUES (".$queryValues.")";
        $this->dbConn->query($query);
	}

    private function deleteRow($userOneId, $userTwoId){
        $query = "DELETE FROM relationship WHERE user_one_id = '".min($userOneId, $userTwoId)."' AND user_two_id = '".max($userOneId, $userTwoId)."';";
        $this->dbConn->query($query);
	}
}
?>