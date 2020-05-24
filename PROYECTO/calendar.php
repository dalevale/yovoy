<?php 
    require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>

<html>
 <head>
    <title>CALENDAR</title>
    <link href="includes/css/calendar.css" rel="stylesheet">
<link href='includes/js/calendar/fullcalendar/packages/core/main.css'
	rel='stylesheet' />
<link href='includes/js/calendar/fullcalendar/packages/daygrid/main.css'
	rel='stylesheet' />
<link href='includes/js/calendar/fullcalendar/packages/timegrid/main.css'
	rel='stylesheet' />
<script src='includes/js/calendar/fullcalendar/packages/core/main.js'></script>
<script src='includes/js/calendar/fullcalendar/packages/interaction/main.js'></script>
<script src='includes/js/calendar/fullcalendar/packages/daygrid/main.js'></script>
<script src='includes/js/calendar/fullcalendar/packages/timegrid/main.js'></script>

    <script>
   
 document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

  
	var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,
        select: function(arg) { 
            },
                
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: 'load.php'
    });
    calendar.render();
  
  });
   
  </script>
 </head>
 <body>
  <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
  <br></br>
  <div class="container">
        <div class="row align-items-center"><h1>Calendario</h1></div>
   <div id="calendar" class="tarjeta_gris"></div>
  </div></div>
  <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
 </body>
</html>