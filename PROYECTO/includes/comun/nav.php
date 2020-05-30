<!DOCTYPE html>
<html>
<head>
	<link href="estilos.css" rel="stylesheet" type="text/css" /> 
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
	<!-- FOR BOOTSTRAP POSITIONING -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<div class = "container-fluid">
	<div class = "row justify-content-between cabecera">  
		<div class="col-md-9 col-12 align-items-start menu">
			<ul>
				<img src="includes/img/YoVoy_Logo_BLANCO.png" width="80px" height="70px">
				<li><a href='feed.php'>FEED</a></li>
				
				<?php
					if(!isset($_SESSION["login"]) ||  (isset($_SESSION["esAdmin"]) && !$_SESSION["esAdmin"]))
						echo '<li><a href="events.php">EVENTOS</a></li>';
					else if(isset($_SESSION["login"]) && $_SESSION["login"] &&  (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"]))
						echo '<li><a href="search.php">BUSCAR</a></li>';
				?>
				
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
						echo "<li><a href='notifications.php'>NOTIFICACIONES ($counter)</a></li>";
					}
					else if(isset($_SESSION["login"]) && $_SESSION["login"] && (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"]))
						echo "<li><a href='showReports.php'>REPORTS</a></li>";
				?>
			</ul>
		</div>
				
		<div class="col-md-3 col-12 usuario">
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
						$nameArr = explode(' ', $name);
						$firstName = $nameArr[0];
							
						echo "<div class = 'container'>";
						echo "<div class = 'row'>";
						echo "<div class = 'col-12'>";
						echo "<h3>Hola, " . $firstName . "!</h3>";
						echo "</div>";
						echo "<div class = 'col-12'>";
						echo "<a href='profileView.php?profileId=". $_SESSION["userId"] ."'><img src='" . $imgPath . "?random=" . rand(0, 100000) . "' alt='usuario' height='50' width='50'></a>";
						echo "<input type='hidden' id='userId' value='".$user->getUserId()."'>";
						echo "</div>";
						echo "<div class = 'col-12'>";
						echo "<a href='includes/logout.php'><input type='image' name='button' src='includes/img/boton_LOGOUT.png'></a>";
						echo "</div></div></div>";
					}
				}
			?>
		</div>
	</div>
	</div>
</body>
</html>
