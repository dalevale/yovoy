<!DOCTYPE html>

<html>
<head>
    <title>Nosotros</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
    <div>
        <div> 
        <h3> SOBRE NOSOTROS </h3>
            <script>
            function ret(){
               window.history.go(-2);
            }
            </script>

        </div>
        
        <div class = "tarjeta_naranja">
            <div class = "tarjeta_gris">
                <h2> Que es YoVoy?</h2>
                <p> YoVoy es la primera plataforma online en la que cualquier persona puede crear, publicar y dar a conocer un evento, de manera que tenga mayor exposición que con los medios de publicidad tradicionales.
                    Además, los usuarios pueden encontrar en YoVoy, un sitio común donde encontrar planes interesantes, que, de otra manera, habrían pasado desapercibidos!

                </p>
            </div>
        </div>
        <input type="image" id="image" alt="Volver" src="includes/img/boton_VOLVER.png" onclick="ret()">
       <!--<button onclick="ret()"><img src="includes/img/boton_VOLVER.png" alt="Volver"></button>!-->
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>