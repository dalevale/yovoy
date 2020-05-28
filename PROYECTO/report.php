<?php 
    require_once __DIR__.'/includes/config.php';

	$form = new ReportForm;
	$html = $form->manage();
?>
<!DOCTYPE html>

<html>
<head>
    <title>	Report </title>
		
</head>
<body>	
	<header>
		<?php include 'includes/comun/nav.php' ?>
	</header>
	
	<h3>Reportar usuario/evento</h3>

	<div>
		<?= $html; ?>
	</div>	

	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
