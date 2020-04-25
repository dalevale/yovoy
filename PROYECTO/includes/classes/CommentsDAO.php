<?php
require_once __DIR__.'/../TransferObjects/TOComments.php';
require_once __DIR__.'/DAO.php';
class CommentsDAO extends DAO{

    public function __construct($conn){
        parent::__construct($conn);
	}
   
    public function postComment($event_id, $user_id, $date, $comment){
        $queryValues =  
         "'".$event_id."',"
        ."'".$user_id."',"
        ."'".$date."',"
        ."'".$comment."'";

        $postComment= "INSERT INTO comments (event_id, user_id, date, comment) 
                       VALUES(".$queryValues.")";

        return $this->dbConn->query($postComment);
    }

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

    public function belongsToUser($owner_id){
        return $owner_id == $this->user_id;
    }

    public function deleteComment($id){
        $deleteComment= "DELETE FROM comments WHERE id = '".$id."'";
        return $this->dbConn->query($deleteComment);
    }
}
?>
