
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
          <h1>Banners</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item active">Banners</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>See All Banners</b></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <a href="/admin/banner/create"class="btn btn-success mb-3">Create</a>
           
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Image</th>
                </tr>
              </thead>
              <tbody>
                @foreach($banners as $banner)
                <tr>
                  <td><a href ="" >#{{$banner['id']}}</a></td>
                  <td>{{$banner['title']}}</td>
                 <td>
                  @if($banner['status']=='publish')
                  <span class="right badge badge-danger">Publish</span>
                  @else
                  <span class="right badge badge-primary">Dev</span>
                  @endif
                  </td>
                  <td>
                    <a target="_blank" data-toggle="tooltip" title="View Image" href="/uploads/banners/{{$banner['image_url']}}" class="mr-3"><i class="fas fa-image text-success"></i></a>

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