<!DOCTYPE html>
<html>
<head>
	<link href="estilos.css" rel="stylesheet" type="text/css" /> 
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
	<!-- FOR BOOTSTRAP POSITIONING -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
    <body>
	<div class = "container-fluid">
	<div class = "row justify-content-between cabecera">  
			<div class="col-10 align-items-start menu">
					<ul>
						<!--logo aquí-->
						<!--<img src="includes/img/YoVoy_Logo_BLANCO.png" width="80px" height="70px">-->
						<!--<li><a href='index.html'>INICIO</a></li>-->
						<li><a href='feed.php'>FEED</a></li>
						<li><a href='events.php'>EVENTOS</a></li>
						<li><a href='search.php'>BUSCAR</a></li>
						<li><a href='calendar.php'>CALENDARIO</a></li>
						<?php	
						if(isset($_SESSION["login"]) && $_SESSION["login"] &&  (isset($_SESSION["esAdmin"]) && !$_SESSION["esAdmin"])){
							$userDAO = new UserDAO();
							$eventDAO = new EventDAO();
							$notificationsDAO = new NotificationsDAO();
							$createdEvents = $userDAO->getCreatedEvents($_SESSION["userId"]);
						
							//contamos numero de peticiones
							$counter=0;
							$notificationsList = $notificationsDAO->getNotificationsByUser($_SESSION["userId"]);
							foreach($notificationsList as $notification){
								$isRead = $notification->isRead();
								if(!$isRead)
									$counter++;
							}
							
							echo "<li><a href='friends.php'>AMIGOS</a></li>";
							echo "<li><a href='profileView.php?profileId=". $_SESSION["userId"] ."'>MI ÁREA</a></li>";
							echo "<li><a href='notifications.php'>NOTIFICACIONES ($counter)</a></li>";
						}
						?>
					</ul>
			</div>
				
			<div class="col-2 usuario">
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
							$userDAO = new UserDAO();
							
							$user = $userDAO->getUser($_SESSION["userId"]);
							$imgDir = "includes/img/users/";
							$imgName = $user->getImgName();
							$imgPath = $imgDir . $imgName;
							$name = $user->getName();
							
							echo "<img src='" . $imgPath . "?random=" . rand(0, 100000) . "' alt='usuario' height='50' width='50'>";
							echo "<input type='hidden' id='userId' value='".$user->getUserId()."'>";
							echo "<a href='includes/logout.php'><input type='image' name='button' src='includes/img/boton_LOGOUT.png'></a>";
						
							echo "<p>Hola, " . $name . "!</p>";
							//MENSAJE QUE SE MUESTRA A NUEVOS USUARIOS
							//if(isset($_SESSION["newUser"]) && $_SESSION["newUser"]){
							//	echo "<h1>AHORA ERES UN USUARIO REGISTRADO!</h1>";
							//}   
						}
					}
				?>
				</php>
			</div>
	</div>
	</div>
    </body>
</html>
