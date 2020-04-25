<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
	<title>Cambiar Contraseña - YoVoy</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>

    <h3>Login de usuario</h3> 
    <div class = "tarjeta_gris">
        

        <form method = "post" action="<?php echo htmlspecialchars("includes/changePasswordSubmit.php");?>">
            <ul>
                <label>Contraseña actual <input type="password" name="currPass" required/></label>
                <label>Confirme contraseña actual <input type="password" name="currPassConfirm" required/></label>
				<label>Contraseña nueva <input type="password" name="newPass" required/></label>
                <label>Confirme contraseña nueva <input type="password" name="newPassConfirm" required/></label>

                <div><input type="image" name="submit" title="Confirmar" alt="submit" src="includes/img/boton_OK.png">
                <input type="image" name="reset" title="Cancelar" alt="cancelar" src="includes/img/boton_CANCELAR.png"></div>

                <!--<li><input type="submit" value="Confirmar"></li>
				<li><input type="reset" value="Borrar Campos"></li>-->
            </ul>
        </form>
		
		<?php
			if (isset($_SESSION["changePassStatus"])){
				echo "<p>" . $_SESSION["changePassStatus"] . "</p>";
				unset($_SESSION["changePassStatus"]);
			}
		?>
    </div>
 
    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
