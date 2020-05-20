<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class RegisterForm extends Form
{
    public function __construct() {
        parent::__construct('registerForm');
    }
    
    protected function generateFormFields($data)
    {
        $username = '';
        $name = '';
        if ($data) {
            $username = isset($data['username']) ? $data['username'] : $username;
            $name = isset($data['name']) ? $data['name'] : $name;
        }
        $html = <<<EOF
		<ul class="tarjeta_gris">
			<li class="grupo-control">
				<label>Nombre de usuario: </label><span class="formPatron">(letras minúsculas y numeros, de 5 a 20 carácteres sin espacios blancos)</span> 
				<input class="control" type="text" name="username" value="$username"/>
			</li>
			<div class="grupo-control">
				<label>Nombre completo:</label> <input class="control" type="text" name="name" value="$name" />
			</li>
			<li class="grupo-control">
				<label>Contraseña:</label> <input class="control" type="password" name="password"/>
			</li>
            <li class="grupo-control">
				<label>Confirme contraseña:</label> <input class="control" type="password" name="passwordConfirm"/>
			</li>
            <li class="grupo-control">
				<label>Email:</label> <input class="control" type="text" name="email"/>
			</li>
            <li class="grupo-control">
				<label>Foto:</label> <input class="control" type="file" accept =".png, .jpg, .jpeg" name="img" />
			</li>
			</div>
            <div class="grupo-control">
				<label>Registrarse como Usuario Premium</label> <input class="control" type="checkbox" name="premium" value="premium"/>
			</div>
            <div class="grupo-control">
				<input type="image" alt="submit" src="includes/img/boton_REGISTER.png">
				<input type="image" id="registerReset" alt="reset" src="includes/img/boton_CANCELAR.png">
			</div>
              <!--<<li><input type="submit" value="Registrarse"/></li>
				<li><input type="reset" value="Borrar Campos"></li> -->
		</ul>
        <script type="text/javascript" src="includes/js/validateRegister.js"></script>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
		
		$result = array();
		$success = false;
        
        $username = isset($data['username']) ? $data['username'] : null;
		$password = isset($data['password']) ? $data['password'] : null;
        
        if ( empty($username) || mb_strlen($username) < 5 ) {
            $result[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres. ";
        }
        
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $result[] = "La contraseña tiene que tener una longitud de al menos 5 caracteres. ";
        }
        
		$name = isset($data['name']) ? $data['name'] : null;
        if ( empty($name) || mb_strlen($name) < 5 ) {
            $result[] = "El nombre tiene que tener una longitud de al menos 5 caracteres. ";
        }
        
		$email = isset($data['email']) ? $data['email'] : null;
        if ( empty($email) || mb_strlen($email) < 5 ) {
            $result[] = "El email tiene que ser valido. ";
        }
       
	    $passwordConfirm = isset($data['passwordConfirm']) ? $data['passwordConfirm'] : null;
        if ( empty($passwordConfirm) || strcmp($password, $passwordConfirm) !== 0 ) {
            $result[] = "Los passwords deben coincidir. ";
        }
		
		// Si no hay un foto subido por el usuario, se usa default.jpg
		$imgName = "default.jpg";

        if (count($result) == 0) {

			//Valores por defecto
			$creationDate = date("Y-m-d");
			$type = 1;

            //INICIAMOS CONEXIÓN CON MYSQL
			$userDAO = new UserDAO();
			
			//$_SESSION["login"] = false;
			$_SESSION["newUser"] = true;
			$_SESSION["username"] = $username;
	
			// Cambiar el valor de $type si se elige la opción de ser usuario premium
			if(isset($_REQUEST["premium"])){
				$type = 2;
			}
			//Añadir el usuario a la BBDD
			if ($userDAO->registerUser($email, $password, $username, $name, $imgName, $creationDate, $type)) {
				$success = true;
			}
			else{
				$result[] = "Error en registrarse.";
			}
		}
		
		if (count($result) == 0 && !empty($_FILES["img"]["name"])){
			//Conseguir id de usuario
			$userId = $userDAO->getId($email);

			$targetDir = "/Yovoy/Proyecto/includes/img/users/";
			$imgName = $userId . ".png";
			$targetFilePath = $_SERVER["DOCUMENT_ROOT"] . $targetDir . $imgName;
		
			// Mover el foto al directorio de fotos de usuarios
			if (!move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)){
				$result[] = "Error: Se produjo un error al subir su foto. ";
			}
			else{
				if($userDAO->updateUser($userId, null, $name, $imgName)){
					$success = true;
				}
				else{
					$result[] = "Error: Se produjo un error al subir su foto. ";
				}
			}
		}

		if ($success){
			$result = "register.php";
		}

        return $result;
    }
}