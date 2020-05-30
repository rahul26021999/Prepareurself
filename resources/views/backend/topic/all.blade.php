
@extends('backend.layouts.app')

@section('javascriptsContent')

@include('backend.layouts.datatables')

<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

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
            <h1>List of All topics</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
              <li class="breadcrumb-item">Topics</li>
              <li class="breadcrumb-item active">All</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <a href="/admin/topic/create/"class="btn btn-success float-right">New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Course</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($courseTopic as $topic)
                     <tr>                      
                      <td><a href ="" >#{{$topic['id']}}</a></td>
                      <td>{{$topic['name']}}</td>
                      <td><a href ="/admin/topic/all/{{$topic['course']['name']}}" data-toggle="tooltip" title="Show all Topics in {{$topic['course']['name']}}" >{{$topic['course']['name']}}</a></td>
                      <td>
                        <a href ="/admin/topic/edit/{{$topic['id']}}" data-toggle="tooltip" title="Edit"  class="mr-3"><i class="far fa-edit text-info"></i></a>
                        <a href ="/admin/topic/edit/{{$topic['id']}}" data-toggle="tooltip" title="New Topic In {{$topic['course']['name']}}"  class="mr-3"><span class="right badge badge-success">Add</span></a>
                        <a target="_blank" data-toggle="tooltip" title="View Image" href="/uploads/topics/{{$topic['image_url']}}" class="mr-3"><i class="fas fa-image text-secondary"></i></a>
                        <a target="_blank" data-toggle="tooltip" title="Add Resource" href ="/admin/resource/create/{{$topic['id']}}" class="mr-3"><i class="fas fa-plus"></i></a>
                        <a target="_blank" data-toggle="tooltip" title="Go to Resources" href ="/admin/resource/all/{{$topic['id']}}" class="mr-3"><ion-icon name="file-tray-stacked" class="text-body"></ion-icon></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
               
                </tfoot>
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