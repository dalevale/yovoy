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
            $ret = $this->conn->query($sql) or die($this->conn->error. "en la linea ".(__LINE__-1).": ". $sql);
            return $ret;
        }
        else return 0;
    }

    public function executeInsert($sql){
        if($sql != ""){
           if($this->conn->query($sql) === TRUE)
               $ret = $this->conn->insert_id;
            else
               $ret = die($this->conn->error. " en la linea ".(__LINE__-1).": ". $sql);
        }
        return $ret;  
    }

}
?>
