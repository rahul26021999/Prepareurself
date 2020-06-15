
@extends('backend.layouts.app')

@section('headContent')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">


@endsection

@section('javascriptsContent')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('AdminLTE/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- jquery-validation -->
<script src="{{ asset('AdminLTE/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script type="text/javascript">

  $('.my-colorpicker1').colorpicker();
  $(document).ready(function () {
    bsCustomFileInput.init();
    $.validator.setDefaults({
      submitHandler: function (form) {
        form.submit();
      }
    });
    $('#createCourse').validate({
      rules: {
        name: {
          required: true
        },
      },
      messages: {
        name: {
          required: "Please enter a name"
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

<script>
 function readURL(input,type) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      if(type==0){
        $('#showImage').attr('src', e.target.result)
      }
      else{
        $('#showLogo').attr('src', e.target.result)
      }
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@include('backend.layouts.summerNoteEditor',['height'=>'200'])

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit a Course</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/admin/course/all">Course</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="/admin/course/edit/{{$course['id']}}" id="createCourse" enctype="multipart/form-data">
      @csrf
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
             <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" value="{{$course['name']}}" class="form-control" placeholder="Enter ...">
            </div>
            <div class="row">
              <div class="col-sm-4">
                @php
                  $color=explode(',',$course['color']);
                @endphp
                <div class="form-group">
                  <label>Start Color</label>
                  <input type="text" name="color[]" value="{{ $color[0] ?? ''}}" required class="form-control my-colorpicker1">
                </div>
              </div>
              <div class="col-sm-4">
               <div class="form-group">
                <label>Center Color</label>
                <input type="text" name="color[]" value="{{ $color[1] ?? '' }}" required class="form-control my-colorpicker1">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>End Color</label>
                <input type="text" name="color[]" value="{{ $color[2] ?? '' }}" required class="form-control my-colorpicker1">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="textarea" name="description" placeholder="Place some text here">{{$course['description']}}</textarea>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="exampleInputFile">Background Image</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="courseImage" onchange="readURL(this)"
                value="{{url('/')}}/uploads/courses/{{$course['image_url']}}" 
                id="exampleInputFile">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text" id="">Upload</span>
              </div>
            </div>
          </div>
          <div class="text-center">
            <img src="{{url('/')}}/uploads/courses/{{$course['image_url']}}" id="showImage" alt="" width="auto" height="200">
          </div>
          <div class="form-group">
            <label for="logo">Course Logo</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" value="{{$course->logo_url}}" class="custom-file-input" name="logo" onchange="readURL(this,1)"
                id="logo">
                <label class="custom-file-label" for="logo">Choose file</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text">Upload</span>
              </div>
            </div>
          </div>
          <div class="text-center">
            <img src="{{$course['logo_url']}}" id="showLogo" width="auto" height="200">
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <a id="cancel" href="/admin/course/all"class="btn btn-danger">Cancel</a>
      <button type="submit" class="btn btn-primary float-right">Submit</button>
    </div>
  </div>
</form>
</section>
</div>

@endsection
