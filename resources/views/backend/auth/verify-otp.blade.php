<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Verify OTP</title>
  <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Verify</b> OTP
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Enter the OTP sent to your email</p>

      <form action="{{ route('verify.otp') }}" method="POST">
        @csrf
        @error('otp')
          <small class="text-danger">{{ $message }}</small>
        @enderror
        <div class="input-group mb-3">
          <input type="number" name="otp" class="form-control" placeholder="Enter OTP">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-key"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Verify</button>
          </div>
        </div>
      </form>
      <form action="{{ route('resend.otp') }}" method="POST" class="mt-3 text-center">
        @csrf
        <button type="submit" class="btn btn-link">Didn't get the code? <strong>Resend OTP</strong></button>
      </form>
      
      @if (session('error'))
        <div class="mt-3 text-danger text-center">{{ session('error') }}</div>
      @endif
    </div>
  </div>
</div>

<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
