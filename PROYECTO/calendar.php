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
        eventClick: function(event, jsEvent, view) {
            var title = event.event.title;
            var id = event.event.id;
            console.log(title);
            /*var locat = event.locat;
            var eventInfo = event.eventInfo;
            var eventCap = event.eventCap;
            var eventAtt = event.eventAtt;
            var start = $.fullCalendar.formatDate(event.start, "DD-MM-Y HH:mm:ss");*/
            window.location.href = 'eventItem.php?eventId='+id;
            //"\nEvento: " + title + "\nFecha evento: " + start + "\nInformaci�n del evento: " + eventInfo + "\nLugar: " + locat
            //+ "\nAforo m�ximo: " + eventCap + "\nN�mero asistentes actuales: " + eventAtt);
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
  <div class="container">
        <h1>Calendario</h1>
   <div id="calendar" class="tarjeta_gris"></div>
  </div></div>
  <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
 </body>
</html>