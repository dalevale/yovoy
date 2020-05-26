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
    <title>MIS AMIGOS</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
    <div class= "container">
    <h1>Mis Amigos</h1>
    
    
    <div class= "friends row justify-content-between">
        <div class="col-md-4 col-12">
            <div id="searchUser" class="tarjeta_gris">
                <input id="searchUserInput" type="text" name="search" required placeholder="Nombre usuario">
                <input id="searchUserBtn" type='image' title="Buscar" alt="submit" width="20%" length="20%" src='includes/img/boton_BUSCAR.png'>
            </div>
       
            <div id="friendsList" class="tarjeta_gris">
                <?php
                    if(isset($_SESSION["login"]) && $_SESSION["login"]){
			            $userDAO = new UserDAO();
                        $userId = $_SESSION["userId"];
                        echo '<h2>Amigos</h2>';
                        //Lista de amigos
                        $friends = $userDAO->getFriends($userId);
                            echo '<div>';
                        while(sizeof($friends) > 0){
                                echo '<div>';
                                 $friend = array_pop($friends);
                                $imgDir = "includes/img/users/";
					            $imgName = $friend->getImgName();
					            $imgPath = $imgDir . $imgName;
                                echo '<p><a href="profileView.php?profileId='.$friend->getUserId().'"><img src="'.$imgPath.'" width="50px" height="50px">';
                                echo $friend->getUsername().'</p></a>';
                                echo '</div></div>';
                        }
                    }
                ?>
            </div>
        </div>

        <div id="userActivity" class="col-md-7 col-12 tarjeta_gris">
        <h2>Actividades recientes</h2>
        <?php
			$userDAO = new UserDAO();
            $eventDAO = new EventDAO();
            $activityDAO = new ActivityDAO();
            $activities = $activityDAO->getFriendsActivity($_SESSION["userId"]);
            echo '<div>';
            while(sizeof($activities) > 0){
                $activity = array_shift($activities);
                $activityUser = $userDAO->getUser($activity->getUserId());
                $activityUserId = $activityUser->getUserId();
                $activityUserName = $activityUser->getName();
                $imgDir = "includes/img/users/";
				$imgName = $activityUser->getImgName();
				$imgPath = $imgDir . $imgName;
                $activityDate = date("Y-m-d g:ia", strtotime($activity->getActivityDate()));
                echo '<div>';
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
                    
                echo '--'.$activityDate;
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