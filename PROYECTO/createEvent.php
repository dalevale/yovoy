<?php 
    require_once __DIR__.'/includes/config.php';

	$form = new NewEventForm;
	$html = $form->manage();
?>
<!DOCTYPE html>

<html>
<head>
    <title> Crear Evento - YoVoY </title>
		
</head>
<body>	
	<header>
		<?php include 'includes/comun/nav.php' ?>
	</header>
	
	<h3>¡Vamos a crear un evento!</h3>

	<div>
		<?= $html; ?>
	</div>	

	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
