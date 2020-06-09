
@extends('backend.layouts.app')

@section('javascriptsContent')

@include('backend.layouts.datatables')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>

@endsection

@section('headContent')
  
@endsection


@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
              <li class="breadcrumb-item active">questions</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">All Question</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Question</th>
                  <th>Level</th>
                  <th>Course</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($questions as $question)
                     <tr>
                      <td><a href ="" >#{{$question['id']}}</a></td>
                      <td>{!! html_entity_decode($question['question']) !!}</td>
                      @if($question['ques_level']=='easy')
                      <td><span class="right badge badge-success">Easy</span></td>
                      @elseif($question['ques_level']=='medium')
                      <td><span class="right badge badge-primary">Medium</span></td>
                      @else
                      <td><span class="right badge badge-danger">Hard</span></td>
                      @endif                      
                      <td>{{$question->Course->name}}</td>
                      <td><a href ="/admin/question/edit/{{$question['id']}}" class="mr-3"><i class="far fa-edit text-info"></i></a><a href ="" ><i class="far fa-trash-alt text-danger"></i></a></td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
               
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection