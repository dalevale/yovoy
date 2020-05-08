<!DOCTYPE html>

<html>
<head>
    <title>MIS AMIGOS</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div>
    <?php
        if(isset($_SESSION["login"]) && $_SESSION["login"]){; 
			$userDAO = new UserDAO();
            $userId = $_SESSION["userId"];
            //Lista de amigos
            $friends = $userDAO->getFriends($userId);
            
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
    ?>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>