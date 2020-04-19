@extends('backend.auth.app')

@section('content')

@endsection

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{route('admin.resetPassword')}}"><b>Prepare</b>urself</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

      <form action="{{route('admin.resetPassword')}}" method="post" id="resetPasswordForm">
        <div class="input-group mb-3">
          @csrf
          <input type="hidden" name="id" value="{{$id}}">
          <input type="password" class="form-control" required="required" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="cpassword" required="required" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{route('admin.auth.login')}}">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

</body>

