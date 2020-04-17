
@extends('backend.layouts.app')

@section('javascriptsContent')

<!-- DataTables -->
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

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
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

  });


  $(".deleteButton").on('click',function() {
    var id=$(this).data('id');
    var title=$(this).data('title');

    $('#deleteResourceId').val(id);
    $('#deleteResourceTitleText').text(title);
    $('#deleteResourceTitle').val(title);       
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
          <h1>List of all Projects</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item">Projects</li>
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
            <a href="/admin/project/create"class="btn btn-success">New</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Course</th>
                  <th>Type|Level</th>

                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($Project as $project)
                <tr>                      
                  <td><a href ="" ># {{$project['id']}} </a></td>
                  <td>{{$project['name']}}</td>
                  <td><a href ="/admin/course/all" data-toggle="tooltip" title="Show all Projects" >{{$project['course']['name']}}</a></td>
                  <td>
                  @if($project['type']=='video')
                  <a target="_blank" data-toggle="tooltip" title="Video | Click to view" href="{{$project['link']}}" class="mr-3"><span class="right badge badge-info"> V </span></a>
                  @else
                  <a target="_blank" data-toggle="tooltip" title="Theory | Click to view" href="{{$project['link']}}" class="mr-3"><span class="right badge badge-primary"> T </span></a>
                  @endif
                  @if($project['level']=='easy')
                  <a data-toggle="tooltip" title="Easy" class="mr-3"><span class="right badge badge-success"> E </span></a>
                  @elseif($project['level']=='medium')
                  <a data-toggle="tooltip" title="Medium" class="mr-3"><span class="right badge badge-warning"> M </span></a>
                  @else
                  <a data-toggle="tooltip" title="Hard" class="mr-3"><span class="right badge badge-danger"> H </span></a>
                  @endif


                  </td>
                  <td>
                    <a href ="/admin/project/edit/{{$project['id']}}" data-toggle="tooltip" title="Edit"  class="mr-3"><i class="far fa-edit text-info"></i></a>
                    <a target="_blank" data-toggle="tooltip" title="View Image" href="/uploads/projects/{{$project['image_url']}}" class="mr-3"><i class="fas fa-image text-secondary"></i></a>
                    <i data-toggle="modal" data-title="{{$project['name']}}" data-id="{{$project['id']}}" data-target="#deleteModal" style="cursor: pointer;" class="deleteButton far fa-trash-alt text-danger"></i>

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


  <!-- Delete Modal -->

  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="post" action="{{route('admin.project.delete')}}">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are You sure ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <p>Are you sure you Want to delete Project - <b><span id="deleteResourceTitleText"></span></b> </p>
            @csrf
            <input type="hidden" name="title" id="deleteResourceTitle">
            <input type="hidden" name="id" id="deleteResourceId">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>

@endsection