<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
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
        <?php include 'includes/comun/cabecera.php' ?>
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
					//$email = $user->getEmail();
				
					echo "<p>" . $username . "</p>";
					echo "<p>" . $name . "</p>";
					echo "<p>" . $type . "</p>";
					echo "<p>Se unió " . $creationDate . "</p>";
					//echo "<p>" . $email . "</p>"; //no queremos mostrar email
					echo "<p>Mis Eventos:</p>";
			
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

					if($userId == $profileId){
						// botón para editar perfil
						echo  "<input type='image' src='includes/img/boton_EDITAR.png' title='Editar Perfil' onclick='editar();' />";
						//echo  "<input type='button' value='Editar Perfil' onclick='editar();' />";
				
						// botón para cambiar contraseña
						echo  "<input type='image' src='includes/img/boton_NEWPASSW.png' title='Cambiar Contraseña' onclick='contrasena();' />";
						//echo  "<input type='button' value='Cambiar Contraseña' onclick='contrasena();' />";
					}
					else{
						/*//chequear tabla de relacion para opciones de añadir, bloquear, etc..
						//add friend
						$friendStatus = $userDAO->checkStatus($userId, $profileId);
						switch($friendStatus){
							case 0: //PENDING
								echo $friendStatus;
								echo '<p>Pending friend request</p>';
							break;
							case 1: //ACCEPTED
								echo $friendStatus;
								echo '<p>You and '.$name.' are friends!</p>';
							break;
							case 2: //BLOCKED
								echo $friendStatus;
								echo '<p>'.$name.' blocked you!</p>';
							break;
							default:
								echo $friendStatus;
								echo '<form method="POST" action="includes/manageRelation.php"><input type="hidden" name="profileId" value="'.$profileId.'"/>';
								echo '<input type="image" alt="submit" src="includes/img/icono_FRIENDS.png" title="Añadir amigo"/></form>';
							break;
						}*/
						$relMan->manage();
						
					}
					
				
			}
			else{
				echo "<p>Login o registrate para ver esta información.</p>";
			}
		?>
    </div>

    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
