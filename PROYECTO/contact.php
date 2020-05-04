<!DOCTYPE html>

<html>
<head>
    <title>Contacto</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
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
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>