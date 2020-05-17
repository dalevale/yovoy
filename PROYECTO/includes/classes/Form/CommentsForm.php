<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class CommentsForm extends Form
{
    public function __construct() {
        parent::__construct('commentsForm');
    }
    
    protected function generateFormFields($data)
    {
        //echo $data["postComment"];
        $comment = '';
        if ($data) {
            $comment = isset($data['comment']) ? $data['comment'] : $comment;
        }
       
        $html = <<<EOF
        <label>Escribe un comentario: </label>
        
        <div class="tarjeta_gris">
        <div><textarea style="resize: none" required name="comment" maxlength="240" placeholder="Di lo que piensas..." rows="5" cols="50"/></textarea></div>
        <div><button type="submit">Enviar comentario</button></div>
        </div>
       
EOF;

        return $html;
    }
    

    protected function processForm($data)
    {
        //Conectamos a BBDD

        $commentsDAO = new CommentsDAO();
        $notificationsDAO = new NotificationsDAO();
        $eventDAO = new EventDAO();
        $event = $eventDAO->getEvent($_SESSION["event_id"]);
        $ownerId = $event->getCreator();

        $result = array();
       
        $comment = isset($data['comment']) ? $data['comment'] : null;
        
        if (!isset($_SESSION["login"])) {
            $result[] = "No eres un usuario registrado";
        }

        else if ( empty($comment) && isset($_SESSION["login"]) && $_SESSION["login"]) {
            $result[] = "¡Tienes que escribir algo!";
        }
        else{
            if(isset($_SESSION["userId"]) && $_SESSION["userId"]){
                $commentsDAO->postComment($_SESSION["event_id"],$_SESSION["userId"], date("Y-m-d"), $comment);

                if($_SESSION["userId"] != $ownerId)
                    $notificationsDAO->notify(NotificationsDAO::NEW_COMMENT, $ownerId, $_SESSION["userId"], $_SESSION["event_id"]);
            }
        }
        
        if (count($result) === 0)
            $result = 'eventItem.php?event_id='.$_SESSION["event_id"];
        
        
        return $result;
    }
}
