
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

  function publishBanner(id,status,element){
    $.ajax({
            url: '{{route("admin.banner.publish")}}',
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
      publishBanner(id,status,this)
  });
   $(".deleteButton").on('click',function() {
    var id=$(this).data('id');
    var title=$(this).data('title');

    $('#deleteResourceId').val(id);
    $('#deleteResourceTitleText').text(title);
    $('#deleteResourceTitle').val(title);       
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
        <div class="card card-outline card-primary">
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
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($banners as $banner)
                <tr>
                  <td><a href ="" >#{{$banner['id']}}</a></td>
                  <td>{{$banner['title']}}</td>
                 <td>
                  @if($banner['status']=='publish')
                  <span class="right badge badge-danger publish" data-id="{{$banner['id']}}" data-status="{{$banner['status']}}">Publish</span>
                  @else
                  <span class="right badge badge-primary publish" data-id="{{$banner['id']}}" data-status="{{$banner['status']}}">Dev</span>
                  @endif
                  </td>
                  <td>
                    <a target="_blank" data-toggle="tooltip" title="View Image" href="{{$banner['image_url']}}" class="mr-3"><i class="fas fa-image text-success"></i></a>
                    <a href ="/admin/banner/edit/{{$banner['id']}}" data-toggle="tooltip" title="Edit"  class="mr-3"><i class="far fa-edit text-info"></i></a>
                    <i data-toggle="modal" data-title="{{$banner['title']}}" data-id="{{$banner['id']}}" data-target="#deleteModal" style="cursor: pointer;" class="deleteButton far fa-trash-alt text-danger"></i>
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
      <form method="post" action="{{route('admin.banner.delete')}}">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are You sure ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <p>Are you sure you Want to delete this banner - <b><span id="deleteResourceTitleText"></span></b> </p>
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