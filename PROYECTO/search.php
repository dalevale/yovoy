<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8"/>
     <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <title>BUSCAR</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/cabecera.php' ?>
    </header>
	<h1> Buscar un evento </h1>
    <div>
		<?php
        /*<div class="topnav">
		 
		  <input type="text" placeholder="Busca por nombre, etiqueta o usuario">
		</div>
		*/
		?>
		<form method="get" action="includes/searchSubmit.php">
				<p><input type="text" name="search" required placeholder="Busca por nombre, etiqueta o usuario">
				<button type="submit"> Buscar </button></p>
		</form>
    </div>

    <footer>
        <?php include 'includes/comun/pie.php' ?>
    </footer>
</body>
</html>