<?php 
    require_once __DIR__.'/includes/config.php';

    
    $userDAO = new UserDAO;
    $eventDAO = new EventDAO;
    $promotedEventsList = $eventDAO->getPromotedEvents();
    $premiumEventsList = $eventDAO->getPremiumEvents();
    
    $eventImgDir = "includes/img/events/";
?>

<!DOCTYPE html>

<html>
<head>
    <!-- FOR BOOTSTRAP POSITIONING -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>FEED</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
    <div class="container">
        <div class="row align-items-center"><h1>Eventos premium</h1></div>
        <div class="row justify-content-between">
            <?php
                if(!empty($premiumEventsList)){
                    foreach($premiumEventsList as $premiumEvent){
                        echo '<div class="col-md-3 col-12 feed_item">';
                        $eventId=$premiumEvent->getEventId();
                        $eventName = $premiumEvent->getName();
                        $creatorId = $premiumEvent->getCreator();
                        $creator = $userDAO->getUser($creatorId);
                        $creatorName = $creator->getName();
                        $date = $premiumEvent->getEventDate();
                        $eventDate = date("Y-m-d g:ia", strtotime($date));
                        $eventImgPath =  $eventImgDir.$premiumEvent->getImgName();
                        $location = $premiumEvent->getLocation();
                        echo '<a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a>';
                        echo '<p>Creador:  '.$creatorName.'</a></p>
                             <p> Fecha: '.$eventDate.'</p>
                             <p> Lugar: '.$location.'</p>';
                        echo "<img src='" . $eventImgPath . "?random=" . rand(0, 100000) . "' alt='event' height='100%' width='100%'>";
                        echo '</div>';
                    }
                }
                else{
                    echo '<div class="tarjeta_blanca"';
                    echo '<p>Aún no hay eventos premium</p>';
                    echo '</div>';
                }
            ?>
        </div>
        </div>
    </div>

    <div class="container">
        <div class="row align-items-center"><h1>Eventos promocionados</h1></div>
        <div class="row justify-content-between">
        <?php
    
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
                $date = $promotedEvent->getEventDate();
                $eventDate = date("Y-m-d g:ia", strtotime($date));

                $eventImgPath =  $eventImgDir.$promotedEvent->getImgName();
                $location = $promotedEvent->getLocation();
                
             echo '<a href="eventItem.php?eventId='.$eventId.'">'.$eventName.'</a>';

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
            echo '<div class="tarjeta_blanca">';
            echo '<p>Aún no hay eventos promocionados</p>';
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