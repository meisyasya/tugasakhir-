<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lupa Password - Sistem Posyandu</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap">
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #a8edea, #fed6e3);
    }
    .login-box {
      width: 500px;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
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
      <h3><strong>Lupa Password</strong></h3>
      <p>Masukkan email Anda yang terdaftar</p>
      <p>untuk mengatur ulang password.</p>
    </div>

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('forgot-password-act') }}">
      @csrf
      <div class="mb-3">
        <label for="email">Email</label>
        <div class="input-group">
          <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
          </div>
        </div>
        @error('email') 
        <small class="text-danger">{{ $message }}</small> 
        @enderror
      </div>

      <div class="mb-3">
        <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset</button>
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
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK',
        confirmButtonColor: '#6f42c1' // sesuai tombol ungu di gambar
    });
</script>
@endif
@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}",
    });
</script>
@endif

</body>
</html>
