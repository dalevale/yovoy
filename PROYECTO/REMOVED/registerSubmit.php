<?php
require_once __DIR__.'/config.php';

//Valores introduciodos por el usuario
$username = $_REQUEST["username"];
$password = $_REQUEST["password"];
$passwordConfirm = $_REQUEST["passwordConfirm"];
$name = $_REQUEST["name"];
$email = $_REQUEST["email"];

//Valores por defecto
$creationDate = date("Y-m-d");
$type = 1;

//ASEGURAMOS QUE LAS CONTRASEÑAS SEAN IGUALES
if($password != $passwordConfirm){
	$_SESSION["regStatus"] = "Las contraseñas no coinciden.";
    $_SESSION["login"] = false;
    $_SESSION["newUser"] = false;
}

else { //INICIAMOS CONEXIÓN CON MYSQL

    $app = es\ucm\fdi\aw\Application::getSingleton();
	$conn = $app->bdConnection(); 

    $userDAO = new UserDAO($conn);

    //$_SESSION["login"] = false;
    $_SESSION["newUser"] = true;
    $_SESSION["username"] = $username;
	
	// Cambiar el valor de $type si se elige la opción de ser usuario premium
	if(isset($_REQUEST["premium"])){
		$type = 2;
	}
	
	// Si hay un foto subido por el usuario
	if (!empty($_FILES["img"]["name"])){
		$targetDir = "/Yovoy/Proyecto/includes/img/usuarios/";
		$imgName = basename($_FILES["img"]["name"]);
		$targetFilePath = $_SERVER["DOCUMENT_ROOT"] . $targetDir . $imgName;
		
		// Mover el foto al directorio de fotos de usuarios
		if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)){
			//Añadir el usuario a la BBDD
			if ($userDAO->registerUser($email, $password, $username, $name, $imgName, $creationDate, $type)) {
				$_SESSION["regStatus"] = "Has sido registrado con éxito.";
			} 
			else {
				$_SESSION["regStatus"] = "El nombre de usuario ya está en uso.";
				echo "Error: " . $conn->error;
			}
		}
		else{
			$_SESSION["regStatus"] = "Error: Se produjo un error al subir su foto";
		}
	}
	// Si no hay foto, se usa default.jpg
	else{
		$imgName = "default.jpg";
		
		//Añadir el usuario a la BBDD
		if ($userDAO->registerUser($email, $password, $username, $name, $imgName, $creationDate, $type)) {
			$_SESSION["regStatus"] = "Has sido registrado con éxito.";
		} 
		else {
			$_SESSION["regStatus"] = "El nombre de usuario ya está en uso.";
			//$_SESSION["login"] = false;
			echo "Error: " . $conn->error;
		}
	}
}

header("Location: /Yovoy/Proyecto/register.php");

?>
