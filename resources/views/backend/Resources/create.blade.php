
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

<script type="text/javascript">
  $(document).ready(function () {

    $.validator.setDefaults({
      submitHandler: function (form) {
        form.submit();
      }
    });
    $('#createQuestion').validate({
      rules: {
        question: {
          required: true
        },
        option1:{
          required:true
        },
        option2:{
          required:true
        },
        level:{
          required:true
        }
      },
      messages: {
        question: {
          required: "Please enter a question"
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

    $('#addTypeBtn').click(function(){
        var val=$('#newType').val();
        if(val!='')
        {
          $('#quesType').append(`<option value="${val}" selected>${val}</option>`); 
          $('#newType').val('');
        }
        else{
          alert("Question Type Can't be Empty");
        }
    });
  });
</script>

<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
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
          <h1>Add a new Question</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/admin/question/all">questions</a></li>
            <li class="breadcrumb-item active">New</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="/admin/question/create" id="createQuestion">
      @csrf
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Questions</label>
                <textarea name="question" class="form-control" rows="3" placeholder="Enter ..."></textarea>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Option 1</label>
                <input type="text" name="option1" class="form-control" placeholder="Enter ...">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Option 2</label>
                <input type="text" name="option2" class="form-control" placeholder="Enter ...">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Option 3</label>
                <input type="text" name="option3" class="form-control" placeholder="Enter ...">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Option 4</label>
                <input type="text" name="option4" class="form-control" placeholder="Enter ...">
              </div>
            </div>
            <div class="col-sm-6">
              <label>Level</label>
              <div class="form-group">
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary1" checked value="easy" name="level">
                  <label for="radioPrimary1">
                    Easy
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary2" value="medium" name="level">
                  <label for="radioPrimary2">
                    Medium
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary3" value="hard" name="level">
                  <label for="radioPrimary3">
                    Hard
                  </label>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Answer</label>
                <select name="answer" class="form-control">
                  <option value="1">option 1</option>
                  <option value="2">option 2</option>
                  <option value="3">option 3</option>
                  <option value="4">option 4</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Select Question Type</label>
                <select name="type" id="quesType" class="form-control">
                  @isset($quesType)
                  @foreach ($quesType as $type)
                    <option value="{{ $type }}" selected>{{ $type }}</option>
                  @endforeach
                  @endisset
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Add New Question Type</label>
                 <div class="input-group">
                  <input type="text" id="newType" class="form-control">
                  <span class="input-group-append">
                    <button type="button" id="addTypeBtn" class="btn btn-info btn-flat">Add</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary float-right">Submit</button>
        </div>
      </div>
    </form>
  </section>
</div>

@endsection


