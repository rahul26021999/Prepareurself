@extends('backend.layouts.app')

@section('headContent')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.css')}}">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

@endsection

@section('javascriptsContent')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<!-- Summernote -->
<script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>

<!-- jquery-validation -->
<script src="{{ asset('AdminLTE/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/jquery-validation/additional-methods.min.js')}}"></script>

<!-- bs-custom-file-input -->
<script src="{{ asset('AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script type="text/javascript">

  $( "#screen" ).on('change',function() {
    if($(this).val()=="app" || $(this).val()=="feedback")
    {
      $('#screen_id').hide();
    }
    else{
      $('#screen_id').show();
    }
  });

  function readURL(input) {
   $('#showURL').attr('src',$(input).val());
}


$(document).ready(function () {

  bsCustomFileInput.init();
  $('#createNotification').validate({
    rules: {
      title: {
        required: true
      },
      message:{
        required:true
      },
      id:{
        required:true
      }
    },
    messages: {
      title: {
        required: "Please enter a name"
      },
      message: {
        required: "Please enter a message"
      },
      id:{
        required:"Please Enter Id"
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
          <h1>Send Email Notification</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item">Email</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <form id="createNotification" method="post" action="/admin/notification/send">
          @csrf
          <div class="card card-outline card-primary">
            <div class="card-header">
              <a href="/admin/email/compose" class="btn btn-primary">Send Custom Email</a>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Which Type of Email You want to send To users</label>
                    <select name="screen" id="screen" class="form-control">
                      <option value="app">New Course Added</option>
                      <option value="project">New Resources Added</option>
                      <option value="theory">New Projects Added</option>
                      <option value="video">Particular Project</option>
                      <option value="feedback">Feedback Notification</option>
                      <option value="profile" disabled="disabled">Set Your Prefrences Email</option>
                    </select>
                  </div>
                  <div class="form-group" id="course_id">
                    <label for="course_id">Course Id</label>
                    <input type="number"  class="form-control"  name="course_id">
                  </div>
                  <div class="form-group" id="project_id">
                    <label for="project_id">Project Id</label>
                    <input type="number"  class="form-control" name="project_id">
                  </div>
                </div>
              </div>
            </div>   
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right">Send</button>
            </div>     
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

@endsection


