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
    <div class= "friends">
    <?php
        if(isset($_SESSION["login"]) && $_SESSION["login"]){; 
			$userDAO = new UserDAO();
            $userId = $_SESSION["userId"];
            //Lista de amigos
            $friends = $userDAO->getFriends($userId);
                echo '<ul>';
                echo '<div class = "row justify-content-between">';
            while(sizeof($friends) > 0){
                    echo '<div class = "col-md-5 col-12">';
                    echo '<li><ul>';
                     $friend = array_pop($friends);
                    $imgDir = "includes/img/users/";
					$imgName = $friend->getImgName();
					$imgPath = $imgDir . $imgName;
                    echo '<a href="profileView.php?profileId='.$friend->getUserId().'"><li><img src="'.$imgPath.'" width="50px" height="50px"></li>';
                    echo '<li>'.$friend->getName().'</li>';
                    echo '<li>'.$friend->getUsername().'</li></a>';
                    echo '</ul></li></div>';
            }
            echo '</div></ul>';
        }
    ?>
    </div></div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>