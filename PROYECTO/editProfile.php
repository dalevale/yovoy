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
        

        <form method = "post" action="<?php echo htmlspecialchars("includes/editProfileSubmit.php");?>" enctype="multipart/form-data">
            <ul>
                <li><label>Nombre</label> <input type="text" name="name"/></li>
                <li><label>Foto</label> <input type="file" accept =".png, .jpg, .jpeg" name="img"/></li>
				<li><label>Cambiar foto a la predeterminada</label> <input type="checkbox" name="defaultImg" value="defaultImg"></li>
                <div><input type="image" name="submit" title="Confirmar" alt="submit" src="includes/img/boton_OK.png">
                <input type="image" name="reset" title="Cancelar" alt="cancelar" src="includes/img/boton_CANCELAR.png"></div>
               <!-- <li><input type="submit" value="Confirmar"></li>
				<li><input type="reset" value="Borrar Campos"></li>!-->
            </ul>
        </form>
		
		<?php
			if (isset($_SESSION["editProfileStatus"])){
				echo "<p>" . $_SESSION["editProfileStatus"] . "</p>";
				unset($_SESSION["editProfileStatus"]);
			}
		?>
    </div>
 
    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>
