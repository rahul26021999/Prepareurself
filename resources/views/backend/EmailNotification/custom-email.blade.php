
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

$(document).ready(function () {

  bsCustomFileInput.init();
  $('#createEmail').validate({
    rules: {
      subject: {
        required: true
      },
      body:{
        required:true
      }
    },
    messages: {
      subject: {
        required: "Please enter a subject"
      },
      body: {
        required: "Please enter a body"
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
      <div class="col-sm-9">
        <form id="createEmail" method="post" action="/admin/email/send">
          @csrf
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <input type="text" class="form-control" name="subject" placeholder="Subject Here..">
              </div>
              <textarea id="froala-editor" name="body">Email Body here ...</textarea>
            </div>   
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right">Save</button>
            </div>     
          </div>
        </form>
      </div>
      <div class="col-sm-3">
        <form id="createEmail" method="post" action="/admin/notification/send">
          @csrf
          <div class="card card-outline card-primary">
            <div class="card-header">
              Previous Saved Emails
            </div>
            <div class="card-body">
              
            </div>   
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

@endsection


