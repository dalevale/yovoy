<!DOCTYPE html>

<html>
<head>
    <title>BUSCAR</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php';
		?>
    </header>
	<h3> Buscar un evento </h3>
	<!--
    <div>
		
		<form method="get" action="includes/searchSubmit.php">
                <p><input type="text" name="search" required placeholder="Busca por nombre, etiqueta o usuario">
                <input type='image' title="Buscar" alt="submit" src='includes/img/boton_BUSCAR.png'>
				</p>
		</form>
		
		
		
    </div>
	-->
	<?php 
			$form = new SearchForm;
			$form->manage();
	?>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>