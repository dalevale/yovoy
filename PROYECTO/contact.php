<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>

<html>
<head>
<!-- FOR BOOTSTRAP POSITIONING -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Contacto</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
    <div class = "container">
        <div> 
        <h1> Contacto </h1>
        <script>
            function ret(){
                window.history.go(-1);
            }
        </script>
        </div>
        <div class = "tarjeta_naranja">
            <h2> Proximamente...</h2>
            <p> Vaya! Esto no está terminado todavía :c </p>
        </div>
        <input type="image" id="image" alt="Volver" src="includes/img/boton_VOLVER.png" onclick="ret()">
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>