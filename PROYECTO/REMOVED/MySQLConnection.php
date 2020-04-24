<?php

class MySQLConnection{
    //Ajustar según la configuracion de la BBDD que tengais en vuestro equipo

    private $conn= "";
    
    public function __construct(){
        $DBServername="localhost";
        $DBUsername="root";
        $DBPassword="";
        $DBName="yovoy_DB";
        
        $this->conn = new mysqli($DBServername, $DBUsername, $DBPassword, $DBName);

        if($this->conn -> connect_error){
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function connect(){
        return $this->conn;
    }

    public function __destruct(){
        $this->conn -> close();
    }
}
?>