<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class LoginForm extends Form
{
    public function __construct() {
        parent::__construct('loginForm');
    }
    
    protected function generateFormFields($data)
    {
        $email = '';
        if ($data) {
            $email = isset($data['email']) ? $data['email'] : $email;
        }
        $html = <<<EOF
        <ul class="tarjeta_gris">
            <li><label>Email</label><input type="text" name="email" value="email"/></li>
            <li><label>Contraseña</label><input type="password" name="password"/></li>
            <li><input type="image" alt="submit" src="includes/img/boton_LOGIN.png"></li>
            <!--<li><input type="submit" value="Login" ></li>
            <button type="submit" name="login">Entrar</button>-->
        </ul>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        //Conectamos a BBDD
            
        $app = es\ucm\fdi\aw\Application::getSingleton();
        $conn = $app->bdConnection(); 
        $userDAO = new UserDAO($conn);
        $result = array();
        
        $email = isset($data['email']) ? $data['email'] : null;
                
        if ( empty($email) ) {
            $result[] = "El nombre de usuario no puede estar vacío";
        }
        
        $password = isset($data['password']) ? $data['password'] : null;
        if ( empty($password) ) {
            $result[] = "El password no puede estar vacío.";
        }
        
        //OBTENEMOS USUARIO Y CONTRASEÑA DESDE LA BASE DE DATOS
        if ($userDAO->userExists($email)) {
            $userId = $userDAO->getId($email);
            $user = $userDAO->getUser($userId);
            if($email == $user->getEmail() && !$user->comparePassword($password)){
                $result[] = "El password no coincide.";
                $_SESSION["login"]= false;
			}
        }
        else{
            //ERROR CUANDO EL USUARIO NO ESTÁ REGISTRADO
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
                //$_SESSION['esAdmin'] = strcmp($usuario->rol(), 'admin') == 0 ? true : false;
                $result = 'feed.php';
            
        }
        return $result;
    }
}