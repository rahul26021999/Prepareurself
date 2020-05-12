
@extends('backend.layouts.app')

@section('javascriptsContent')

<!-- DataTables -->
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

@endsection

@section('headContent')
  
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  
  
@endsection


@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">{{$user['name']}}'s Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <td colspan="2" class="text-center"><img src="{{$user->image}}" height="100px"></td>
                  </tr>
                  <tr>
                    <td><b>Name</b></td>
                    <td>{{$user['name']}}</td>
                  </tr>
                  <tr>
                    <td><b>Email</b></td>
                    <td>{{$user['email']}}</td>
                  </tr>
                  <tr>
                    <td><b>Date of Birth</b></td>
                    <td>{{$user['dob']}}</td>
                  </tr>
                  <tr>
                    <td><b>Phone number</b></td>
                    <td>{{$user['phone_number']}}</td>
                  </tr>
                  <tr>
                    <td><b>Android Token</b></td>
                    <td>{{$user['android_token']}}</td>
                  </tr>
                  <tr>
                    <td><b>Preferences</b></td>
                    <td>{{$user['preferences']}}</td>
                  </tr>
                  <tr>
                    <td><b>Joined on</b></td>
                    <td>{{$user['created_at']}}</td>
                  </tr>
                  <tr>
                    <td><b>Email Verified</b></td>
                    <td>{{$user['email_verified_at']}}</td>
                  </tr>
                </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection