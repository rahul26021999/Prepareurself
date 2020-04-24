
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

  function publishCourse(id,status){
    $.post('{{route("admin.course.publish")}}', {
        dataType:'json',
        type: 'POST',  // http method
        data: id  // data to submit
        success: function (data, status, xhr) {
          alert('hello');
            alert('status: ' + status + ', data: ' + data);
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log(errorMessage);
        }
    });
  }
  $('.publish').on('click',function(){
      alert("asdfkh");
      var status=$(this).data('status');
      var id=$(this).data('id');
      if(status=='publish'){
        status='dev';
      }
      else if(status=='dev'){
        status='publish';
      }
      publishCourse(id,status);

      // $(this).toggleClass('badge-success');
      // $(this).toggleClass('badge-danger');

  });

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
</script>

@endsection

@section('headContent')
  
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  
  <style type="text/css">
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
            <h1>All Courses</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
              <li class="breadcrumb-item active">courses</li>
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
            <dic class="card-header">
              <a href="/admin/course/create" class="btn btn-success">New</a>
            </dic>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>name</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($courses as $course)
                     <tr>
                      <td><a href ="" >#{{$course['id']}}</a></td>
                      <td>{{$course['name']}}</td>     
                      @if($course['status']=='publish')
                      <td><span data-status="{{$course['status']}}" data-id="{{$course['id']}}" class="right badge badge-success mr-3 publish">{{$course['status']}}</a></td>
                      @elseif($course['status']=='dev')
                      <td><span data-status="{{$course['status']}}" data-id="{{$course['id']}}" class="right badge badge-danger mr-3 publish">{{$course['status']}}</a></td>
                      @endif
                      <td>
                        <a href="/admin/course/edit/{{$course['id']}}" class="mr-3"><i class="far fa-edit text-info"></i></a>
                         <a target="_blank" data-toggle="tooltip" title="View Image" href="/uploads/courses/{{$course['image_url']}}" class="mr-3"><i class="fas fa-image text-success"></i></a>
                         <a target="_blank" data-toggle="tooltip" title="Add Topic" href ="/admin/topic/create/{{$course['name']}}" class="mr-3"><i class="fas fa-plus"></i></a>
                        <a data-toggle="tooltip" title="Go to Topics" href ="/admin/topic/all/{{$course['name']}}" class="mr-3"><ion-icon name="file-tray-stacked" class="text-body"></ion-icon></a>
                        <a href="/admin/project/all/{{$course['name']}}" title="Go to projects" class="right badge badge-warning mr-3">Projects </a>
                        <a href ="" ><i class="far fa-trash-alt text-danger"></i></a></td>
                       
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