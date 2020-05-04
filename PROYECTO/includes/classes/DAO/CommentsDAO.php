<?php
require_once __DIR__.'/../TransferObjects/TOComments.php';
require_once __DIR__.'/DAO.php';
class CommentsDAO extends DAO{
    
    public function __construct($conn){
        parent::__construct($conn);
	}
   
    /**
    * Función para meter una fila en la tabla de comments en la BBDD
    *
    * @param int $eventId       Id del evento con que el comentario se vincula
    * @param int $userId        Id del usuario con que el comentario se vincula
    * @param Date $date         Fecha de creación del comentario
    * @param string $comment    Cadena de string que pertenece al comentario
    * @return bool $result      Devuelve true si se ha insertado correctamente en la BBDD
    */
    public function postComment($event_id, $user_id, $date, $comment){
        $queryValues =  
         "'".$event_id."',"
        ."'".$user_id."',"
        ."'".$date."',"
        ."'".$comment."'";

        $postComment= "INSERT INTO comments (event_id, user_id, date, comment) 
                       VALUES(".$queryValues.")";
        $result = $this->dbConn->query($postComment);
        return $result;
    }
    
    /**
    * Función para recoger todos los comentarios vinculados a un event con id $eventId
    *
    * @param int $event_id          Id del evento
    * @return array $commentsArray  Array de objetos TOComments creados con los datos en la BBDD
    */
    public function getComments($event_id){
        $showCommentsQuery = "SELECT * FROM comments WHERE event_id = '".$event_id."'";
        $result = $this->dbConn->query($showCommentsQuery);

        $commentsArray = array();
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $event_id= $row["event_id"];
            $user_id = $row["user_id"];
            $date = $row["date"];
            $comment = $row["comment"];

            array_push($commentsArray, new TOComments($id, $event_id, $user_id, $date, $comment));
        }

        return $commentsArray;
    }

    /**
    *
    */
    public function belongsToUser($owner_id){
        return $owner_id == $this->user_id;
    }

    /**
    * Eliminar un comentario con id $id
    *
    * @param int $id        Id del comentario
    * @return bool result   Devuelve true si se ha eliminado correctamente la fila en la BBDD
    */
    public function deleteComment($id){
        $deleteComment= "DELETE FROM comments WHERE id = '".$id."'";
        return $this->dbConn->query($deleteComment);
    }
}
?>
