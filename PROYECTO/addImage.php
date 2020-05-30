<?php 
    require_once __DIR__.'/includes/config.php';

	if(isset($_SESSION["login"]) && $_SESSION["login"]){
        if(!empty($_GET))
        	$_SESSION["eventId"] = $_GET["eventId"];

		$eventId = $_SESSION["eventId"];
		$form = new UploadAuxImgForm($eventId);
		$html = $form->manage();
    }
	else{
        $html = "<p>No puedes acceder esta página. Login o registrate.</p>";
    }
    
?>
<!DOCTYPE html>

<html>
<head>
    <title> Añadir Foto - YoVoY </title>
</head>
<body>	
	<header>
		<?php include 'includes/comun/nav.php' ?>
	</header>

	<div class = "container">
    <h1>Añadir Fotos de Eventos</h1>
    <div class = "tarjeta_gris">
        <?= $html; ?>
    </div></div>
	<footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
