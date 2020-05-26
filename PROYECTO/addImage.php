<?php 
    require_once __DIR__.'/includes/config.php';

	$eventId = $_POST["eventId"];
	$form = new EditEventForm($eventId);
	$html = $form->manage();
?>
<!DOCTYPE html>

<html>
<head>
    <title> Añadir Foto - YoVoY </title>
	<!--<script>
		function goBack() {
			window.location.href = "events.php";
		}
	</script>-->
</head>
<body>	
	<header>
		<?php include 'includes/comun/nav.php' ?>
	</header>
	
	<div>	
		<h1>Añadir Fotos de Eventos</h1>
		<?= $html; ?>
	</div>	
	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
