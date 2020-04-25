<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class DeleteCommentForm extends Form
{
    public function __construct() {
        parent::__construct('deleteCommentsForm');
    }
    
    protected function generateFormFields($data)
    {
        $html = <<<EOF
        <button type="submit" onclick="return confirm('¿Quieres borrar este comentario?')";>Borrar comentario</button>
    
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        //Conectamos a BBDD

        $app = es\ucm\fdi\aw\Application::getSingleton();
        $conn = $app->bdConnection(); 
        $commentsDAO = new CommentsDAO($conn);
        $result = array();
 
        $commentsDAO->deleteComment($_SESSION["comment_id"]);
    
        if (count($result) === 0) {
            $result = '/eventItem.php?event_id='.$_SESSION["event_id"];
        }
        return $result;
    }
}