<?php 
    require_once __DIR__.'/includes/config.php';

	//DAO´s
	$userDAO = new UserDAO();

    //Condiciones necesarias para ver el contenido
	$loggedIn = isset($_SESSION["login"]) && $_SESSION["login"];
	$adminLoggedIn = (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"]);
	
    //Directorios de las imagenes
	$userImgDir = "includes/img/users/";
	$eventImgDir = "includes/img/events/";

	if(isset($_GET["profileId"]))
		$profileId = $_GET["profileId"];
	$userId = $_SESSION["userId"];
	
	//Lista de los eventos creados y promocionados y lista de los amigos
	$createdEvents = $userDAO->getCreatedEvents($profileId);
	$promotedEvents = $userDAO->getPromotedEvents($profileId);
	$friends = $userDAO->getFriends($profileId);

?>

<!DOCTYPE html>
<html>
<head>
	<!-- FOR BOOTSTRAP POSITIONING -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
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
			if($loggedIn){
				$user = $userDAO->getUser($profileId);
				$imgName = basename($user->getImgName());
				$imgPath = $userImgDir . $imgName;$username = $user->getUsername();
				$name = $user->getName();
				$type = $user->getUserType();
				$creationDate = $user->getCreationDate();

				echo "<div class = 'col-md-2 col-12 datos_miarea'>";
				echo "<img src='" . $imgPath . "?random=" . rand(0, 100000) . "' alt='usuario' height='100%' width='100%'>";
					
				if ($type == "0")
					$type = "Administrador";
				else if ($type == 1)
					$type = "Usuario Regular";
				else
					$type = "Usuario Premium";

				echo "<p>" . $username . "</p>";
				echo "<p>" . $name . "</p>";
				echo "<p>" . $type . "</p>";
				echo "<p>Se unió " . $creationDate . "</p>";
					
				echo "<div>";
				if($userId == $profileId  || $adminLoggedIn){
					// botón para editar perfil
					echo '<span class="editSpan">'; 
					echo  "<input type='image' width='80%' height='80%' src='includes/img/boton_EDITAR.png' title='Editar Perfil' onclick='editar();' />";
					echo '</span>';

					if($adminLoggedIn){
						echo '<span class="editSpan">';
						echo '<input type="image" id="deleteUserBtn" width="80%" height="80%" alt="Eliminar" src="includes/img/boton_CANCELAR.png" title="Eliminar" value="'.$profileId.'" />';
						echo '</span>';
					}
				}
				else{
					echo '<span id="profileViewButtons">';
					$relMan = new RelationManager($userId, $profileId);
					echo $relMan->printButtons();
					echo '</span>';
					echo '<input type="image" id="reportUser" width="40%" height="40%" src="includes/img/boton_REPORTAR.png" alt="Reportar" title="Reportar" onclick="report()">';
					echo '<script>function report(){ window.location.href="report.php?userId='.$profileId.'"}</script>';
				}
				echo "</div>";
				echo "</div>";
					
				echo "<div class = 'col-md-2 col-12 tarjeta_naranja'>";
				echo "<h2>Mis Eventos:</h2>";
			
				if(count($createdEvents) > 0){
					for($i=0; $i < count($createdEvents); $i++){
						$eventId = $createdEvents[$i]->getEventId();
						$eventImgName =  $createdEvents[$i]->getImgName();
						$eventImgPath = $eventImgDir . $eventImgName;
						echo "<a href= 'eventItem.php?eventId=".$eventId."'>";
						echo "<p><img src='" . $eventImgPath . "' alt='event' height='50' width='50'>";
						echo $createdEvents[$i]->getName();
						echo '</p></a>';
					}
				}
				else 
					echo '<p>Ningun evento de momento.</p>';
				echo "</div>";

<<<<<<< HEAD
					$friends = $userDAO->getFriends($profileId);
					echo "<div class = 'col-md-2 col-12 tarjeta_naranja'>";
					echo '<h2>Mis Amigos: </h2>';
					echo "<div class = 'container'>";
					echo "<div class = 'row'>";
					while(sizeof($friends) > 0){
						echo "<div class = 'col-12'>";
						$friend = array_pop($friends);
						$imgDir = "includes/img/users/";
						$imgName = $friend->getImgName();
						$imgPath = $imgDir . $imgName;
						echo '<a class= "tarjeta_blanca" href="profileView.php?profileId='.$friend->getUserId().'"><img src="'.$imgPath.'" width="50px" height="50px">';
						echo ''.$friend->getName().'</a>';
						echo "</div>";
					}
					echo "</div>";echo "</div>";echo "</div>";
=======
				echo "<div class = 'col-md-2 col-12 tarjeta_naranja'>";
				echo '<h2>Mis Amigos: </h2>';
				while(sizeof($friends) > 0){
					$friend = array_pop($friends);
					$imgName = $friend->getImgName();
					$imgPath = $userImgDir . $imgName;
					echo '<a class= "tarjeta_blanca" href="profileView.php?profileId='.$friend->getUserId().'"><img src="'.$imgPath.'" width="50px" height="50px">';
					echo ''.$friend->getName().'</a>';
				}
				if(sizeof($friends) == 0)
					echo '<p>Ningun amigos de momento.</p>';
				echo "</div>";
>>>>>>> 4c43a4ad711dc683fcb22dae3ff06c4e2446587e
					
				echo "<div class = 'col-md-2 col-12 tarjeta_naranja'>";
				echo '<h2>Eventos Promocionados: </h2>';
				if(count($promotedEvents) > 0){
					for($i=0; $i < count($promotedEvents); $i++){
						$eventId = $promotedEvents[$i]->getEventId();
						$eventImgName =  $promotedEvents[$i]->getImgName();
						$eventImgPath = $eventImgDir . $eventImgName;
						echo "<a href= 'eventItem.php?eventId=".$eventId."'>";
						echo "<p><img src='" . $eventImgPath . "' alt='event' height='50' width='50'>";
						echo $promotedEvents[$i]->getName();
						echo '</p></a>';
					}
				}
				else
					echo '<p>Ningun evento promocionado de momento.</p>';
				echo "</div>";
			}
			else
				echo "<p>Login o registrate para ver esta información.</p>";
		?>
    </div>
	</div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
