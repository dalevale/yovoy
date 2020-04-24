<?php
require_once __DIR__.'/config.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

//Valores introduciodos por el usuario
$name = $_REQUEST["name"];

$userID = $_SESSION["userId"];

// NOTA: Todos los campos del formulario son opcionales

//INICIAMOS CONEXIÓN CON MYSQL

$app = es\ucm\fdi\aw\Application::getSingleton();
$conn = $app->bdConnection();

$userDAO = new UserDAO($conn);
$user = $userDAO->getUser($userID);
$_SESSION["editProfileStatus"] = "";

// Si hay un nombre como entrada, cambiar el nombre del usuario
if ($name != ""){
	// Actualizar el usuario en la BBDD
	if (!$userDAO->changeName($username, $name) === true){
		$_SESSION["editProfileStatus"] = "ERROR: Se produjó un error al actualizar la base de datos. ";
	}
	else{
		$_SESSION["editProfileStatus"] = "Has cambiado su nombre con éxito. ";
	}
}

// Si hay una foto subida por el usuario, cambiarlo
if (!empty($_FILES["img"]["name"]) || isset($_REQUEST["defaultImg"])){
	$defaultImgName = "default.jpg"; // Nombre de la foto predeterminada
	
	$targetDir = "/Yovoy/Proyecto/includes/img/usuarios/";
	$imgName = basename($_FILES["img"]["name"]);
	
	// Si no hay foto subido y la casilla de elegir la foto predeterminada está activo, cambiar el valor de $imgName
	if (empty($_FILES["img"]["name"]) && isset($_REQUEST["defaultImg"])){
		$imgName = $defaultImgName;
	}
	
	// Conseguir la dirección en que se guarda la foto subida
	$targetFilePath = $_SERVER["DOCUMENT_ROOT"] . $targetDir . $imgName;
	
	// Si la foto anterior no es default.jpg, borrarla
	$currImgName = $user->getImgName();
	if ($currImgName != $defaultImgName){
		unlink ($_SERVER["DOCUMENT_ROOT"] . $targetDir . $currImgName);
	}
	
	if ($imgName != $defaultImgName){
		// Mover la foto al directorio especificada en $targetDir
		if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)){
			//Actualizar la BBDD
			if (!$userDAO->changeImg($userID, $imgName)){
				$_SESSION["editProfileStatus"] .= "ERROR: Se produjó un error al actualizar la base de datos.";
			}
			else{
				$_SESSION["editProfileStatus"] .= "Has cambiado su foto con éxito.";
			}	
		}
		else{
			$_SESSION["editProfileStatus"] .= "ERROR: Se produjo un error al subir su foto.";
		}
	}
	// Si el foto se va a fijar a la foto por defecto, actualizar la BBDD
	else{
		if (!$userDAO->changeImg($userID, $imgName)){
			$_SESSION["editProfileStatus"] .= "ERROR: Se produjó un error al actualizar la base de datos.";
		}
		else{
			$_SESSION["editProfileStatus"] .= "Has cambiado su foto con éxito.";
		}	
	}
}

header("Location: /Yovoy/Proyecto/editProfile.php");

?>
