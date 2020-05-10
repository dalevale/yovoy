<!DOCTYPE html>
<html>
<head>
	<title>Editar Perfil - YoVoy</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <h3>Editar Perfil</h3> 
    <div class = "tarjeta_gris">
        <?php
        if(isset($_SESSION["login"]) && $_SESSION["login"]){
           // echo '<h3>Editar Perfil</h3>'; 
            $form = new EditProfileForm($_SESSION["userId"]);
            $form->manage();
        }
        else{
            echo "<p>Login o registrate para editar tu perfil.</p>";
        }
        ?>
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
