<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class EditProfileForm extends Form
{
    private $userId;
    public function __construct($eventId) {
        parent::__construct('editProfileForm');
        $this->userId = $userId;
    }
    
    protected function generateFormFields($data)
    {
		$userId = $this->userId;
        $app = es\ucm\fdi\aw\Application::getSingleton();
        $conn = $app->bdConnection();
        $userDAO = new UserDAO($conn);
        $user = $userDAO->getUser($userId);
        $username = $user->getUsername();
        $name = $user->getName();
        $imgName = $user->getImgName();
		
        $html = <<<EOF
		<ul class="tarjeta_gris">
			<li>
				<label>
					Nombre
				</label>
				<input type="text" name="name" value="$name" required/>
			</li>
			<li>
				<label>
					Foto
				</label>
				<input type="file" accept =".png, .jpg, .jpeg" name="img"/>
			</li>
			<li>
				<label>
					Cambiar foto a la predeterminada
				</label>
				<input type="checkbox" name="defaultImg" value="defaultImg">
			</li>
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
		
        $result = array();
        
        $name = isset($data['name']) ? $data['name'] : null;
		
		$defaultImgName = "default.jpg"; // Nombre de la foto predeterminada
		$imgName = $defaultImgName;
		
		$changeName = !empty($name);
		$changeImg = !empty($_FILES['img']['name']) || isset($data['defaultImg']);
        
		// Si hay un nombre como entrada, cambiar el nombre del usuario
        if ( $changeName ) {
			if ( mb_strlen($name) < 5 ){ 
				$result[] = "El nombre tiene que tener una longitud de al menos 5 caracteres. ";
			}
			else{
				
			}
        }
		
		// Si hay una foto subida por el usuario, cambiarlo
		if ( $changeImg ){
			$targetDir = "/Yovoy/Proyecto/includes/img/users/";
			$imgName = basename($_FILES['img']['name']);
			
			// Si no hay foto subido y la casilla de elegir la foto predeterminada está activo, cambiar el valor de $imgName
			if (empty($_FILES['img']['name']) && isset($data['defaultImg'])){
				$imgName = $defaultImgName;
			}
			
			// Conseguir la dirección en que se guarda la foto subida
			$targetFilePath = $_SERVER['DOCUMENT_ROOT'] . $targetDir . $imgName;
			
			// Si la foto anterior no es default.jpg, borrarla
			$currImgName = $user->getImgName();
			if ($currImgName != $defaultImgName){
				unlink ($_SERVER['DOCUMENT_ROOT'] . $targetDir . $currImgName);
			}
			
			if ($imgName != $defaultImgName){
				// Mover la foto al directorio especificada en $targetDir
				if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)){
					$result[] .= "Error: Se produjo un error al subir su foto.";
				}
			}
			
		}

        if (count($result) == 0) {

            //INICIAMOS CONEXI�N CON MYSQL

			$app = es\ucm\fdi\aw\Application::getSingleton();
			$conn = $app->bdConnection(); 

			$userDAO = new UserDAO($conn);
			
			//Actualizar la BBDD
			if ($changeName && !$userDAO->changeName($username, $name)){
				$result[] = "Error: Se produjó un error al actualizar la base de datos.";
			}
			
			if ($changeImg && !$userDAO->changeImg($userID, $imgName)){
				$result[] .= "Error: Se produjó un error al actualizar la base de datos. ";
			}
			
        }
        return $result;
    }
}