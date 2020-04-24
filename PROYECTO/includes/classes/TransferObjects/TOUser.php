<?php

class TOUser{
    private $userId = "";
    private $username = "";
    private $password = "";
    private $creationDate = "";
    private $name = "";
    private $email = "";
    private $imgName = "";
    private $type = "";

    public function __construct($userId, $username, $password, $creationDate, $name, $email, $imgName, $type){
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->creationDate = $creationDate;
        $this->name = $name;
		$this->email = $email;
        $this->imgName = $imgName;
        $this->type = $type;
    }

    public function getUserId(){
        return $this->userId;
	}

    public function getUsername(){
        return $this->username;
    }

    public function getCreationDate(){
        return $this->creationDate;
    }

    public function getName(){
        return $this->name;
    }
	
    public function getEmail(){
        return $this->email;
    }

    public function getImgName(){
        return $this->imgName;
    }

    public function getUserType(){
        return $this->type;
    }
	
	public function comparePassword($password){
		return password_verify($password, $this->password);
	}
}   
?>
