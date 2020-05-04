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
        <?php
            if(!isset($_SESSION["login"]) || (isset($_SESSION["login"]) && !$_SESSION["login"] )){
                echo '<h3>Login de usuario</h3>'; 
                $form = new LoginForm;
                $form->manage();
            }
            else {
                echo '<p>Ya estas logueado.</p>'; 
            }
            
        ?>
    </div>
 
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
