<!DOCTYPE html>

<html>
<head>
    <title> Editar Evento - YoVoY </title>
	<script>
		function goBack() {
			window.location.href = "eventos.php";
		}
	</script>
</head>
<body>	
	<header>
		<?php include 'includes/comun/nav.php' ?>
	</header>
	
	<div>	
		<h1>Editar Evento</h1>
		<?php 
			$eventId = $_POST["eventId"];
			$form = new EditEventForm($eventId);
			$form->manage();
		?>
	</div>	
	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
