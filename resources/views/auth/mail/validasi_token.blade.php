<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password - Sistem Posyandu</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap">
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #fbc2eb, #a6c1ee);
    }
    .login-box {
      width: 500px;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }
    .btn-success {
      background-color: #28a745;
      border: none;
    }
    .btn-success:hover {
      background-color: #218838;
    }
    .text-center p {
      margin-top: 10px;
    }
  </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="card">
    <div class="text-center mb-4">
      <h3><strong>Reset Password</strong></h3>
      <p>Masukkan password baru untuk akun Anda</p>
    </div>

    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('reset-password-act') }}" method="POST">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label for="password">Password Baru</label>
        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        @error('password') 
        <small class="text-danger">{{ $message }}</small> 
        @enderror
      </div>

      <div class="mb-3">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
      </div>

      <div class="mb-3">
        <button type="submit" class="btn btn-success btn-block">Reset Password</button>
      </div>

      <div class="text-center">
        <p><a href="{{ route('login') }}">Kembali ke Login</a></p>
      </div>
    </form>
  </div>
</div>

<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#28a745'
    });
</script>
@endif

</body>
</html>
