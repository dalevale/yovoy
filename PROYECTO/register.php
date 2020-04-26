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
        <!--<form method="post" class="tarjeta_gris" action="<?php echo htmlspecialchars("includes/registerSubmit.php");?>" enctype="multipart/form-data">
            <ul>
                <li><label>Usuario</label> <input type="text" name="username" required /></li>
                <li><label>Contraseña</label> <input type="password" name="password" required /></li>
                <li><label>Confirme contraseña</label> <input type="password" name="passwordConfirm" required /></li>
                <li><label>Nombre</label> <input type="text" name="name" required /></li>
				<li><label>Email</label> <input type="text" name="email" required /></li>
                <li><label>Foto</label> <input type="file" accept =".png, .jpg, .jpeg" name="img"/></li>
				<li><label>Registrarse como Usuario Premium</label> <input type="checkbox" name="premium" value="premium"></li>
                <li><input type="image" alt="submit" src="includes/img/boton_REGISTER.png"></li>
                <li><input type="image" alt="reset" src="includes/img/boton_CANCELAR.png"></li>
              <!--  <li><input type="submit" value="Registrarse"/></li>
				<li><input type="reset" value="Borrar Campos"></li> !-->

                <?php 
					if(isset($_SESSION["regStatus"])){
                        echo "<p>". $_SESSION["regStatus"] ."</p>";
						unset($_SESSION["regStatus"]);
                    }
                ?>
                
            </ul>
        </form>
    </div>

    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
