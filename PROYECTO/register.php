<?php 
    require_once __DIR__.'/includes/config.php';
    if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
        $form = new RegisterForm;
        $html = $form->manage();
    }
    else{
        echo '<p>Ya estas logueado.</p>'; 
    }
?>

<!DOCTYPE html>

<html>
<head>
    <title>Registro - YoVoy</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div>
        
        <h3>REGISTRARSE</h3>
        <?= $html ?>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
