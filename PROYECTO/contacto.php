<?php session_start(); ?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8" />
     <link href="estilos.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <title>Contacto</title>
</head>
<body>
    <div>
        <div> 
        <h3> Contacto </h3>
            <script>
            function ret(){
               window.history.go(-2);
            }
            </script>

        </div>
        
        <div class = "tarjeta_naranja">
           
                <h2> Proximamente...</h2>
                <p> Vaya! Esto no está terminado todavía :c </p>
        </div>
        <input type="image" id="image" alt="Volver" src="includes/img/boton_VOLVER.png" onclick="ret()">
    </div>
</body>
</html>