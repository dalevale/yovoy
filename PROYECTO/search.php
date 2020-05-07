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

	<?php 
			$form = new SearchForm;
			$form->manage();
	?>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>