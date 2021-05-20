@extends('layouts.business')


@section('content')

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Renta Fija</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        @foreach ($platforms as $platform)
                            <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                                <div class="card card-{{ $platform->tag }} card-outline" style="height: 200px;">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="img-fluid"
                                                src="{{ env('DEPLOY_URL') }}/images/{{ $platform->imageUrl }}" alt="Logo">
                                        </div>
                                        <h3 class="profile-username text-center"></h3>
                                    </div>
                                    <a href="{{ url('rentafija/' . $platform->id) }}"
                                        class="btn btn-{{ $platform->tag }} btn-block sticky-top"><b>Entrar</b></a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>





        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Calendario de pagos programados</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Calendar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <div id="divcalendar"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- fullCalendar 2.2.5 -->
    <script src="../plugins/moment/moment.min.js"></script>
    <script src="../plugins/fullcalendar/main.min.js"></script>
    <script src="../plugins/fullcalendar-daygrid/main.min.js"></script>
    <script src="../plugins/fullcalendar-timegrid/main.min.js"></script>
    <script src="../plugins/fullcalendar-interaction/main.min.js"></script>
    <script src="../plugins/fullcalendar-bootstrap/main.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function() {

                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    })

                })
            }

            //ini_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendarInteraction.Draggable;

            //var containerEl = document.getElementById('external-events');
            //var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('divcalendar');

            // initialize the external events
            // -----------------------------------------------------------------

            // new Draggable(containerEl, {
            //   itemSelector: '.external-event',
            //   eventData: function(eventEl) {
            //     console.log(eventEl);
            //     return {
            //       title: eventEl.innerText,
            //       backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
            //       borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
            //       textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
            //     };
            //   }
            // });

            var calendar = new Calendar(calendarEl, {
                plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                'themeSystem': 'bootstrap',
                //Random default events
                events: [
                    @foreach ($paids as $paid)
                        {
                        title : '$ {{ $paid->monto }}',
                        start : '{{ $paid->fecha }}',
                        backgroundColor: '{{ $paid->color }}', //red
                        borderColor : '{{ $paid->color }}', //red
                        allDay : true
                        },
                    @endforeach
                ],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(info) {
                    // is the "remove after drop" checkbox checked?
                    if (checkbox.checked) {
                        // if so, remove the element from the "Draggable Events" list
                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                    }
                }
            });

            calendar.render();

            /* ADDING EVENTS */
            var currColor = '#3c8dbc' //Red by default
            //Color chooser button
            var colorChooser = $('#color-chooser-btn')
            $('#color-chooser > li > a').click(function(e) {
                e.preventDefault()
                //Save color
                currColor = $(this).css('color')
                //Add color effect to button
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color': currColor
                })
            })
            $('#add-new-event').click(function(e) {
                e.preventDefault()
                //Get value and make sure it is not null
                var val = $('#new-event').val()
                if (val.length == 0) {
                    return
                }

                var event = $('<div />')
                event.css({
                    'background-color': currColor,
                    'border-color': currColor,
                    'color': '#fff'
                }).addClass('external-event')
                event.html(val)
                $('#external-events').prepend(event)

                ini_events(event)

                $('#new-event').val('')
            })
        })

    </script>
    </body>

    </html>


@endsection
