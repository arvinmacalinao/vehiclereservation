<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vehicle Reservation | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

  <!-- Styles -->
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Vehicle </b>Reservation</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session
        @if(strlen($msg) > 0)
        <div class="text-danger p-2 fs-5 fw-bold"> {{ $msg }} </div>
        @endif
      </p>

     

      <form class="form" method="POST" action="{{ route('users.login') }}">
        @csrf
        <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="fas fa-envelope m-1"></i>
              </span>
          </div>
          <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" type="text" autocomplete="username" placeholder="Username" name="username" id="username" maxlength="255" required="required" value="{{ old('username') }}" autofocus>
          
          @if ($errors->has('username'))
              <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('username') }}</strong>
              </span>
          @endif
        </div>

        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-lock m-1"></i>
                </span>
            </div>
            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="Password" name="password" id="password" maxlength="255" required="required">
            
            @if ($errors->has('password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-round">{{ __('Sign in') }}</button>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        {{-- <a class="nav-link" style="cursor: pointer" data-toggle="modal" data-target="#registerModal">{{ __('Forgot Password') }}</a> --}}
        <a class="nav-link" style="cursor: pointer" data-toggle="modal" data-target="#registerModal">{{ __('Register') }}</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="registerModal">{{ __('Register new account') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form class="form" method="POST" action="{{ route('users.register') }}">
                  @csrf
                  <div class="form-group row">
                      <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                      <div class="col-md-6">
                          <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"  autocomplete="first_name" autofocus>

                          <span class="invalid-feedback" role="alert" id="first_name">
                              <strong></strong>
                          </span>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                    <div class="col-md-6">
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"  autocomplete="name" autofocus>

                        <span class="invalid-feedback" role="alert" id="last_name">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                  <div class="form-group row">
                      <label for="emailInput" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                      <div class="col-md-6">
                          <input id="emailInput" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">

                          <span class="invalid-feedback" role="alert" id="emailError">
                              <strong></strong>
                          </span>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="passwordInput" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                      <div class="col-md-6">
                          <input id="passwordInput" type="password" class="form-control" name="password" required autocomplete="new-password">

                          <span class="invalid-feedback" role="alert" id="passwordError">
                              <strong></strong>
                          </span>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                      <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                      </div>
                  </div>

                  <div class="form-group row mb-0">
                      <div class="col-md-6 offset-md-4">
                          <button type="submit" class="btn btn-primary">
                              {{ __('Register') }}
                          </button>
                      </div>
                  </div>
            </form>
          </div>
      </div>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<script>
  $(function () {
      $('#registerForm').submit(function (e) {
          e.preventDefault();
          let formData = $(this).serializeArray();
          $(".invalid-feedback").children("strong").text("");
          $("#registerForm input").removeClass("is-invalid");
  
      });
  })
  </script>
</body>
</html>
