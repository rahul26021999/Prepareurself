<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  @yield('headContent')

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

  @yield('javascriptsContent')
  
</body>
</html>