
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

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$total_user}}</h3>
                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$verified_user}}</h3>
                <p>Verified User</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$total_resources}}</h3>

                <p>Total Resources</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$total_projects}}</h3>

                <p>Total Projects</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
         <!--    <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$preferenced_user}}</h3>
                <p>User Preferences</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div> -->
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
           <!--  <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$token_user}}</h3>
                <p>User Preferences</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div> -->
          </div>
          <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-sm-12">
          <input type="text" id="token" class="form-control" value="{{ $JWTtoken }}">
          <button class="btn btn-warning" id="tokenCopy">Default JWT Token</button>
          <a class="btn btn-primary mb-3 mt-3 ml-2" href="/7Sd6c5pcpWvzqFf4tF7S9e2HDxGVgp/phpmyadmin/">Phpmyadmin</a>
          <a href="/admin/api/documentation" target="_blank" class="btn btn-success mb-3 mt-3 ml-2">API Documentation</a>
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