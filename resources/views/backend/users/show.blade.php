@extends('backend.layouts.app')

@section('javascriptsContent')

@include('backend.layouts.datatables')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>

@endsection

@section('headContent')
  
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
              <h3 class="card-title">All users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Verified</th>
                  <th>Mode</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                <tr>
                  <td><a href="/admin/users/show/{{$user['id']}}">{{$user['id']}}</a></td>
                  <td>{{$user['first_name']}} {{$user['last_name']}}</td>
                  <td>{{$user['email']}}</td>
                  <td>
                    @if($user['status']=='blocked')
                    <span class="right badge badge-danger">Blocked</span>
                    @else
                    <span class="right badge badge-success">Active</span>
                    @endif
                  </td>
                  <td>
                    @if($user['email_verified_at']==null)
                    <span class="right badge badge-danger">No</span>
                    @else
                    <span class="right badge badge-success">yes</span>
                    @endif
                  </td>
                  <td>
                    @if($user['google_id']==null)
                    <span class="right badge badge-info">Email</span>
                    @else
                    <span class="right badge badge-success">Google</span>
                    @endif
                  </td>
                  <td></td>
                </tr>
                @endforeach
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