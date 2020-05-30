<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>

<html>
<head>
<!-- FOR BOOTSTRAP POSITIONING -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- -->
    <title>Preguntas Precuentes</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
    <div class = "container">
        <div> 
        <h1> PREGUNTAS FRECUENTES </h1>
            <script>
            function ret(){
               window.history.go(-1);
            }
            </script>

        </div>
        
        <div class = "tarjeta_naranja">
            <h2> Puedo crear una cuenta gratuita?</h2>
            <div class = "tarjeta_blanca">
            <p> Todos los usuarios disponen de una cuenta gratuita de base, que puede ser mejorada con la membresia premium.</p>
        </div></div>
        
        <div class = "tarjeta_naranja">
            <h2> Puedo cancelar mi membresia premium?</h2>
            <div class = "tarjeta_blanca">
            <p> En cualquier momento, puedes decidir cancelar tu suscripcion y volverás a ser un usuario standar.</p>
        </div></div>
        
        <input type="image" id="image" alt="Volver" src="includes/img/boton_VOLVER.png" onclick="ret()">
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>