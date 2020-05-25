<?php
    require_once __DIR__.'/includes/config.php';
    if(isset($_SESSION["login"]) && $_SESSION["login"]){
        $form = new EditProfileForm($_SESSION["userId"]);
        $html = $form->manage();
    }
    else{
        echo "<p>Login o registrate para editar tu perfil.</p>";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- FOR BOOTSTRAP POSITIONING -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- -->
	<title>Editar Perfil - YoVoy</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div class = "container">
    <h1>Editar Perfil</h1> 
    <div class = "tarjeta_gris">
        <?= $html; ?>
        
    </div></div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
