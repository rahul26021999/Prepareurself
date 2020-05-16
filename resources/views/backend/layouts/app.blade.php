<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Prepareurself | Dashboard </title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  @yield('headContent')
  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <!-- Include all Editor plugins CSS style. -->
  <link rel="stylesheet" href="{{ asset('FroalaEditor/css/froala_editor.pkgd.min.css') }}">

  <!-- Include Code Mirror CSS. -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">

  <div class="wrapper">

    @include('backend.layouts.sidenav')

    @yield('content')

    @include('backend.layouts.footer')   

  </div>
  <!-- REQUIRED SCRIPTS -->

    <!-- Include all Editor plugins JS files. -->
  <script type="text/javascript" src="{{ asset('FroalaEditor/js/froala_editor.pkgd.min.js')}}"></script>

  <!-- Include Code Mirror JS. -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

  <!-- Include PDF export JS lib. -->
  <script type="text/javascript" src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

  <script>
    new FroalaEditor('textarea#froala-editor',{
        height: 400,
    })
  </script>


  <!-- jQuery -->
  <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>   
  
  <!-- SweetAlert2 -->
  <script src="{{ asset('AdminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

  @include('backend.layouts.modal')

  @yield('javascriptsContent')
  
</body>
</html>