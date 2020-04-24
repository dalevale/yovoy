<?php
require_once __DIR__.'/config.php';

//Valores introduciodos por el usuario
$currPass = $_REQUEST["currPass"];
$currPassConfirm = $_REQUEST["currPassConfirm"];
$newPass = $_REQUEST["newPass"];
$newPassConfirm = $_REQUEST["newPassConfirm"];

$userId = $_SESSION["userId"];

//INICIAMOS CONEXIÓN CON MYSQL

$app = es\ucm\fdi\aw\Application::getSingleton();
$conn = $app->bdConnection();

$userDAO = new UserDAO($conn);
$user = $userDAO->getUser($_SESSION["userId"]);

// Comprobar las contraseñas
if ($currPass != $currPassConfirm){
	$_SESSION["changePassStatus"] = "ERROR: Asegura que las contraseñas actuales sean iguales";
}
else if ($newPass != $newPassConfirm){
	$_SESSION["changePassStatus"] = "ERROR: Asegura que las contraseñas nuevas sean iguales";
}
else if ($user->comparePassword($currPass)){
	$_SESSION["changePassStatus"] = "ERROR: Contraseña actual incorrecta";
}

// Actualizar el usuario a la BBDD
else{
	if (!$userDAO->changePassword($userId, $newPass)){
		$_SESSION["changePassStatus"] = "ERROR: Se produjó un error al cambiar su contraseña";
	}
	else{
		$_SESSION["changePassStatus"] = "Has cambiado su contraseña con éxito";
	}
}

header("Location: /Yovoy/Proyecto/changePassword.php");


?>
