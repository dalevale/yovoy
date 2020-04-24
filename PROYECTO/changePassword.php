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

    <div>
        <h1>Login de usuario</h1> 

        <form method = "post" action="<?php echo htmlspecialchars("includes/changePasswordSubmit.php");?>">
            <ul>
                <li>Contraseña actual <input type="password" name="currPass" required/></li>
                <li>Confirme contraseña actual <input type="password" name="currPassConfirm" required/></li>
				<li>Contraseña nueva <input type="password" name="newPass" required/></li>
                <li>Confirme contraseña nueva <input type="password" name="newPassConfirm" required/></li>
                <li><input type="submit" value="Confirmar"></li>
				<li><input type="reset" value="Borrar Campos"></li>
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
