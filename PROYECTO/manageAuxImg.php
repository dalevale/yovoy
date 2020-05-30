<?php
    require_once __DIR__.'/includes/config.php';

    
    if(isset($_SESSION["login"]) && $_SESSION["login"]){
        $imageClass = 'fotos';
        $auxImgDAO = new AuxImgDAO();

        if(!empty($_GET))
            $_SESSION["eventId"] = $_GET["eventId"];

        $eventId = $_SESSION["eventId"];
        
        //Conseguir los nombres de fotos auxiliares del evento
        $auxImgDir = "includes/img/events_aux/";
        $auxImages = $auxImgDAO->getAuxImgs($eventId);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- FOR BOOTSTRAP POSITIONING -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- -->
    <!--
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    -->
    <title>Gestionar Fotos - YoVoY</title>
</head>

<body>
<header>
        <?php include 'includes/comun/nav.php' ?>
</header>
<div class = "container">
	<div class = "row justify-content-between">  

        <div class="col-md-6 col-12">
            <h1>Gestionar fotos</h1>
            <?php
            if(isset($_SESSION["login"]) && $_SESSION["login"]){
                // boton para subir fotos
                echo "<input id='addImgBtn' type='image' src='includes/img/boton_CREAREVENTO.png' title='Subir un nuevo foto'>";
                foreach($auxImages as $img){
                    echo "<div>";

                    // aux img
                    echo "<img src='" . $auxImgDir . $img . "?random=" . rand(0, 100000) . "' width=500px >";

                    // boton para descartar
                    echo '<button class="deleteImgBtn" type="submit" value="'. basename($img, ".png") .'">Borrar foto</button>';

                    echo "</div>";
                }
                echo "<p>&nbsp</p><p>&nbsp</p>";
            }
            else{
                echo "<p>Login o registrate para gestionar fotos.</p>";
            }
            ?>
        </div>
    </div>

    <div class = "col-md-5 col-12 comentarios">
        <?php
        ?>
    </div>

    

       

    </div>
</div>



<footer>
    <?php include 'includes/comun/footer.php' ?>
</footer>
</body>
</html>