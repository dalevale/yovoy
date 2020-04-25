<!DOCTYPE html>
<html>

<!-- NECESARIO: Poner boton "Crear Evento" en la pagina eventos.php -->

<head> 
    <meta charset="UTF-8">
	<link href="estilos.css" rel="stylesheet" type="text/css" /> 
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <title> Crear Evento - YoVoY </title>
		
</head>
<body>	
	<header>
		<?php include 'includes/comun/cabecera.php' ?>
	</header>
	<script>
		function goBack() {
			window.location.href = "eventos.php";
		}
	</script>
	
	<h3>¡Vamos a crear un evento!</h3>

	<div>	
		
		<!--<form name = "myForm" method="post" action="<?php 
										echo htmlspecialchars('includes/newEventSubmit.php');
										?>">
			<fieldset>
				<legend>Detalles del evento</legend>
				<label>Título: </label><input type="text" name="eventName" required >
				<p>
					<label>Fecha: </label><input type="date" name="eventDate" name="fecha" value="2020-01-1" min="2020-01-01" max="2020-12-31">
					<label>Ubicación: </label><input type="text" name="eventLocation" required >
					<label>Número máximo de asistentes: </label><input type="number" name="maxAssistants" required value="1" min="1" max="10">
					<!--<p><label>Email del organizador: <input type="email" id="email" placeholder="Introduce una dirección válida"required></label></p>
				</p>
				<label>Etiquetas (separar por comas): </label><input type="text" name="eventTags" required>
				<p> <label for="address">Descripción del evento:</label> </p>
				<p> <textarea rows="9" cols="70" name="description"></textarea> </p>
				<button type="submit"> Enviar </button>
				<button type="reset"> Borrar Campos </button>
				<button type="text" onClick="goBack()"> Cancelar </button>-->
				<?php 
				$form = new NewEventForm;
				$form->manage();
                /*f(isset($_SESSION["eventCreated"])){
                    if(!$_SESSION["eventCreated"])
                        echo "<p>Ha occurido un error.</p>";
					else 
                        echo "<p>Se ha hecho el evento correctamente.</p>";
	
                }
				if(isset($_SESSION["noBlanksEvent"])){
                    if(!$_SESSION["noBlanksEvent"]){
                        echo "<p>Rellene todos los campos.</p>";
                    }
                }*/
				?>
			
		</form>
	</div>	
	<footer>
		<?php include 'includes/comun/pie.php' ?>
	</footer>
		
</body>
</html>
