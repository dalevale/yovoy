<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link href="estilos.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <!-- FOR BOOTSTRAP POSITIONING -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- -->
    <title>BUSCAR</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php';?>
    </header>
	    
    <div class = "container">
        <div class = "row justify-content-between">
            <div id="searchUserAdmin" class="col-md-4 col-12 tarjeta_gris">
            <h1> Buscar un usuario </h1>
                    <p><input id="searchUserInputAdmin" type="text" name="search" required placeholder="Nombre de usuario"></p>
                    <p>
                        <input type="radio" name="userOption" value="name" checked="checked"> Nombre
                        <input type="radio" name="userOption" value="username">Nombre Usuario
                    </p>
                    <p class="searchBtns">
                        <input id="searchUserBtnAdmin" type='image' title="Buscar" alt="submit" width="20%" length="20%" src='includes/img/boton_BUSCAR.png'>
                    </p>
            </div>
            <div id="searchEventAdmin" class="col-md-6 col-12 tarjeta_gris">
            <h1> Buscar un evento </h1>
                <p><input type="text" name="search" required placeholder="Busca por nombre, creador, etiqueta, capacidad o ubicación"></p>
		        <p>
			        <input type="radio" name="eventOption" value="eventName" checked="checked"> Nombre de Evento
			        <input type="radio" name="eventOption" value="creator"> Creador
			        <input type="radio" name="eventOption" value="tags"> Etiqueta
			        <input type="radio" name="eventOption" value="capacity"> Capacidad
			        <input type="radio" name="eventOption" value="location"> Ubicacion
		        </p>
		        <p class="searchBtns">
                    <input id="searchEventAdminBtn" type='image' width="15%" length="15%" title="Buscar" alt="submit" src='includes/img/boton_BUSCAR.png'>
                    <input id="resetSearchEventAdminBtn" type="image" width="15%" length="15%" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
		        </p>
		    </div>
        </div>
    </div>
	<script src="includes/js/searchAdmin.js" type="text/javascript" ></script>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>