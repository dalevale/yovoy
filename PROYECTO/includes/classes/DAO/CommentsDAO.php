<?php
require_once __DIR__.'/../TransferObjects/TOComments.php';
require_once __DIR__.'/DAO.php';

class CommentsDAO extends DAO {
    
    public function __construct(){
        parent::__construct();
	}
   
    /**
    * Funci�n para meter una fila en la tabla de comments en la BBDD
    *
    * @param int $eventId       Id del evento con que el comentario se vincula
    * @param int $userId        Id del usuario con que el comentario se vincula
    * @param Date $date         Fecha de creación del comentario
    * @param string $comment    Cadena de string que pertenece al comentario
    * @return int $result      Devuelve el id del comentario si se ha insertado correctamente en la BBDD
    */
    public function postComment($event_id, $user_id, $date, $comment){
        $queryValues =  
         "'".$event_id."',"
        ."'".$user_id."',"
        ."'".$date."',"
        ."'".$comment."'";

        $postComment= "INSERT INTO comments (event_id, user_id, date, comment) 
                       VALUES(".$queryValues.")";

        return parent::executeInsert($postComment);
    }
    
    /**
    * Funci�n para recoger todos los comentarios vinculados a un event con id $eventId
    *
    * @param int $event_id          Id del evento
    *
    * @return array $commentsArray  Array de objetos TOComments creados con los datos en la BBDD
    */
    public function getComments($event_id){
        $showCommentsQuery = "SELECT * FROM comments WHERE event_id = '".$event_id."'";
       
        $dataArray = parent::executeQuery($showCommentsQuery);
        $data = array_shift($dataArray);

        $commentsArray = array();
        while(!empty($data)) {
            $id = $data["comment_id"];
            $event_id= $data["event_id"];
            $user_id = $data["user_id"];
            $date = $data["date"];
            $comment = $data["comment"];

            array_push($commentsArray, new TOComments($id, $event_id, $user_id, $date, $comment));
            $data = array_shift($dataArray);
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
    *
    * @return int $result   Devuelve el numero total de las filas borradas de la Base de Datos
    */
    public function deleteComment($id){
        $deleteComment= "DELETE FROM comments WHERE comment_id = '".$id."'";
        return parent::executeModification($deleteComment);
    }
}
?>
