
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
          <h1>Notification</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form id="createNotification" method="post" action="/admin/notification/send">
      @csrf
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title">Send Android Notifications</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Title Of Notification</label>
                <input type="text" name="title" class="form-control" placeholder="Enter ...">
              </div>
              <div class="form-group">
                <label>Description Of Notification</label>
                <input type="text" name="message" class="form-control" placeholder="Enter ...">
              </div>
              <div class="form-group">
                <label>Image Link Url (optional)</label>
                <input type="text" name="image" onchange="readURL(this)" class="form-control" placeholder="Enter ...">
              </div>
              <div class="row">
                <div class="col-sm-9">
                   <div class="form-group">
                    <label>Select Screen</label>
                    <select name="screen" id="screen" class="form-control">
                      <option value="app">Open App</option>
                      <option value="project">Open Project</option>
                      <option value="theory">Open Theory Resource</option>
                      <option value="video">Open Video Resource</option>
                      <option value="feedback">Open Feedback Page</option>
                      <option value="profile" disabled="disabled">Open Profile</option>
                      <option value="course" disabled="disabled">Open Course</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3" style="display: none;" id="screen_id" >
                  <div class="form-group">
                     <label>Id</label>
                    <input type="number" name="id" class="form-control" placeholder="">
                  </div>    
                </div>
              </div>
              
            </div>
            <div class="col-sm-6">
              <h3 style="text-align: center;">Image in Link</h3> 
              <iframe id="showURL" width="100%" height="350" src="https://cdn.dribbble.com/users/727458/screenshots/4153279/dribbble-icons.jpg">
              </iframe>
            </div>
            </div>
          </div>
        </div>    
        <div class="card-footer">
          <button type="submit" class="btn btn-primary float-right">Send to All</button>
          <button type="submit" formaction="/admin/notification/test" class="btn btn-primary float-left">Test</button>
        </div>
      </div>
    </form>
  </section>
</div>

@endsection


