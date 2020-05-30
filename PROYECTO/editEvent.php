<?php 
    require_once __DIR__.'/includes/config.php';
	
    if(isset($_SESSION["login"]) && $_SESSION["login"]){
		$eventId = $_POST["eventId"];
		$form = new EditEventForm($eventId);
		$html = $form->manage();
	}
	else
        $html = "<p>No puedes acceder esta página. Login o registrate.</p>";
?>
<!DOCTYPE html>

<html>
<head>
	<!-- FOR BOOTSTRAP POSITIONING -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
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
	
	<div class = "container tarjeta_gris">	
		<h1>Editar Evento</h1>
		<?= $html; ?>
	</div>	
	
	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
