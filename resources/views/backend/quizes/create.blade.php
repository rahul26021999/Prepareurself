
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
          <h1>Add a new Quiz</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item active">Add Quiz</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="/admin/question/save" id="createQuestion">
      @csrf
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter ...">
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" class="form-control" placeholder="Enter ...">
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label>No. of Questions</label>
                <input type="number"  max=50 min=10 name="noOfQues" class="form-control" placeholder="Enter ...">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Time Span (In Sec)</label>
                <input type="number" name="timeSpan" min=10 max=120 class="form-control" placeholder="Enter ...">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Start Date and Time</label>
                <input type="datetime-local"  class="form-control" name="quizTime">
              </div>
            </div>
          </div>

          <div class="row" style="height: 500px;overflow: scroll;">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Select</th>
                  <th>Id</th>
                  <th>Question</th>
                  <th>Level</th>
                  <th>Type</th>                  
                </tr>
                </thead>
                <tbody>
                  @foreach($questions as $question)
                     <tr>
                      <td></td>
                      <td><a href ="" >#{{$question['id']}}</a></td>
                      <td>{{$question['question']}}</td>
                      @if($question['ques_level']=='easy')
                      <td><span class="right badge badge-success">E</span></td>
                      @elseif($question['ques_level']=='medium')
                      <td><span class="right badge badge-primary">M</span></td>
                      @else
                      <td><span class="right badge badge-danger">H</span></td>
                      @endif                      
                      <td>{{$question['ques_type']}}</td>
                      <!-- <td><a href ="/admin/question/edit/{{$question['id']}}" class="mr-3"><i class="far fa-edit text-info"></i></a><a href ="" ><i class="far fa-trash-alt text-danger"></i></a></td> -->
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
               
                </tfoot>
              </table>
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


