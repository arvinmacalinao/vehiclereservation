<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="../plugins/fullcalendar/main.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
@include('layouts.navbars.nav')
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Calendar</h1>
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
    <div class="row">
      <div class="col-md-3">
      </div>
      @if(strlen($msg) > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ $msg }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      @endif
        <!-- /.col -->
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-body p-0">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="sticky-top mb-3">
                </div>
              </div>
              <!-- /.col -->
              
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    </div>
    @include('layouts.footer')
    <!-- ./wrapper -->
    <!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/fullcalendar/main.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            // Other configuration options...
            events: {!! json_encode($events) !!}, // Pass reservation data to FullCalendar
            eventBackgroundColor: '#377eb8',
            eventContent: function(info) {
                var reservationInfo = '<b>Purpose:</b> ' + info.event.title + '<br>';
                reservationInfo += '<b>Driver:</b> ' + info.event.extendedProps.driver + '<br>';
                reservationInfo += '<b>Vehicle:</b> ' + info.event.extendedProps.vehicle + '<br>';
                reservationInfo += '<b>Destination:</b> ' + info.event.extendedProps.destination + '<br>';
                
                // Convert time format from '19:47' to '7:47 PM'
                var timeParts = info.event.extendedProps.time.split(':');
                var hours = parseInt(timeParts[0]);
                var minutes = parseInt(timeParts[1]);
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // Handle midnight (0 hours)
                var formattedTime = hours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + ampm;
                
                return { html: '<div class="fc-content">' + formattedTime + '<br>' + reservationInfo + '</div>' };
            }
        });
        calendar.render();
    });
</script>
</body>
</html>