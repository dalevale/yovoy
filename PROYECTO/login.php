<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
	<title>Login - YoVoy</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>

    <div>
        <h3>Login de usuario</h3> 
        <?php
            $form = new LoginForm;
            $form->manage();
        ?>
        <!--<form method = "post" class="tarjeta_gris" action="<?php echo htmlspecialchars("includes/loginSubmit.php");?>">
            <ul>
                <li><label>Email</label><input type="text" name="email"/></li>
                <li><label>Contraseña</label><input type="password" name="password"/></li>
                <!--<li><input type="image" alt="submit" src="includes/img/boton_LOGIN.png"></li>
                <li><input type="submit" value="Login" ></li>
            </ul>
        </form>-->
            
        <?php 
            if(isset($_SESSION["login"])){
                if(!$_SESSION["login"]){
                    echo '<p>Autenticación no válida</p>';
                        
                    if(!$_SESSION["userInDB"])
                        echo '<p>Usuario no existente.</p>';
                    else if(!$_SESSION["correctPass"]){
                        echo '<p>Contraseña incorrecta</p>';
                    }

                    session_destroy();
                }
            }
        ?>
    </div>
 
    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
