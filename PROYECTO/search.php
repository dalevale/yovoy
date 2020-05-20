<?php 
    require_once __DIR__.'/includes/config.php';
	
    $form = new SearchForm;
	$html = $form->manage();
?>

<!DOCTYPE html>

<html>
<head>
    <title>BUSCAR</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php';?>
    </header>
	    <h3> Buscar un evento </h3>

	<?= $html; ?>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>