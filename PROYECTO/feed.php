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
    <title>FEED</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>

    <div class="container">
        <div class="row align-items-center"><h1>Eventos promocionados</h1></div>
        <div class="row justify-content-between">
        <?php
        $userDAO = new UserDAO;
        $eventDAO = new EventDAO;
        $promotedEventsList = $eventDAO->getPromotedEvents();
        
        $eventImgDir = "includes/img/events/";

        if(!empty($promotedEventsList)){
            foreach($promotedEventsList as $promotedEventWithTotal){
                echo '<div class="col-md-3 col-12 feed_item">';
                $total = $promotedEventWithTotal["total"];
                $promotedEvent = $promotedEventWithTotal["event"];
                $eventId=$promotedEvent->getEventId();
                $eventName = $promotedEvent->getName();
                $creatorId = $promotedEvent->getCreator();
                $creator = $userDAO->getUser($creatorId);
                $creatorName = $creator->getName();
                $eventDate = $promotedEvent->getEventDate();
                $eventImgPath =  $eventImgDir.$promotedEvent->getImgName();
                $location = $promotedEvent->getLocation();
                
             echo '<ul><a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a></ul>';

            // echo ' <p>Creador: <a href="profileView.php?profileId='.$creatorId.'">'.$creatorName.'</a></p>
                echo '<p>Creador:  '.$creatorName.'</a></p>
                     <p> Fecha: '.$eventDate.'</p>
                     <p> Lugar: '.$location.'</p>';
                echo "<img src='" . $eventImgPath . "?random=" . rand(0, 100000) . "' alt='event' height='100%' width='100%'>";

                if($total > 1)
                    echo '<p>Promocionado '.$total.' veces!</p></div></a>';
                else if($total == 1)
                    echo '<p>Promocionado '.$total.' vez!</p></div></a>';
                else
                    echo '<p>No promocionado</p></div></a>';
            }
        }
        else{
            echo '<div class="tarjeta_gris"';
            echo '<p>Aún no hay eventos premium</p>';
            echo '</div>';
        }

        ?>
        </div>
    </div>

    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>