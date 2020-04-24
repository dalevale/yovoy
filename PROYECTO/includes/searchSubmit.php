<?php
require_once __DIR__.'/config.php';

//Valores introducidos por el creador del evento
$search = $_REQUEST["search"];

//Conexion con BBDD
	$app = es\ucm\fdi\aw\Application::getSingleton();
	$conn = $app->bdConnection(); 
	$_SESSION["noBlanksEvent"] = true;
	//Con nombre, etiquetas y usuarios
	//$eventQuery ="SELECT * FROM event WHERE name=".$search."";
	//$eventQuery2 ="SELECT * FROM event WHERE creator=".$search."";
	//$eventQuery3 ="SELECT * FROM event WHERE hashtags=".$search.""; //Falta añadir ese campo
	

?>