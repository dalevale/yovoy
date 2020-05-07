<?php 
require_once __DIR__.'/../config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
</head>
    <body>
    <div id="cabecera">   
		<div id="navbar">
			<ul>
				<!--logo aquí-->
				<!--<li><a href='index.html'>INICIO</a></li>-->
				<li><a href='feed.php'>FEED</a></li>
				<li><a href='events.php'>EVENTOS</a></li>
				<li><a href='search.php'>BUSCAR</a></li>
				<li><a href='calendar.php'>CALENDARIO</a></li>
				<?php	
				if(isset($_SESSION["login"]) && $_SESSION["login"]){
					$app = es\ucm\fdi\aw\Application::getSingleton();
					$conn = $app->bdConnection(); 
					$userDAO = new UserDAO($conn);
					$eventDAO = new EventDAO($conn);
				
					$createdEvents = $userDAO->getCreatedEvents($_SESSION["userId"]);
					
					//contamos numero de peticiones
					$requests=0;
					for($i=0; $i < count($createdEvents); $i++){
						$eventId = $createdEvents[$i]->getEventId();
						$attendeesList = $eventDAO->getAttendees($eventId,false);
					
						$requests += sizeof($attendeesList);
					}

					$friendRequests = $userDAO->getFriendRequests($_SESSION["userId"]);
					$requests += sizeof($friendRequests);
					
					echo "<li><a href='friends.php'>MIS AMIGOS</a></li>";
					echo "<li><a href='profileView.php?profileId=". $_SESSION["userId"] ."'>MI ÁREA</a></li>";
					echo "<li><a href='notifications.php'>NOTIFICACIONES ($requests)</a></li>";
				}
				?>
			</ul>
		
			<div id="usuario">
				<?php
					if((isset($_SESSION["login"]) && !$_SESSION["login"]) || !isset($_SESSION["login"])){
						echo "<ul>";
						echo "<li><a href='register.php'>REGISTRARSE</a></li>";
						echo "<li><a href='login.php'>LOGIN</a></li>";
						echo "</ul>";
					}
					else{
						//foto si hay
						if($_SESSION["login"]){
							$app = es\ucm\fdi\aw\Application::getSingleton();
							$conn = $app->bdConnection(); 
							$userDAO = new UserDAO($conn);
						
							$user = $userDAO->getUser($_SESSION["userId"]);
							$imgDir = "includes/img/users/";
							$imgName = $user->getImgName();
							$imgPath = $imgDir . $imgName;
							$name = $user->getName();
						
							echo "<img src='" . $imgPath . "' alt='usuario' height='50' width='50'>";
							echo "<p>Hola, " . $name . "!</p>";
							echo "<a href='includes/logout.php'><input type='image' name='button' src='includes/img/boton_LOGOUT.png'></a>";
					
							//MENSAJE QUE SE MUESTRA A NUEVOS USUARIOS
							//if(isset($_SESSION["newUser"]) && $_SESSION["newUser"]){
							//	echo "<h1>AHORA ERES UN USUARIO REGISTRADO!</h1>";
							//}   
						}
					}
				?>
			</div>
		</div>
		<div id="usuarioPic">
		</div>
    </div>
    </body>
</html>
