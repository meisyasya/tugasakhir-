<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - SIMESTI</title>

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
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      border-radius: 15px;
      margin-right: 8px; /* Menambahkan margin kanan untuk menggeser gambar ke kanan */
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
      <!-- Sisi Kiri: Logo -->
      <div class="col-md-5 login-left d-none d-md-flex">
        <img src="assets/img/germas.jpg" alt="Logo Germas" class="img-fluid" />
      </div>

      <!-- Sisi Kanan: Form Login -->
      <div class="col-md-6 login-right">
        <div class="text-center">
          <h3 class="mb-4"><strong>SIMESTI</strong></h3>
        </div>

        {{-- Error login --}}
        @error('loginError')
        <div class="alert alert-danger">
          <strong>Login Gagal!</strong>
          <p>{{ $message }}</p>
        </div>
        @enderror

    


        <form action="{{ route('login-proses') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="email">Email</label>
            <div class="input-group">
              <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
              <div class="input-group-append">
                <div class="input-group-text"><i class="fas fa-envelope"></i></div>
              </div>
            </div>
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="mb-3">
            <label for="password">Password</label>
            <div class="input-group">
              <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
              <div class="input-group-append">
                <div class="input-group-text"><i class="fas fa-lock"></i></div>
              </div>
            </div>
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="row mb-3">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <div class="col-6">
              <a href="{{ route('index') }}" class="btn btn-secondary btn-block">Lihat Website</a>
            </div>
          </div>
        </form>

        <div class="text-link">
          <p>Lupa Password? <a href="{{ route('forgot-password') }}">Klik di sini</a></p>
        </div>        
        <div class="text-link">
          <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
