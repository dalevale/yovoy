<?php 
    require_once __DIR__.'/includes/config.php';
	if(isset($_SESSION["login"]) && $_SESSION["login"]){
		$form = new NewEventForm;
		$html = $form->manage();
	}
	else
        $html = "<p>No puedes acceder esta página. Login o registrate.</p>";
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
    <div class = "tarjeta_gris">
		<?= $html; ?>
	</div>	

	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
