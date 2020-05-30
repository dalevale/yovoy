<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class EditProfileForm extends Form {
    private $userId;
    public function __construct($userId) {
        parent::__construct('editProfileForm');
        $this->userId = $userId;
    }
    
    protected function generateFormFields($data) {
        $userDAO = new UserDAO();
		$userId = $this->userId;
        $user = $userDAO->getUser($userId);
        $name = $user->getName();
		
        $html = <<<EOF
		<ul class="tarjeta_gris">
			<p><li><label>Nombre </label><input type="text" name="name" value="$name"/></li></p>
			<p><label>Foto de usuario</label></p>
			<p>
				<li><input type="radio" name="imgChoice" value="noChange" checked/><label>No cambiar la foto</label></li>
				<li><input type="radio" name="imgChoice" value="upload"/><label>Subir una foto para usar</label><input type="file" accept =".png, .jpg, .jpeg" name="img" /></li>
				<li><input type="radio" name="imgChoice" value="defaultImg"/><label>Cambiar foto a la predeterminada</label></li>
			</p>
			<p><label>Contraseña</label></p>
			<p>
				<li><input type="radio" name="passChoice" value="noChange" checked/><label>No cambiar la contraseña</label></li>
				<li><input type="radio" name="passChoice" value="change"/><label>Cambiar la contraseña</label></li>
			</p>
			<p><li><label>Contraseña actual </label><input class="control" type="password" name="currPass"/></li></p>
			<p><li><label>Confirme contraseña actual </label><input class="control" type="password" name="currPassConfirm"/></li></p>
			<p><li><label>Contraseña nueva </label><input class="control" type="password" name="newPass"/></li></p>
			<p><li><label>Confirme contraseña nueva </label><input class="control" type="password" name="newPassConfirm"/></li></p>
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
    

    protected function processForm($data) {
		//INICIAMOS CONEXIÓN CON MYSQL
		$userDAO = new UserDAO();
		$userId = $this->userId;
		$user = $userDAO->getUser($userId);

        $result = array();
		$name = isset($data['name']) ? htmlspecialchars(trim(strip_tags($data['name']))) : null;
		$changeImg = isset($data['imgChoice']) && $data['imgChoice'] !="noChange";
		$changePass = isset($data['passChoice']) && htmlspecialchars(trim(strip_tags($data['passChoice']))) != "noChange";
		
		if ($changeImg){
			$targetDir = "/Yovoy/Proyecto/includes/img/users/";
			$defaultImgName = "default.jpg"; // Nombre de la foto predeterminada

			// Si la foto anterior no es default.jpg, conseguir su nombre
			$prevImgName = $user->getImgName();

			if ($data['imgChoice'] == "defaultImg")
				$imgName = $defaultImgName;
			else{
				// Si hay una foto subida por el usuario, cambiarlo
				if (!empty($_FILES['img']['name'])){
					$imgName = $userId . ".png";
					
					// Conseguir la dirección en que se guarda la foto subida
					$targetFilePath = $_SERVER['DOCUMENT_ROOT'] . $targetDir . $imgName;
					
					if ($imgName != $defaultImgName){
						// Mover la foto al directorio especificada en $targetDir
						if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath))
							$result[] = "Error: Se produjo un error al subir su foto.";
					}
				}
				else
					$result[] = "Error: No hay ninguna foto subida.";
			}
		}

		if($changePass){
			$currPass = isset($data['currPass']) ? $data['currPass'] : null;
			$currPassConfirm = isset($data['currPassConfirm']) ? $data['currPassConfirm'] : null;
			$newPass = isset($data['newPass']) ? $data['newPass'] : null;
			$newPassConfirm = isset($data['newPassConfirm']) ? $data['newPassConfirm'] : null;

			// Comprobar las contraseñas
			if ($currPass != $currPassConfirm)
				$result[] = "Error: Asegura que las contraseñas actuales sean iguales";
			else if ($newPass != $newPassConfirm)
				$result[] = "Error: Asegura que las contraseñas nuevas sean iguales";
			else if (!$user->comparePassword($currPass))
				$result[] = "Error: Contraseña actual incorrecta";
			else
				$password = $newPass;
		}

        if (count($result) == 0) {
			if(!$changeImg)
				$imgName = $user->getImgName();
			if(!$changePass)
				$password = null;
			
			//Actualizar la BBDD
			if (!$userDAO->updateUser($userId, $password, $name, $imgName))
				$result[] = "Error: Se produjó un error al actualizar la base de datos.";
			else{
				// Si la foto anterior no es default.jpg, borrarla
				if ($changeImg && $prevImgName != $defaultImgName && $imgName == $defaultImgName)
					unlink ($_SERVER['DOCUMENT_ROOT'] . $targetDir . $prevImgName);
				$result='editProfile.php';
			}
        }
        return $result;
    }
}