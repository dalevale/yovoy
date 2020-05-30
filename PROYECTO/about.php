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
    <title>Nosotros</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div class="container">
        <div> 
        <h1> SOBRE NOSOTROS </h1>
            <script>
            function ret(){
               window.history.go(-1);
            }
            </script>
        </div>
        <div class = "tarjeta_naranja">
        <h2> Que es YoVoy?</h2>
            <div class = "tarjeta_blanca">
                <p> YoVoy es la primera plataforma online en la que cualquier persona puede crear, publicar y dar a conocer un evento, de manera que tenga mayor exposición que con los medios de publicidad tradicionales.
                    Además, los usuarios pueden encontrar en YoVoy, un sitio común donde encontrar planes interesantes, que, de otra manera, habrían pasado desapercibidos!
                </p>
            </div>
        </div>
        <input type="image" id="image" alt="Volver" src="includes/img/boton_VOLVER.png" onclick="ret()">
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>