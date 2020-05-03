
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
    var title=$(this).data('title');

    $('#deleteResourceId').val(id);
    $('#deleteResourceTitleText').text(title);
    $('#deleteResourceTitle').val(title);       
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
            <button type="button" class="btn btn-danger mb-3 ml-3" data-toggle="modal" data-target="#changeMySequenceModal">Change Sequence</button>
            <a href="/admin/project/publish/{{$course['id']}}"class="btn btn-primary mb-3 ml-3">Publish all Project</a>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Seq</th>
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
                  <td>{{$project['sequence']}}</td>
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

   <!-- Change Sequence Modal -->

  <!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="changeMySequenceModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog"  role="document">
      <div class="modal-content">
       <form action="{{route('admin.project.sequence')}}" method="post">
        <div class="modal-header">
          @csrf
          <h5 class="modal-title" id="exampleModalScrollableTitle"><b>Change Sequence of Topics</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12" style="height:400px; overflow-y: scroll;">
             <ul id="sortable4" class="list-group list-unstyled">
              @foreach($Project as $project)
              <li class="list-group-item ui-state-default" id="listItem{{$project['id']}}" style="cursor: pointer;">
                <input type="hidden" name="id[]" value="{{$project['id']}}">
                <span><b>{{$project['sequence']}}</b>. &nbsp</span>
                <span>{{$project['name']}}</span>
                <span class="float-right"><i class="fas fa-thumbtack pin text-muted"  data-id="{{$project['id']}}" ></i></span>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
  </div>
</div>
</div>



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