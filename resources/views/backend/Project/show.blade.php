
@extends('backend.layouts.app')

@section('javascriptsContent')

<!-- DataTables -->
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<!-- page script -->
<script>

  function publishProject(id,status,element){
    $.ajax({
            url: '{{route("admin.project.publish")}}',
            method: 'post',
            async:false,
            data: {id:id,status:status,"_token":"{{ csrf_token() }}"},
            success: function (data, status, xhr) {
              if(data.success)
              {
                $(element).text(data.status);
                $(element).toggleClass('badge-success');
                $(element).toggleClass('badge-danger');
              }
              alert(data.message);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
                alert("Something Went Wrong Please Try Again After Sometime")
                return false;
            }
        });
  }
  $('.publish').on('click',function(){

      var status=$(this).data('status');
      var id=$(this).data('id');
      if(status=='publish'){
        status='dev';
      }
      else if(status=='dev'){
        status='publish';
      }
      publishProject(id,status,this)
  });


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
  $(".deleteButton").on('click',function() {
    var id=$(this).data('id');
    var title=$(this).data('name');
    var courseName=$(this).data('course');
    console.log(courseName);
    $('#deleteTopicCourseName').val(courseName);
    $('#deleteTopicId').val(id);
    $('#deleteTopicTitle').text(title);       
  });

  $("#sortable4").sortable({
    placeholder: 'drop-placeholder',
    items: "li:not(.ui-state-disabled)"
  });

  $(".pin").on('click',function(){
    var id=$(this).data('id');      
    $(this).toggleClass('text-light');
    $(this).toggleClass('text-muted');
    $('#listItem'+id).toggleClass('bg-danger');
    $('#listItem'+id).toggleClass('ui-state-disabled');

  });
</script>

@endsection

@section('headContent')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

<style type="text/css">
  .drop-placeholder {
    background-color: lightgray;
    height: 3.5em;
    padding-top: 12px;
    padding-bottom: 12px;
    line-height: 1.2em;
  }
    .publish{
    cursor: pointer;
  }
</style>
@endsection


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Projects in <b class="text-danger">{{$course['name']}}</b> Course</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item active">{{$course['name']}}</li>
            <li class="breadcrumb-item active">Projects</li>
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
            <h3 class="card-title"><b>See All Projects</b></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <a href="/admin/project/create/{{$course['name']}}"class="btn btn-success mb-3">New Project in {{$course['name']}}</a>
            <a href="/admin/project/publish/{{$course['id']}}"class="btn btn-primary mb-3 ml-3">Publish all Project</a>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Type | Level</th>
                  <th>Status</th>
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
                @foreach($Project as $project)
                <tr>
                  <td><a href ="" >#{{$project['id']}}</a></td>
                  <td>{{$project['name']}}</td>
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
                  @if($project['status']=='publish')
                  <td><span data-status="{{$project['status']}}" data-id="{{$project['id']}}" class="right badge badge-success mr-3 publish">{{$project['status']}}</a></td>
                  @elseif($project['status']=='dev')
                  <td><span data-status="{{$project['status']}}" data-id="{{$project['id']}}" class="right badge badge-danger mr-3 publish">{{$project['status']}}</a></td>
                  @endif
                  <td>
                    <a href ="/admin/project/edit/{{$project['id']}}" data-toggle="tooltip" title="Edit"  class="mr-3"><i class="far fa-edit text-info"></i></a>
                    <a target="_blank" data-toggle="tooltip" title="View Image" href="/uploads/projects/{{$project['image_url']}}" class="mr-3"><i class="fas fa-image text-success"></i></a>

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