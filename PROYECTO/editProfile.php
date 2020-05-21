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
	<title>Editar Perfil - YoVoy</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <h3>Editar Perfil</h3> 
    <div class = "tarjeta_gris">
        <?= $html; ?>
        
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
