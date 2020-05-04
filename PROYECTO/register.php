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
        
       <?php
            if(!isset($_SESSION["login"])){
                echo '<h3>REGISTRARSE</h3>'; 
                $form = new RegisterForm;
                $form->manage();
            }
            else{
                echo '<p>Ya estas logueado.</p>'; 
            }
       ?>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
