<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>

<html>
<head>
    <title>Preguntas Precuentes</title>
</head>

<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
    <div>
        <div> 
        <h3> PREGUNTAS FRECUENTES </h3>
            <script>
            function ret(){
               window.history.go(-2);
            }
            </script>

        </div>
        
        <div class = "tarjeta_naranja">
            <h2> Puedo crear una cuenta gratuita?</h2>
            <p> Todos los usuarios disponen de una cuenta gratuita de base, que puede ser mejorada con la membresia premium.</p>
        </div>
        
        <div class = "tarjeta_naranja">
            <h2> Puedo cancelar mi membresia premium?</h2>
            <p> En cualquier momento, puedes decidir cancelar tu suscripcion y volverás a ser un usuario standar.</p>
        </div>
        
        <input type="image" id="image" alt="Volver" src="includes/img/boton_VOLVER.png" onclick="ret()">
    </div>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>