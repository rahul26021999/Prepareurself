
@extends('backend.layouts.app')

@section('headContent')
  <title>AdminLTE 3 | Editors</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

@endsection

@section('javascriptsContent')
<!-- jQuery -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<!-- Summernote -->
<script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
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
              <li class="breadcrumb-item active">Text Editors</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
              <div class="card-body">
                <form role="form">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Questions</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Option 1</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Option 2</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Option 3</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Option 4</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>Level</label>
                      <div class="form-group">
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary1" name="r1" checked>
                          <label for="radioPrimary1">
                            Easy
                          </label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary2" name="r1">
                          <label for="radioPrimary2">
                            Medium
                          </label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary3" name="r1">
                          <label for="radioPrimary3">
                            Hard
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                          <label>Type</label>
                          <select class="form-control">
                            <option>option 1</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                            <option>option 5</option>
                          </select>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
               <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  @endsection
 

