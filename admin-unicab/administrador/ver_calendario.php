<html lang='en'>
    <head>
        <meta charset='utf-8' />
        <link href='fullcalendar/lib/main.css' rel='stylesheet' />
        <script src='fullcalendar/lib/main.js'></script>
        <script src='fullcalendar/lib/locales-all.js'></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var initialLocaleCode = 'es';
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    //initialView: 'dayGridMonth'
                    initialView: 'timeGridWeek',
                    nowIndicator: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    locale: initialLocaleCode,
                    navLinks: true,
                    events: [
                        {
                          title: 'Entrevista',
                          start: '2021-01-29T08:00:00'
                        },
                        {
                          title: 'Entrevista',
                          start: '2021-01-29T09:00:00'
                        },
                        {
                          title: 'Entrevista',
                          start: '2021-01-28T09:00:00'
                        }
                    ]
                });
                calendar.render();
            });
        
        </script>
        
        <style>
            #calendar {
                width: 70%;
            }
        </style>
    </head>
    <body>
        <div id='calendar'></div>
    </body>
</html>