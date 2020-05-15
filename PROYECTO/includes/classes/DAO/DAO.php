<?php
class DAO{

    private $conn;

    public function __construct(){
        $app = es\ucm\fdi\aw\Application::getSingleton();
        $this->conn = $app->bdConnection(); 
    }
    
    public function getConnection(){
        return $this->conn;
    }
    
    public function executeQuery($sql){
        if($sql != ""){
            $query = $this->conn->query($sql) or die($this->conn->error. "en la linea ".(__LINE__-1));
            $data = array();

            while($row = $query->fetch_assoc()){
                array_push($data, $row);
            }
            
            return $data;
        }
        else return 0;
    }

    public function executeModification($sql){
        if($sql != ""){
            $query = $this->conn->query($sql) or die($this->conn->error. "en la linea ".(__LINE__-1).": ".$sql);
            return $this->conn->affected_rows;
        }
        //else return 0;
    }

    public function executeInsert($sql){
        if($sql != ""){
           return $this->conn->query($sql) or die($this->conn->error. " en la linea ".(__LINE__-1).": ".$sql);
        }
        else return 0;   
    }

}
?>
