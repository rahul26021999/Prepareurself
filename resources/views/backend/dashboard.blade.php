
@extends('backend.layouts.app')

@section('javascriptsContent')

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<script src="{{ asset('AdminLTE/dist/js/pages/dashboard3.js')}}"></script>

<script type="text/javascript">

  $("#tokenCopy").on('click',function() {
    $("#token").select();
    document.execCommand('copy');

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      heightAuto:true,
      timer: 2000
    });

    Toast.fire({
      type: 'info',
      title: 'Copied to ClipBoard'
    });

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
        <div class="col-lg-6">
          <a class="btn btn-primary mb-3" href="/7Sd6c5pcpWvzqFf4tF7S9e2HDxGVgp/phpmyadmin/">Phpmyadmin</a>
          <div class="card card-primary">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title"><b>Default user details</b></h3>
              </div>
            </div>
            <div class="card-body">
              <a href="/api/documentation" target="_blank" class="btn btn-success mb-3">API Documentation</a>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" value="user@prepareurself.com">
              </div>
              <div class="form-group">
                <label for="email">Password</label>
                <input type="text" class="form-control" id="email" value="Pass@123">
              </div>


              <div class="form-group">
                  <label for="token">Token</label>
                <div class="input-group">
                  <input type="text" id="token"  class="form-control" value="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wcmVwYXJldXJzZWxmLnRrXC9hcGlcL2xvZ2luIiwiaWF0IjoxNTg3MjE5ODA1LCJleHAiOjE1OTQ5OTU4MDUsIm5iZiI6MTU4NzIxOTgwNSwianRpIjoiRDVyWDNxSnozb1hVR3FwUCIsInN1YiI6NiwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.54ZLUYD9X6UdrtQeYRdguR1I2o0OiIPiNgaWIc56vr8">

                  <div class="input-group-append">
                    <span class="input-group-text" id="tokenCopy" style="cursor: pointer;">Copy</span>
                  </div>
                </div>
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