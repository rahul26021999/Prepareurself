
@extends('backend.layouts.app')

@section('headContent')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

@endsection

@section('javascriptsContent')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>

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
        option3:{
          required:true
        },
        option4:{
          required:true
        },
        level:{
          required:true
        },
        type:{
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
@include('backend.layouts.summerNoteEditor',['height'=>'100'])
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Question</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/admin/question/all">questions</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="/admin/question/edit/{{$question['id']}}" id="createQuestion">
      @csrf
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Questions</label>
                <textarea name="question" class="textareaLimited" class="form-control" rows="3" placeholder="Enter ...">{{ $question['question'] }}</textarea>
              </div>
            </div>

            @foreach ($question->Option as $index=>$option)
            <div class="col-sm-6">
              <div class="form-group">
                <label>Option {{$index+1}}</label>
                <textarea name="option{{$index+1}}" class="textareaLimited" class="form-control" placeholder="Enter ...">{{$option['option']}}</textarea>
              </div>
            </div>  
            @endforeach
            
            <div class="col-sm-6">
              <label>Level</label>
              <div class="form-group">
                <div class="icheck-success d-inline">
                  @if($question['ques_level']=='easy')
                  <input type="radio" id="radioPrimary1" checked value="easy" name="level">
                  @else
                  <input type="radio" id="radioPrimary1" value="easy" name="level">
                  @endif
                  <label for="radioPrimary1">
                    Easy
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  @if($question['ques_level']=='medium')
                  <input type="radio" id="radioPrimary2" checked value="medium" name="level">
                  @else
                  <input type="radio" id="radioPrimary2" value="medium" name="level">
                  @endif
                  <label for="radioPrimary2">
                    Medium
                  </label>
                </div>
                <div class="icheck-danger d-inline">
                  @if($question['ques_level']=='hard')
                  <input type="radio" id="radioPrimary3" checked value="hard" name="level">
                  @else
                  <input type="radio" id="radioPrimary3" value="hard" name="level">
                  @endif
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
                  @foreach ($question->Option as $index=>$option)
                    @if($question->Answer->option_id== $option->id)
                    <option value="{{$index+1}}"selected>option {{$index+1}}</option>
                    @else
                    <option value="{{$index+1}}">option {{$index+1}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Select Course Type</label>
                <select name="course_id" class="form-control">
                  @foreach ($courses as $course)
                    @if($course->id==$question['course_id'])
                    <option value="{{$course->id}}"selected>{{ $course->name }}</option>
                    @else
                    <option value="{{$course->id}}">{{$course->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

          </div>
        </div>
        <div class="card-footer">
          <a id="cancel" href="/admin/question/all"class="btn btn-danger">Cancel</a>
          <button type="submit" class="btn btn-primary float-right">Submit</button>
        </div>
      </div>
    </form>
  </section>
</div>

@endsection


