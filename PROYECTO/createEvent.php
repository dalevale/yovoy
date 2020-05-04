<!DOCTYPE html>

<html>
<head>
    <title> Crear Evento - YoVoY </title>
		
</head>
<body>	
	<header>
		<?php include 'includes/comun/nav.php' ?>
	</header>
	<script>
		function goBack() {
			window.location.href = "eventos.php";
		}
	</script>
	
	<h3>¡Vamos a crear un evento!</h3>

	<div>	
		<?php 
		$form = new NewEventForm;
		$form->manage();
		?>
	</div>	

	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
