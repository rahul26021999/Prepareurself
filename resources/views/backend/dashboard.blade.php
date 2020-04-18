
@extends('backend.layouts.app')

@section('javascriptsContent')

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>
  <script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
  <script src="{{ asset('AdminLTE/dist/js/pages/dashboard3.js')}}"></script>

  <script type="text/javascript">
    $(".copy").on('click',function() {
        $(this).select();
        document.execCommand('copy');
    });
  </script>

@endsection


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">Default user details</h3>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold">Email</span>
                  <span class="text-bold">Password</span>
                  <span class="text-bold">JWT Token</span>
                </p>
                <p class="ml-auto d-flex flex-column text-right">
                  <span class="text-success" style="cursor: copy;">
                    user@prepareurself.com
                  </span>
                  <span class="text-success" style="cursor: copy;">
                    Pass@123
                  </span>
                  <span class="text-success" style="word-break: break-all;cursor:pointer;">
                    eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wcmVwYXJldXJzZWxmLnRrXC9hcGlcL2xvZ2luIiwiaWF0IjoxNTg3MjE5ODA1LCJleHAiOjE1OTQ5OTU4MDUsIm5iZiI6MTU4NzIxOTgwNSwianRpIjoiRDVyWDNxSnozb1hVR3FwUCIsInN1YiI6NiwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.54ZLUYD9X6UdrtQeYRdguR1I2o0OiIPiNgaWIc56vr8
                  </div>
                </p>
              </div>
            
            </div>
          </div>
      
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection