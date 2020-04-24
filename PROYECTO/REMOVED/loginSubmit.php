<?php
require_once __DIR__.'/config.php';

$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$app = es\ucm\fdi\aw\Application::getSingleton();
$conn = $app->bdConnection(); 
$userDAO = new UserDAO($conn);

//OBTENEMOS USUARIO Y CONTRASEÑA DESDE LA BASE DE DATOS
if ($userDAO->userExists($email)) {
    $userId = $userDAO->getId($email);
    $user = $userDAO->getUser($userId);
} 

//ERROR CUANDO EL USUARIO NO ESTÁ REGISTRADO
else {
    $_SESSION["login"] = false;
    $_SESSION["userInDB"] = false;
   
    header("Location: ../login.php");
}

//ERROR CUANDO DEJAMOS EL FORMULARIO EN BLANCO
if($email == "" || $password == ""){
    $_SESSION["login"] = false;
    $_SESSION["userInDB"] = false;
    header("Location: ../login.php");
}

//ERROR CUANDO EXISTE EL USUARIO Y LA CONTRASEÑA ES INCORRECTA
else if($email == $user->getEmail() && $password != $user->getPassword()){
    $_SESSION["login"]= false;
    $_SESSION["userInDB"] = true;
    $_SESSION["correctPass"] = false;
    header("Location: ../login.php");
}

//ACCESO CUANDO EL USUARIO EXISTE Y LA CONTRASEÑA ES CORRECTA
else if($email == $user->getEmail() && $password == $user->getPassword()){
    $_SESSION["login"] = true;
    $_SESSION["userInDB"] = true;
    $_SESSION["correctPass"] = true;
    $_SESSION["userId"] = $user->getUserId();
    header("Location: ../feed.php");
}
?>

