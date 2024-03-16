<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EcosEth Cloud</title>
    <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">


    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/data-tables/dataTables.min.css') }}" />

    
  
    <style>
   
  :root {
    --hue: 223;
    --bg: hsl(var(--hue),90%,95%);
    --fg: hsl(var(--hue),90%,5%);
    --trans-dur: 0.3s;
  }
  .loader {
    color: var(--fg);
    font: 1em/1.5 sans-serif;
    display: grid;
    place-items: center;
    transition: background-color var(--trans-dur);
  }

  .loader-button {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 15px;
    height: 15px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
  }

  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .ip__track {
    stroke: hsl(var(--hue),90%,90%);
    transition: stroke var(--trans-dur);
  }
  .ip__worm1,
  .ip__worm2 {
    animation: worm1 2s linear infinite;
  }
  .ip__worm2 {
    animation-name: worm2;
  }

  /* Dark theme */
  @media (prefers-color-scheme: dark) {
    :root {
      --bg: hsl(var(--hue),90%,5%);
      --fg: hsl(var(--hue),90%,95%);
    }
    .ip__track {
      stroke: hsl(var(--hue),90%,15%);
    }
  }

  /* Animation */
  @keyframes worm1 {
    from {
      stroke-dashoffset: 0;
    }
    50% {
      animation-timing-function: steps(1);
      stroke-dashoffset: -358;
    }
    50.01% {
      animation-timing-function: linear;
      stroke-dashoffset: 358;
    }
    to {
      stroke-dashoffset: 0;
    }
  }
  @keyframes worm2 {
    from {
      stroke-dashoffset: 358;
    }
    50% {
      stroke-dashoffset: 0;
    }
    to {
      stroke-dashoffset: -358;
    }
  }
    </style>
        @vite(['resources/js/app.js'])

  </head>

  <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- /.sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')

        </div>

        @include('layouts.footer')

    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
      $(window).on('beforeunload', function(){
          $("#loader").removeClass('d-none');
      
      });
        
      $(function () {
      
        $("#loader").addClass('d-none');

      })
      
    </script>
    @yield('scripts')

  </body>
