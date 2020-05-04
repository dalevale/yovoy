<!DOCTYPE html>

<html>
 <head>
    <title>CALENDAR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'load.php',
    displayEventTime: false,
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "DD-MM-Y HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "DD-MM-Y HH:mm:ss");
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Added Successfully");
       }
      })
     }
    },
    editable:true,

    eventClick:function(event)
    {
      var title = event.title;
      var locat = event.locat;
      var eventInfo = event.eventInfo;
      var eventCap = event.eventCap;
      var eventAtt = event.eventAtt;
      var start = $.fullCalendar.formatDate(event.start, "DD-MM-Y HH:mm:ss");
      alert("\nEvento: " + title + "\nFecha evento: " + start + "\nInformación del evento: " + eventInfo + "\nLugar: " + locat
        + "\nAforo máximo: " + eventCap + "\nNúmero asistentes actuales: " + eventAtt);
    },
   });
  });
   
  </script>
 </head>
 <body>
  <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>
  <br></br>
  <div class="container">
   <div id="calendar" class="tarjeta_gris"></div>
  </div>
  <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
 </body>
</html>