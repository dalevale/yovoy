<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class UploadAuxImgForm extends Form
{
    private $eventId;
    public function __construct($eventId) {
        parent::__construct('uploadAuxImgForm');
        $this->eventId = $eventId;
    }
    
    protected function generateFormFields($data)
    {
		$eventId = $this->eventId;
		
        $html = <<<EOF
		<ul class="tarjeta_gris">
			<p><label>Foto de usuario</label></p>
			<p>
				<li><label>Subir una foto para usar</label><input type="file" accept =".png, .jpg, .jpeg" name="img" /></li>
			</p>
			<div>
				<input type="image" name="submit" title="Confirmar" alt="submit" src="includes/img/boton_OK.png">
				<input type="image" name="reset" title="Cancelar" alt="cancelar" src="includes/img/boton_CANCELAR.png">
			</div>
		<!--  <li><input type="submit" value="Registrarse"/></li>
			<li><input type="reset" value="Borrar Campos"></li> !-->
		</ul>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        //INICIAMOS CONEXIÓN CON MYSQL
        $auxImgDAO = new AuxImgDAO();

        $eventId = $this->eventId;
        $result = array();

        //Directorio de fotos auxiliares
        $targetDir = "/Yovoy/Proyecto/includes/img/events_aux/";

        if (empty($_FILES['img']['name'])){
            $result[] = "Error: No hay ninguna foto subida.";
        }
        else{
            //Llamar el DAO para conseguir el nombre de foto subida
            $imgName = $auxImgDAO->getNextImgName($eventId);

            // Conseguir la dirección en que se guarda la foto subida
            $targetFilePath = $_SERVER['DOCUMENT_ROOT'] . $targetDir . $imgName;

            // Mover la foto al directorio especificada en $targetDir
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)){
                $result[] = "Error: Se produjo un error al subir su foto.";
            }
        }

        if (count($result) == 0) {			
			//Actualizar la BBDD
			if ($auxImgDAO->addImg($eventId) === FALSE){
				$result[] = "Error: Se produjó un error al actualizar la base de datos.";
			}
			else{
				$result='manageAuxImg.php';
			}
        }
        return $result;
    }
}