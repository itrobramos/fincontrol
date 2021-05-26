    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/fullcalendar-daygrid/main.min.css">
    <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/fullcalendar-timegrid/main.min.css">
    <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/fullcalendar-bootstrap/main.min.css">

    
@extends('layouts.business')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Proyectos Snowball</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/snowball">Snowball</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <br>
            <div class="row d-flex flex-row-reverse margin">
                    <a href="{{url('snowball/add')}}"><button type="button" class="btn btn-success">Registrar Compras</button></a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                       
                        @foreach($odis as $odi)

                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-primary card-outline" style="height: 350px;">
                                <button type="button" class="btn btn-default btn-block  dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu" style="">
                                    
                                        <form method='post' action="{{ url('/snowball/' . $odi->id) }}">
                                            {{ csrf_field()}}
                                            {{ method_field('DELETE')}}

                                            <button type="submit" class="btn btn-block" onclick="return confirm('¿Está seguro?');">
                                                <a class="dropdown-item"> 
                                                    <span class="btn-inner-icon">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </span> Borrar
                                                </a>
                                            </button>

                                            
                                        </form>

                                      
                                    </a>

                                </div>
                                
                                <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="img-fluid"
                                    src="{{ env('DEPLOY_URL') }}/{{ $odi->imageUrl }}" style="height: 60px;" alt="Logo">
                                </div>
                                <h4 class="profile-username text-center" style="font-size:18px;">{{ $odi->Name }}</h4>
                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Acciones</b> <a class="float-right">{{$odi->quantity}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Monto Invertido</b> <a class="float-right">$ {{$odi->investment}}</a>
                                  </li>
                                </ul>
                                <br>
                              </div>
                              <a href="snowball/{{$odi->id}}" class="btn btn-primary btn-block sticky-top"><b>Ver más</b></a>

                            </div>

                          </div>


                    @endforeach

                       
                          

                                   
                               
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->


             <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Calendario de pagos programados</h1>
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


        
    </div>



    <script>
        $(document).ready(function() {
            $('#stocktable').DataTable();
        });

    </script>

        <!-- jQuery -->
    <!-- fullCalendar 2.2.5 -->
    <script src="{{env('DEPLOY_URL')}}/plugins/moment/moment.min.js"></script>
    <script src="{{env('DEPLOY_URL')}}/plugins/fullcalendar/main.min.js"></script>
    <script src="{{env('DEPLOY_URL')}}/plugins/fullcalendar-daygrid/main.min.js"></script>
    <script src="{{env('DEPLOY_URL')}}/plugins/fullcalendar-timegrid/main.min.js"></script>
    <script src="{{env('DEPLOY_URL')}}/plugins/fullcalendar-interaction/main.min.js"></script>
    <script src="{{env('DEPLOY_URL')}}/plugins/fullcalendar-bootstrap/main.min.js"></script>
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
                        title : '$ {{ $paid->name }}',
                        start : '{{ $paid->date }}',
                        backgroundColor: '#007bff', //#007bff
                        borderColor : '#007bff', //#007bff
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

@endsection
