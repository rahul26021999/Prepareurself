
@extends('backend.layouts.app')

@section('headContent')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

<style>
  .pointer{
    cursor: pointer;
  }
</style>

@endsection

@section('javascriptsContent')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>

<!-- jquery-validation -->
<script src="{{ asset('AdminLTE/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/jquery-validation/additional-methods.min.js')}}"></script>

<!-- DataTables -->
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
  $(function () {
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

<script type="text/javascript">

  $('.email-container').on('click',function(){
      var id=$(this).data('id');
      location.href='/admin/email/compose/'+id;
  });


</script>

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Send Custom Email</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item">Custom Email</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- <button type="submit" class="btn btn-primary float-right">Send</button> -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-8">
        <form id="createEmail" method="post" action="/admin/email/send">
          @csrf
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <input type="text" class="form-control" name="subject" placeholder="Subject Here.." required="required" value="{{$email['subject'] ?? ''}}">
              </div>
              <textarea id="froala-editor" data-height=300px name="body" required="required">{{$email['body'] ?? ""}}</textarea>
            </div>   
            <div class="card-footer">
              <button type="submit" formaction="/admin/email/test" class="btn btn-primary"><i class="far fa-envelope"></i> Test</button>
              <button type="submit" formaction="/admin/email/save" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>
              <button type="submit" class="btn btn-danger float-right"><i class="far fa-envelope"></i> Send</button>
            </div>     
          </div>
        </form>
      </div>
      <div class="col-sm-12" >
        <div class="card card-outline card-primary">
          <div class="card-header">
            Previous Emails
          </div>
          <div class="card-body">
            <table id="example2" class="table table-hover">
             <thead>
                <tr>
                  <th>Subject</th>
                  <th>Type</th>
                  <th>Created on</th>
                </tr>
                </thead>
              <tbody>
                @foreach($emails as $email)
                <tr class="email-container pointer" data-id="{{$email['id']}}">
                 <td>{{$email['subject']}}</td>
                 @if($email['type']=='sent')
                 <td><span class="badge badge-danger">{{$email['type']}}</span></td>
                 @else
                 <td><span class="badge badge-success">{{$email['type']}}</span></td>
                 @endif
                 <td>{{$email['created_at']}}</td>
                </tr>
                @endforeach      
              </tbody>
            </table>       
          </div>   
        </div>
      </div>
    </div>
  </section>
</div>

@endsection


