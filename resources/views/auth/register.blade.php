<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Akun - Sistem Posyandu</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Bootstrap & AdminLTE -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #a8edea, #fed6e3);
    }
    .login-box {
      width: 950px;
    }
    .card {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    .login-left {
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      border-top-left-radius: 20px;
      border-bottom-left-radius: 20px;
    }
    .login-left img {
      max-height: 300px;
      width: auto;
      display: block;
      border-radius: 15px;
      margin-right: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .login-right {
      padding: 30px;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .text-link {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="card">
    <div class="row">
      <div class="col-md-5 login-left d-none d-md-flex">
        <img src="assets/img/germas.jpg" alt="Logo Germas" class="img-fluid" />
      </div>

      <div class="col-md-6 login-right">
        <div class="text-center">
          <h3 class="mb-4"><strong>Daftar Akun Posyandu</strong></h3>
        </div>

        {{-- Error --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('register-proses') }}" method="post">
          @csrf
        
          <div class="mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
          </div>
        
          <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
        
          <div class="mb-3">
            <label for="nik">NIK</label>
            <input type="text" name="nik" class="form-control" placeholder="Nomor Induk Kependudukan" required>
          </div>
        
          <div class="mb-3">
            <label for="phone">No. HP</label>
            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
          </div>
        
          <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
        
          <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
          </div>
        
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </div>
          </div>
        </form>
        
        <div class="text-link">
          <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
