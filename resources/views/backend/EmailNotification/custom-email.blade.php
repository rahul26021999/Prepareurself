
@extends('backend.layouts.app')

@section('headContent')

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

@include('backend.layouts.datatables')

<script>

  $('#createEmail').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });

</script>

<script type="text/javascript">

  $('#createEmail').validate({
    rules: {
      subject: {
        required: true
      },
    },
    messages: {
      subject: {
        required: "Please enter a subject"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

 $(".deleteButton").on('click',function() {
    var id=$(this).data('id');
    var title=$(this).data('subject');
    $('#deleteEmailSubject').html(title);
    $('#deleteEmailId').val(id);
    
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

    if($('#createEmail').valid()){
      if($('#preview-email').html()!=""){
        $('#confirmModal').modal();
      }else{
        alert("Body can't be empty");
      }
    }
    

  });

  $('#continueSubmit').on('click',function(){
    $('#createEmail').submit();
  });
</script>

@include('backend.layouts.floaraEditor')

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
                <input type="hidden" name="type" value="{{$email['type'] ?? ''}}">
                @endif

                <input type="text" class="form-control" name="subject" placeholder="Subject Here.." required="required" value="{{$email['subject'] ?? ''}}">
              </div>
              <input type="hidden" name="body" id="body">
              <textarea id="froala-editor" data-height=300px name="description" required="required">{{$email['body'] ?? ""}}</textarea>
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
                <th>Created by</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Send To</th>
                <th>Created on</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($emails as $email)
              <tr>
                <td>{{$email->Admin->name}}</td>
                <td><a href="/admin/email/compose/{{$email['id']}}">{{$email['subject']}}</a></td>
                @if($email['type']=='sent')
                <td><span class="badge badge-danger">{{$email['type']}}</span></td>
                @elseif($email['type']=='test')
                <td><span class="badge badge-success">{{$email['type']}}</span></td>
                @else
                <td><span class="badge badge-info">{{$email['type']}}</span></td>
                @endif
                @if($email['to']==null)
                <td></td>
                @else
                <td><b>{{count(explode(",",$email->to))}}</b> users</td>
                @endif
                <td>{{$email['created_at']}}</td>
                <td>
                 @if($email['type']=='draft' || $email['type']=='test')
                 <i data-toggle="modal" data-id="{{$email['id']}}" data-subject="{{$email['subject']}}" data-target="#deleteModal" class="pointer deleteButton far fa-trash-alt text-danger"></i>
                 @endif
               </td>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="/admin/email/delete">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Are You sure ?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you Want to delete <b><span id="deleteEmailSubject"></span></b> </p>
          @csrf
          <input type="hidden" name="id" id="deleteEmailId">
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


