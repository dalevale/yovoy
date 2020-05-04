<!DOCTYPE html>

<html>
<head>
    <title>Ver Perfil - YoVoY</title>
	<script>
        function editar(){
            window.location.href = "editProfile.php";
        }
		
		function contrasena(){
            window.location.href = "changePassword.php";
        }
    </script>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div class = "tarjeta_gris">
		<?php
			if(isset($_SESSION["login"]) && $_SESSION["login"]){
				$app = es\ucm\fdi\aw\Application::getSingleton();
				$conn = $app->bdConnection(); 
				$userDAO = new UserDAO($conn);
				
				// obtener usuario
				$profileId = $_GET["profileId"];
				$userId = $_SESSION["userId"];
				$relMan = new RelationManager($conn, $userId, $profileId);
				/*if(isset($_GET["userId"]))
					$userId = $_GET["userId"];*/
					
				
					// conseguir información
					$user = $userDAO->getUser($profileId);
				
					// foto
					$imgDir = "includes/img/users/";
					$imgName = $user->getImgName();
					$imgPath = $imgDir . $imgName;
					echo "<img src='" . $imgPath . "' alt='usuario' height='200' width='200'>";
					if($userId == $profileId){
						// botón para editar perfil
						echo  "<input type='image' src='includes/img/boton_EDITAR.png' title='Editar Perfil' onclick='editar();' />";
						//echo  "<input type='button' value='Editar Perfil' onclick='editar();' />";
				
						// botón para cambiar contraseña
						echo  "<input type='image' src='includes/img/boton_NEWPASSW.png' title='Cambiar Contraseña' onclick='contrasena();' />";
						//echo  "<input type='button' value='Cambiar Contraseña' onclick='contrasena();' />";
					}
					else{
						//chequear tabla de relacion para opciones de añadir, bloquear, etc..
						$relMan->manage();
					}
					// mostrar información
					$username = $user->getUsername();
					$name = $user->getName();
					$type = $user->getUserType();
					if ($type == "0"){
						$type = "Administrador";
					}
					else if ($type == 1){
						$type = "Usuario Regular";
					}
					else{
						$type = "Usuario Premium";
					}
					$creationDate = $user->getCreationDate();
				
					echo "<p>" . $username . "</p>";
					echo "<p>" . $name . "</p>";
					echo "<p>" . $type . "</p>";
					echo "<p>Se unió " . $creationDate . "</p>";
					echo "<h1>Mis Eventos:</h1>";
			
					$createdEvents = $userDAO->getCreatedEvents($profileId);
					if(count($createdEvents) > 0){
						for($i=0; $i < count($createdEvents); $i++){
							$eventId = $createdEvents[$i]->getEventId();
							$eventImgDir = "includes/img/events/";
							$eventImgName =  $createdEvents[$i]->getImgName();
							$eventImgPath = $eventImgDir . $eventImgName;
							echo "<a href= 'eventItem.php?event_id=".$eventId."'>";
							echo "<p><img src='" . $eventImgPath . "' alt='event' height='50' width='50'>";
							echo $createdEvents[$i]->getName();
							echo '</p></a>';
						}
					}
					else {
						echo '<p>Lamentablemente, no tiene eventos de momento.</p>';
					}
					$friends = $userDAO->getFriends($profileId);
					echo '<h1>Mis Amigos</h1>';
					echo '<ul>';
					while(sizeof($friends) > 0){
						echo '<li><ul>';
						$friend = array_pop($friends);
						$imgDir = "includes/img/users/";
						$imgName = $friend->getImgName();
						$imgPath = $imgDir . $imgName;
						echo '<a href="profileView.php?profileId='.$friend->getUserId().'"><li><img src="'.$imgPath.'" width="50px" height="50px"></li>';
						echo '<li>'.$friend->getName().'</li>';
						echo '<li>'.$friend->getUsername().'</li></a>';
						echo '</ul></li>';
					}
					echo '</ul>';
			}
			else{
				echo "<p>Login o registrate para ver esta información.</p>";
			}
		?>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
