<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <title>Registro - YoVoy</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
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
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
