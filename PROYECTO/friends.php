<?php 
    require_once __DIR__.'/includes/config.php';
    
    //DAO�s
    $userDAO = new UserDAO();
    $eventDAO = new EventDAO();
    $activityDAO = new ActivityDAO();
    
    //Directorio de las imagenes de los usuarios
    $userId = $_SESSION["userId"];
    $userImgDir = "includes/img/users/";

    //Condiciones necesarias para ver el contenido
    $loggedIn = isset($_SESSION["login"]) && $_SESSION["login"];
    $adminLoggedIn = isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"];

    //Lista de amigos y lista de las actividades de los amigos
    $friendsList = $userDAO->getFriends($userId);
    $activitiesList = $activityDAO->getFriendsActivity($_SESSION["userId"]);
?>

<!DOCTYPE html>

<html>
<head>
     <!-- FOR BOOTSTRAP POSITIONING -->
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>MIS AMIGOS</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
    <div class= "container">  
    <h1>Mis Amigos</h1>
    </div>
    <div class= "container friends">    
    <div class= "row justify-content-between">
        <div class="col-md-4 col-12">

            <div id="searchUser" class="tarjeta_gris">
                <input id="searchUserInput" type="text" name="search" required placeholder="Nombre de usuario">
                <input id="searchUserBtn" type='image' title="Buscar" alt="submit" width="20%" length="20%" src='includes/img/boton_BUSCAR.png'>
            </div>
       
            <div id="friendsList" class="tarjeta_gris">
                <?php
                    if($loggedIn){
                        echo '<h2>Amigos</h2>';
                            echo '<div class="tarjeta_blanca">';
                        while(sizeof($friendsList) > 0){
                                echo '<div>';
                                $friend = array_pop($friendsList);
					            $imgName = $friend->getImgName();
					            $imgPath = $imgDir . $imgName;
                                echo '<p><a href="profileView.php?profileId='.$friend->getUserId().'"><img src="'.$imgPath.'" width="50px" height="50px">';
                                echo $friend->getUsername().'</p></a>';
                                echo '</div>';
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        </div>

        <div class="col-md-6 col-11 tarjeta_gris" >
            <h2>Actividades recientes</h2>
            <?php
            
                echo '<div>';
                while(sizeof($activitiesList) > 0){
                    $activity = array_shift($activitiesList);
                    $activityUser = $userDAO->getUser($activity->getUserId());
                    $activityUserId = $activityUser->getUserId();
                    $activityUserName = $activityUser->getName();
                    $activityDate = date("Y-m-d g:ia", strtotime($activity->getActivityDate()));
				    $imgName = $activityUser->getImgName();
				    $imgPath = $userImgDir . $imgName;

                    echo '<div class="tarjeta_blanca">';
                    echo '<p>'.$activityDate.'</p>';
                    echo '<a href="profileView.php?profileId='. $activityUserId .'"><img src="'.$imgPath.'" width="50px" height="50px"></a>';
                    echo '<a href="profileView.php?profileId='. $activityUserId .'">'.$activityUserName.'</a>';
                    echo $activityDAO->getActivityString($activity->getActivityType());
                    if($activity->getObjType() == ActivityDAO::USER){
                        $objUser = $userDAO->getUser($activity->getObjUserId());
                        echo '<a href="profileView.php?profileId='. $objUser->getUserId() .'">'. $objUser->getName().'</a>';
				    }
                    else if ($activity->getObjType() == ActivityDAO::EVENT){
                        $objEvent = $eventDAO->getEvent($activity->getObjEventId());
                        echo '<a href="eventItem.php?eventId='. $objEvent->getEventId() .'">'. $objEvent->getName().'</a>';
                    }   
                    echo '</div>';
			    }
                echo '</div>';
            ?>
        </div>
    </div>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>