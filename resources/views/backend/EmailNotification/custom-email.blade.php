
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

  $('#createEmail').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });

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

  $('.submitBtn').on('click',function(){
    
    var btn=$(this).data('value');
    
    if(btn=='draft'){
      $('#createEmail').attr('action', '/admin/email/save');
    }else if(btn=='sent'){
      $('#createEmail').attr('action', '/admin/email/send');
    }else if(btn=='test'){
      $('#createEmail').attr('action', '/admin/email/test');
    }

    var content=$('#froala-editor').val();
    $('#preview-email').html(content);
    $('#preview-email p[data-f-id="pbf"]').remove();
    $('#body').val($('#preview-email').html());

    $('#confirmModal').modal();

  });

  $('#continueSubmit').on('click',function(){
      $('#createEmail').submit();
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
        <form id="createEmail" method="post" action="#">
          @csrf
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                @if(isset($email))
                  <input type="hidden" name="id" value="{{$email['id'] ?? ''}}">
                  <input type="hidden" nam="type" value="{{$email['type'] ?? ''}}">
                @endif

                <input type="text" class="form-control" name="subject" placeholder="Subject Here.." required="required" value="{{$email['subject'] ?? ''}}">
              </div>
              <input type="hidden" name="body" id="body">
              <textarea id="froala-editor" data-height=300px required="required">{{$email['body'] ?? ""}}</textarea>
            </div>   
            <div class="card-footer">
              <button type="button" class="btn btn-primary submitBtn" data-value="test"><i class="far fa-envelope"></i> Test</button>
              <button type="button" class="btn btn-default submitBtn" data-value="draft"><i class="fas fa-pencil-alt"></i> Draft</button>
              <button type="button" class="btn btn-danger float-right submitBtn" data-value="sent"><i class="far fa-envelope"></i> Sent</button>
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


  <!-- Show Email Confirmation Modal -->

  <!-- Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleShowLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleShowLabel">Email Will look something like this</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div id="preview-email"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="continueSubmit">Continue</button>
          </div>
        </div>

    </div>
  </div>


</div>

@endsection


