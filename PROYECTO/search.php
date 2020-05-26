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
    <script>
     function crearEvento(){
            window.location.href = "createEvent.php";
        }
    </script>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php';?>
    </header>
	    
    <div class = "container">
        
        <h1> Buscar un evento </h1>
        <div id="searchbar" class="tarjeta_gris">
            <p><input type="text" name="search" required placeholder="Busca por nombre, etiqueta o usuario"></p>
		    <p>
			    <input type="radio" name="option" value="eventName"> Nombre de Evento
			    <input type="radio" name="option" value="creator"> Creador
			    <input type="radio" name="option" value="tag"> Etiqueta
			    <input type="radio" name="option" value="capacity"> Capacidad
			    <input type="radio" name="option" value="location"> Ubicacion
		    </p>
		    <p class="searchBtns">
                <input id="searchEventBtn" type='image' title="Buscar" alt="submit" src='includes/img/boton_BUSCAR.png'>
                <input id="resetSearchEventBtn" type="image" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
		    </p>
		    </div>
        <?php
        if(isset($_SESSION["login"])) {
        ?>  
            <script>
            var html = $('<input type='+'"image"'+'src='+'"includes/img/boton_CREAREVENTO.png"'+' title='+'"Crear un nuevo evento"'+ 'onclick='+'"crearEvento();"'+'>');
            $("#searchbar p.searchBtns").append(html);
            </script>";
		<?php
        }
        ?>
        
        <div id="eventList" class = "row justify-content-between">
        </div>
    </div>
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>