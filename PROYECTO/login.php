<?php 
    require_once __DIR__.'/includes/config.php';
    
    if(!isset($_SESSION["login"]) || (isset($_SESSION["login"]) && !$_SESSION["login"] )){
        $form = new LoginForm;
        $html = $form->manage();
    }
    else {
        $html = '<p>Ya estas logueado.</p>'; 
    }
?>

<!DOCTYPE html>

<html>
<head>
	<title>Login - YoVoy</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div>
        <h3>Login de usuario</h3>
        <?= $html; ?>
    </div>
 
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
