
@extends('backend.layouts.app')

@section('javascriptsContent')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>

@endsection

@section('headContent')

<style>
  .feedback-answer{
    font-size: 13px;
    color:orange;
  }
  .feedback-question{
    font-size: 13px; 
  }
</style>

@endsection


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users Feedbacks <b>({{$feedbacks->count()}})</b></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
            <li class="breadcrumb-item active">feedbacks</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      @foreach($feedbacks as $feedback)
      <div class="col-sm-4">
       <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title"><b>{{$feedback->User->name ?? $feedback->user_id." User" }}'s</b>  feedback</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
         <div class="class-feedback">
          <div class="feedback-question">Did you like our design/user interface of prepareurself?</div>
          <div class="feedback-answer">{{$feedback['answer1']}}</div>

          <div class="feedback-question">Did we have the selection(variety offered) you were looking for?</div>
          <div class="feedback-answer">{{$feedback['answer2']}}</div>

          <div class="feedback-question">Was it easy to find what you were looking for?</div>
          <div class="feedback-answer">{{$feedback['answer3']}}</div>

          <div class="feedback-question">How useful are the tech stack  resources?</div>
          <div class="feedback-answer">{{$feedback['answer4']}}</div>

          <div class="feedback-question">Do you prefer theory resources or video resources?</div>
          <div class="feedback-answer">{{$feedback['answer5']}}</div>

          <div class="feedback-question">Would you like to give any suggestions?</div>
          <div class="feedback-answer">{{$feedback['answer6']}}</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>


@endsection