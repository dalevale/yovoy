<?php 
    require_once __DIR__.'/includes/config.php';

	$eventId = $_POST["event_id"];
	$form = new EditEventForm($eventId);
	$html = $form->manage();
?>
<!DOCTYPE html>

<html>
<head>
    <title> Editar Evento - YoVoY </title>
	<script>
		function goBack() {
			window.location.href = "events.php";
		}
	</script>
</head>
<body>	
	<header>
		<?php include 'includes/comun/nav.php' ?>
	</header>
	
	<div>	
		<h1>Editar Evento</h1>
		<?= $html; ?>
	</div>	
	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
