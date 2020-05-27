<?php 
    require_once __DIR__.'/includes/config.php';

    //TODO: check if user logged in, event exists, user made event


	if(!empty($_GET))
        $_SESSION["eventId"] = $_GET["eventId"];

    $eventId = $_SESSION["eventId"];
	$form = new UploadAuxImgForm($eventId);
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
