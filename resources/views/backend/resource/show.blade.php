
@extends('backend.layouts.app')

@section('javascriptsContent')

@include('backend.layouts.datatables')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>

<script type="text/javascript">

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
  
@endsection


@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Resources In {{$topic['name']}}</h1>
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
          <div class="card">
            <div class="card-header">
              <a href="/admin/resource/create/{{$topic['id']}}" class="btn btn-success float-right">NEW</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Type</th>
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
                      <td>
                        <a href ="/admin/resource/edit/{{$resource['id']}}" data-toggle="tooltip" title="Edit"  class="mr-3"><i class="far fa-edit text-info"></i></a>
                            
                        <i data-toggle="modal" data-title="{{$resource['title']}}" data-id="{{$resource['id']}}" data-target="#deleteModal" style="cursor: pointer;" class="deleteButton far fa-trash-alt text-danger"></i>
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
      <form method="post" action="{{route('admin.resource.delete')}}">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are You sure ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <p>Are you sure you Want to delete <b><span id="deleteResourceTitleText"></span></b> </p>
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