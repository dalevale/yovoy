<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
	<title>Editar Perfil - YoVoy</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>

    <h3>Editar Perfil</h3> 

    <div class = "tarjeta_gris">
		<?php
            if(isset($_SESSION["login"])){
                echo '<h3>EDITAR TU PERFIL</h3>'; 
                $form = new EditProfileForm;
                $form->manage();
            }
            else{
                echo "<p>Login o registrate para editar tu perfil.</p>";
            }
       ?>
    </div>
 
    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
