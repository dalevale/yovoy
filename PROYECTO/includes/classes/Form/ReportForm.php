<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class ReportForm extends Form {
    public function __construct() {
        parent::__construct('reportForm');
    }
    
    protected function generateFormFields($data) {
        if ($data) {
        }
        $_SESSION["reportUserId"] = isset($_GET["userId"]) ? $_GET["userId"] : null;
        $_SESSION["reportEventId"] = isset($_GET["eventId"]) ? $_GET["eventId"] : null;
            
        $html = <<<EOF
        <div class = "tarjeta_gris">	
				<p> <label for="report">Descripción del report:</label> </p>
                <p> <textarea maxlength="150" rows="9" cols="70" name="report" placeholder="Escribe aquí"></textarea> </p>
                
                <input type="image" name="submit" alt="submit" title="Reportar" src='includes/img/boton_REPORTAR.png'>
                <input type="image" id="reportFormReset" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
                <input type="image" id="reportFormCancel" alt="text" title="Cancelar" src='includes/img/boton_CANCELAR.png'>
	    </div>
EOF;
        return $html;
    }
    
    protected function processForm($data) {
        $result = array();
        $success = false;

        $reportText = isset($data['report']) ? $data['report'] : null;
        if (empty($reportText))
            $result[] = "El mensaje no puede estar vacio!";

        if (count($result) === 0) {
            //Conectamos a BBDD
            
            $reportDAO = new ReportDAO();
            $userId = $_SESSION["userId"];
               
            if(isset($_SESSION["reportUserId"])){
                $objType = ReportDAO::USER;
                $objUserId = $_SESSION["reportUserId"];
                $objEventId = 'null';
                $return =  "profileView.php?userId=".$objUserId;
		    }
            else if(isset($_SESSION["reportEventId"])){
                $objType = ReportDAO::EVENT;
                $objEventId = $_SESSION["reportEventId"];
                $objUserId = 'null';
                $return = "eventItem.php?eventId=".$objEventId;
		    }

            $result = array();
	        if ($reportDAO->addReport($userId, $objType, $objUserId, $objEventId, ReportDAO::UNRESOLVED, $reportText) == false) 
                $success = true;
            else 
                $result[] = "Ha habido un error. Consulta el admin.";
        }
        if ($success)
            $result = "feed.php";

        return $result;
    }
}