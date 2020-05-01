
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
            <h1>All Resources</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
              <li class="breadcrumb-item"><a href="/admin/home">course</a></li>
              <li class="breadcrumb-item"><a href="/admin/home">topic</a></li>
              <li class="breadcrumb-item">Resources</li>
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
              <h3 class="card-title">All Resources</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Type</th>
                  <th>Topic</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($resources as $resource)
                     <tr>
                      <td><a href ="" >#{{$resource['id']}}</a></td>
                      <td>{{$resource['title']}}</td>
                      @if($resource['type']=='video')
                      <td><a target="_blank" data-toggle="tooltip" title="Click to view" href="{{$resource['link']}}" class="mr-3"><span class="right badge badge-info">{{$resource['type']}}</span></a></td>
                      @else
                      <td><a target="_blank" data-toggle="tooltip" title="Click to view" href="{{$resource['link']}}" class="mr-3"><span class="right badge badge-primary">{{$resource['type']}}</span></a></td>
                      @endif
                      <td><a target="_blank" href ="/admin/resource/all/{{$resource['course_topic_id']}}" data-toggle="tooltip" title="View All Resources in {{$resource['courseTopic']['name']}}" >{{$resource['courseTopic']['name']}}</a></td>
                      <td>
                        <a href ="/admin/resource/edit/{{$resource['id']}}" data-toggle="tooltip" title="Edit"  class="mr-3"><i class="far fa-edit text-info"></i></a>
                        <a href ="/admin/resource/create/{{$resource['course_topic_id']}}" data-toggle="tooltip" title="New Resource in {{$resource['courseTopic']['name']}} "  class="mr-3"><i class="fas fa-plus text-info"></i></a>
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