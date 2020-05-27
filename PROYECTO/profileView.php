<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>

<html>
<head>
	<!-- FOR BOOTSTRAP POSITIONING -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- -->
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
	
    <div class = "container-fluid miarea">
	<div class = "row justify-content-center">  
		<?php
			if(isset($_SESSION["login"]) && $_SESSION["login"]){
				$userDAO = new UserDAO();
				
				// obtener usuario
				if(isset($_GET["profileId"]))
					$profileId = $_GET["profileId"];
					//$profileId = $_GET["profileId"];
					$userId = $_SESSION["userId"];
					
				
					// conseguir información
					$user = $userDAO->getUser($profileId);
					echo "<div class = 'col-md-2 col-12 datos_miarea'>";
					// foto
					$imgDir = "includes/img/users/";
					$imgName = basename($user->getImgName());
					$imgPath = $imgDir . $imgName;
					echo "<img src='" . $imgPath . "?random=" . rand(0, 100000) . "' alt='usuario' height='100%' width='100%'>";
					
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
					
					echo "<div>";
					if($userId == $profileId  || (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"])){
						// botón para editar perfil
						echo '<span class="editSpan">'; 
						echo  "<input type='image' width='80%' height='80%' src='includes/img/boton_EDITAR.png' title='Editar Perfil' onclick='editar();' />";
						echo '</span>';

						if(isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"]){
							echo '<span class="editSpan">';
							echo '<form method="POST" action="includes/deleteUser.php"><input type="hidden" name="userId" value="'.$profileId.'"/>';
							echo '<input type="image" width="20%" height="20%" alt="Eliminar" src="includes/img/boton_CANCELAR.png" title="Eliminar" name="Submit" id="frm1_submit" /></form>';
							echo '</span>';
						}

					}
					else{
						//chequear tabla de relacion para opciones de añadir, bloquear, etc..
						$relMan = new RelationManager($userId, $profileId);
						echo $relMan->printButtons();
					}
					echo "</div>";
					
					
					
					echo "</div>";
					
					echo "<div class = 'col-md-2 col-12 tarjeta_naranja'>";
					echo "<h2>Mis Eventos:</h2>";
			
					$createdEvents = $userDAO->getCreatedEvents($profileId);
					if(count($createdEvents) > 0){
						for($i=0; $i < count($createdEvents); $i++){
							$eventId = $createdEvents[$i]->getEventId();
							$eventImgDir = "includes/img/events/";
							$eventImgName =  $createdEvents[$i]->getImgName();
							$eventImgPath = $eventImgDir . $eventImgName;
							echo "<a href= 'eventItem.php?eventId=".$eventId."'>";
							echo "<p><img src='" . $eventImgPath . "' alt='event' height='50' width='50'>";
							echo $createdEvents[$i]->getName();
							echo '</p></a>';
						}
					}
					else {
						echo '<p>Lamentablemente, no tiene eventos de momento.</p>';
					}
					echo "</div>";

					$friends = $userDAO->getFriends($profileId);
					echo "<div class = 'col-md-2 col-12 tarjeta_naranja'>";
					echo '<h2>Mis Amigos: </h2>';
					echo '<ul>';
					while(sizeof($friends) > 0){
						echo '<li><ul>';
						$friend = array_pop($friends);
						$imgDir = "includes/img/users/";
						$imgName = $friend->getImgName();
						$imgPath = $imgDir . $imgName;
						echo '<a class= "tarjeta_blanca" href="profileView.php?profileId='.$friend->getUserId().'"><li><img src="'.$imgPath.'" width="50px" height="50px"></li>';
						echo '<li>'.$friend->getName().'</li>';
						echo '<li>'.$friend->getUsername().'</li></a>';
						echo '</ul></li>';
					}
					echo '</ul>';
					echo "</div>";
					
					echo "<div class = 'col-md-2 col-12 tarjeta_naranja'>";
					echo '<h2>Eventos Promocionados: </h2>';
					$promotedEvents = $userDAO->getPromotedEvents($profileId);
					if(count($promotedEvents) > 0){
					for($i=0; $i < count($promotedEvents); $i++){
							$eventId = $promotedEvents[$i]->getEventId();
							$eventImgDir = "includes/img/events/";
							$eventImgName =  $promotedEvents[$i]->getImgName();
							$eventImgPath = $eventImgDir . $eventImgName;
							echo "<a href= 'eventItem.php?eventId=".$eventId."'>";
							echo "<p><img src='" . $eventImgPath . "' alt='event' height='50' width='50'>";
							echo $promotedEvents[$i]->getName();
							echo '</p></a>';
						}
					}
					echo "</div>";
			}
			else{
				echo "<p>Login o registrate para ver esta información.</p>";
			}
		?>
    </div>
	</div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
