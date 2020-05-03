
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8" />
     <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <title>MIS AMIGOS</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>

    <div>
    <?php
        if(isset($_SESSION["login"]) && $_SESSION["login"]){
			$app = es\ucm\fdi\aw\Application::getSingleton();
			$conn = $app->bdConnection(); 
			$userDAO = new UserDAO($conn);
            $userId = $_SESSION["userId"];
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
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>