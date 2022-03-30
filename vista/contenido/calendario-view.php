
  <div id='script-warning'>
    <code><?php echo SERVERURL?>/vista/calendario/examples/php/get-events.php</code> must be running.
  </div>

  <div id='loading'>loading...</div>

  <div id='calendar'></div>

  
		
		
    <!-- /.container -->
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
        
      },
      initialDate: '2020-09-12',
      editable: true,
      navLinks: true, // can click day/week names to navigate views
      dayMaxEvents: true, // allow "more" link when too many events
      events: {
        url: '<?php echo SERVERURL?>/vista/calendario/examples/php/get-events.php',
        failure: function() {
          document.getElementById('script-warning').style.display = 'block'
        }
      },
      loading: function(bool) {
        document.getElementById('loading').style.display =
          bool ? 'block' : 'none';
      }
    });

    calendar.render();
  });

</script>

