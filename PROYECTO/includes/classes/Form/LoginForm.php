<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class LoginForm extends Form {
    public function __construct() {
        parent::__construct('loginForm');
    }
    
    protected function generateFormFields($data) {
        $email = '';
        if ($data) 
            $email = isset($data['email']) ? $data['email'] : $email;

        $html = <<<EOF
        
        <ul class="tarjeta_gris">
            <li><label>Email</label><input type="email" name="email" id="email" placeholder="Email"/></li>
            <li><label>Contraseña</label><input type="password" id="password" name="password" placeholder="Introduce tu contraseña"/></li>
            <div><input type="image" id="loginSubmit" alt="submit" src="includes/img/boton_LOGIN.png"></div>
        </ul>
        <script type="text/javascript" src="includes/js/validateLogin.js"></script>
EOF;
        return $html;
    }
    

    protected function processForm($data) {
        //Conectamos a BBDD
        $userDAO = new UserDAO();
        $result = array();
        
        //Validación campo email rellenado
        $email = isset($data['email']) ? $data['email'] : null;
        if (empty($email)) 
            $result[] = "El nombre de usuario no puede estar vacío";

        //Validación campo contraseña rellenado
        $password = isset($data['password']) ? $data['password'] : null;
        if (empty($password))
            $result[] = "El password no puede estar vacío.";
        
        //Obtenemos credenciales desde BBDD
        if ($userDAO->userExists($email)) {
            $userId = $userDAO->getId($email);
            $user = $userDAO->getUser($userId);
            if($email == $user->getEmail() && !$user->comparePassword($password)){
                $result[] = "El password no coincide.";
                $_SESSION["login"]= false;
			}
        }
        else{
            //Error cuando el usuario no esta registrado
            $result[] = "El usuario no esta registrado.";
            $_SESSION["login"] = false;
            $_SESSION["userInDB"] = false;
		}
        if (count($result) === 0) {
            /*if ( ! $usuario ) {
                // No se da pistas a un posible atacante
                $result[] = "El usuario o el password no coinciden";
            } else {*/
                $_SESSION['login'] = true;
                $_SESSION["userId"] = $user->getUserId();
                $_SESSION['esAdmin'] = $user->getUserType() == 0 ? true : false;
                $result = 'feed.php';
        }
        return $result;
    }


}