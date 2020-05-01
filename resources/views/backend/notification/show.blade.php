
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

   $(function () {
    // Summernote
    $('.textarea').summernote({
        height: 150,   //set editable area's height
        codemirror: { // codemirror options
          theme: 'monokai'
        }
      });
  });

  $(document).ready(function () {

    bsCustomFileInput.init();
    $.validator.setDefaults({
      submitHandler: function (form) {
        if(confirm("Please Check The content below from the attached Link"))
        {
          form.submit();  
        }
      }
    });
    $('#createNotification').validate({
      rules: {
        title: {
          required: true
        },
        link:{
          required:true
        },
        description:{
          required:true
        },
      },
      messages: {
        name: {
          required: "Please enter a name"
        },
        link: {
          required: "Please enter a link to image"
        },
        description: {
          required: "Please enter a description"
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

   function testNotification() {
        if ($('#createNotification').valid()) {
            $.ajax({
                type: "post",
                url: '/admin/notification/testNotification',
                data: $("#createNotification").serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.msg == '1') {
                        alert('testing done');
                    }
                }
            })
        }
    }
</script>

<script>
  
    readURL($("input[name='link'"));

function readURL(input) {
   $('#showURL').attr('src',$(input).val());
  }
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
    <form method="post" action="" id="createNotification" enctype="multipart/form-data">
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
                <input type="text" name="description" class="form-control" placeholder="Enter ...">
              </div>
              <div class="form-group">
                <label>Image Link Url</label>
                <input type="text" name="link" onchange="readURL(this)" class="form-control" placeholder="Enter ...">
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
          <button class="btn btn-primary float-right">Send to all</button>
           <button class="btn btn-primary float-left" onclick="testNotification();">Test</button>
        </div>
      </div>
    </form>
  </section>
</div>

@endsection


