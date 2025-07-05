<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <meta name="author" content="SDN Bulupayung 04">
  @stack('meta-seo')
  <title>@yield('title')</title>

  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">

  {{-- landing page --}}
  
  <!-- Favicons -->
  <link href="assets/img/logo1.jpg" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  {{-- panggil css dinamis per halaman  --}}
  @stack('css')
  <style>
    /* Sidebar background */
    .main-sidebar {
        background-color: #3374ff;
    }
    
    /* Sidebar user panel background */
    .user-panel {
        background-color: #3374ff;
    }
    
    /* Default sidebar link styles */
    .main-sidebar .nav-link {
        color: white !important; /* Teks putih default */
        transition: color 0.3s, background-color 0.3s;
        display: flex; /* Tambahkan ini agar item flex (icon dan p) bisa diatur */
        align-items: center; /* Pusatkan item secara vertikal */
        padding: 8px 15px; /* Atur padding default, sesuaikan jika perlu */
    }
    
    /* Hover sidebar link */
    .main-sidebar .nav-link:hover {
        background-color: #C70039;
        color: white !important;
    }
    
    /* Active sidebar link */
    .main-sidebar .nav-link.active {
        background-color: #e2e8f0 !important; /* Abu muda */
        color: #000000 !important;           /* Teks hitam */
        font-weight: 600;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border-radius: 5px;
        /* Kita tidak lagi perlu padding-left/right di sini karena sudah diatur di .nav-link default */
        /* Namun jika ingin padding active link berbeda, Anda bisa override di sini */
        padding: 8px 15px; /* Contoh: samakan dengan default, atau sesuaikan */
    }
    
    /* Icon di dalam SEMUA link (aktif dan tidak aktif) */
    .main-sidebar .nav-link .nav-icon {
        margin-right: 10px; /* Memberi jarak antara ikon dan teks */
        /* Pastikan warna ikon default juga putih jika tidak aktif */
        color: white; /* Default icon color for all nav-links */
    }
    /* Custom CSS untuk garis pemisah penuh di sidebar */
.sidebar-divider-full {
    height: 1px; /* Ketebalan garis */
    background-color: black; /* Warna hitam solid */
    margin: 10px 0; /* Jarak atas dan bawah */
    /* Properti penting untuk membuatnya memanjang penuh */
    margin-left: -20px; /* Offset padding kiri default nav-link (biasanya 20px) */
    margin-right: -20px; /* Offset padding kanan default nav-link (biasanya 20px) */
    /* Jika sidebar AdminLTE menggunakan padding yang berbeda, sesuaikan -20px ini */
    width: calc(100% + 40px); /* 100% lebar ditambah offset dari margin kiri/kanan */
    /* Atau, jika ingin lebih sederhana dan mungkin bekerja: */
    /* width: 100%; */
    /* padding: 0; */
}
    
    /* Icon di dalam active link */
    .main-sidebar .nav-link.active .nav-icon {
        color: #000000 !important; /* Ikon hitam untuk link aktif */
    }
    
    
    /* Bagian PENTING: Mengatur paragraf di dalam nav-link */
    .main-sidebar .nav-link p {
        flex-grow: 0;   /* Mencegah paragraf ini tumbuh memenuhi sisa ruang */
        flex-shrink: 0; /* Mencegah paragraf ini menyusut */
        padding-right: 20px; /* <--- Ini padding untuk teks di sisi kanan! Sesuaikan nilai ini. */
        white-space: nowrap; /* Mencegah teks wrap ke baris baru */
        overflow: hidden; /* Sembunyikan jika teks terlalu panjang */
        text-overflow: ellipsis; /* Tambahkan elipsis (...) jika teks terpotong */
    }
    
    
    /* User panel text */
    .user-panel .info h {
        color: rgb(14, 1, 1);
        font-size: 1.5rem;
        line-height: 1.2;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    /* Optional: kelas text sky blue */
    .text-sky-blue {
        color: #051629 !important;
    }

    /* logo */
    /* Untuk Logo Germas di user-panel */
.user-panel .info img {
    width: 120px; /* Atur lebar yang diinginkan, contoh 120px */
    height: auto; /* Agar proporsional */
    /* Anda juga bisa menambahkan max-width jika ingin tetap responsif tapi dengan batas */
    max-width: 100%; /* Pastikan tidak melebihi lebar induknya */
}
    
    </style>

  {{-- isi konten --}}
  @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">@yield('judul')</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">@yield('subjudul')</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center align-items-center">
        <div class="info text-center">
            <img src="{{ asset('assets/img/germas.jpg') }}" class="img-fluid w-75" alt="Logo Germas">
            </div>
    </div>
      
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel pb-3 mb-1 d-flex align-items-center">
          <div class="image me-3">
              <!-- Menampilkan gambar profil dengan path yang benar -->
              @if (auth()->user()->photo && \Illuminate\Support\Facades\Storage::exists('public/' . auth()->user()->photo))
                  <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="img-circle elevation-2" alt="User Image" style="width: 60px; height: 60px; object-fit: cover;">
              @else
              <div class="img-circle elevation-2" style="width: 60px; height: 60px; background-color: #ccc; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user" style="font-size: 30px; color: #fff;"></i>
            </div>
              @endif
          </div>
          <div class="info">
              <a href="#" class="d-block">
                  <b>Selamat datang,</b>
                  <br>
                  <span class="fs-5 text-sky-blue"><b>{{ explode(' ', auth()->user()->name)[0] ?? auth()->user()->name }}</b></span>
                </a>
          </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
         
        {{-- admin --}}
@if (auth()->user()->hasRole('admin'))      
<li class="nav-item">
  <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('admin.UsersIndex') }}" class="nav-link {{ request()->routeIs('admin.UsersIndex') ? 'active' : '' }}">
    <i class="nav-icon fas fa-user-plus"></i>
    <p>Pengguna</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('admin.DataAnakIndex') }}" class="nav-link {{ request()->routeIs('admin.DataAnakIndex') ? 'active' : '' }}">
    <i class="nav-icon fas fa-child"></i>  
    <p>Data Balita</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('admin.jadwalposyandu') }}" class="nav-link {{ request()->routeIs('admin.jadwalposyandu') ? 'active' : '' }}">
    <i class="nav-icon far fa-calendar-alt"></i>
    <p>Jadwal Posyandu</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('admin.RekomendasiIndex') }}" class="nav-link {{ request()->routeIs('admin.RekomendasiIndex') ? 'active' : '' }}">
    <i class="nav-icon fas fa-hand-holding-medical"></i>  
    <p>Rekomendasi</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('admin.DataDiagnosisIndex') }}" class="nav-link {{ request()->routeIs('admin.DataDiagnosisIndex') ? 'active' : '' }}">
    <i class="nav-icon fas fa-stethoscope"></i>
    <p>Diagnosis Stunting</p>
  </a>
</li> 

<li class="nav-item">
  <a href="{{ route('admin.rekapBulananIndex') }}" class="nav-link {{ request()->routeIs('admin.rekapBulananIndex') ? 'active' : '' }}">
    <i class="nav-icon fas fa-file-medical-alt"></i>
    <p>Rekap Bulanan</p>
  </a>
</li> 

<li class="nav-item">
  <a href="{{ route('admin.RekapStuntingIndex') }}" class="nav-link {{ request()->routeIs('admin.RekapStuntingIndex') ? 'active' : '' }}">
    <i class="nav-icon fas fa-user-injured"></i>
    <p>Rekap Stunting</p>
  </a>
</li> 

<li class="nav-item">
  <a href="{{ route('admin.pertumbuhananak') }}" class="nav-link {{ request()->routeIs('admin.pertumbuhananak', 'admin.rekap.tb_usia','rekap.bb_usia') ? 'active' : '' }}">
    <i class="nav-icon fas fa-clipboard-list"></i>
    <p>Pertumbuhan Anak</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('admin.DistribusiBantuanIndex') }}" class="nav-link {{ request()->routeIs('admin.DistribusiBantuanIndex') ? 'active' : '' }}">
    <i class="nav-icon fas fa-truck"></i>
    <p>Distribusi Bantuan</p>
  </a>
</li>
@endif






    @if (auth()->user()->hasRole('bidan'))
      <li class="nav-item">
          <a href="{{ route('bidan.dashboard') }}" class="nav-link {{ request()->routeIs('bidan.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
          </a>
      </li>

      <li class="nav-item">
          <a href="{{ route('bidan.UsersIndex') }}" class="nav-link {{ request()->routeIs('bidan.UsersIndex') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i> 
              <p>
                  Profile
              </p>
          </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('bidan.RekomendasiIndex') }}" class="nav-link {{ request()->routeIs('admin.RekomendasiIndex') ? 'active' : '' }}">
          <i class="nav-icon fas fa-hand-holding-medical"></i>  
          <p>Rekomendasi</p>
        </a>
      </li>


      <li class="nav-item">
         <a href="{{ route('bidan.DataAnakIndex') }}" class="nav-link {{ request()->routeIs('bidan.DataAnakIndex') ? 'active' : '' }}">
           <i class="nav-icon fas fa-child"></i>  
           <p>
             Data Balita 
           </p>
         </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('bidan.pertumbuhananak') }}" class="nav-link {{ request()->routeIs('bidan.pertumbuhananak') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
                Pertumbuhan Anak
            </p>
        </a>
    </li>

    <li class="nav-item">
      <div class="sidebar-divider-full"></div> 
  </li>

    
    <li class="nav-item">
      <a href="{{ route('bidan.rekapBulananIndex') }}" class="nav-link {{ request()->routeIs('bidan.rekapBulananIndex') ? 'active' : '' }}">
          <i class="nav-icon fas fa-file-medical-alt"></i>
          <p>
              Rekap Bulanan
          </p>
      </a>
  </li> 

<li class="nav-item">
    <a href="{{ route('bidan.RekapStuntingIndex') }}" class="nav-link {{ request()->routeIs('bidan.RekapStuntingIndex') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-injured"></i>
        <p>
            Rekap Stunting
        </p>
    </a>
</li> 

<li class="nav-item">
  <a href="{{ route('bidan.DistribusiBantuanIndex') }}" class="nav-link {{ request()->routeIs('bidan.DistribusiBantuanIndex','bidan.DistribusiBantuanEdit') ? 'active' : '' }}">
      <i class="nav-icon fas fa-truck"></i>
      <p>
          Distribusi Bantuan
      </p>
  </a>
</li>

<li class="nav-item">
  <div class="sidebar-divider-full"></div> 
</li>



    

    
   @endif

  
  
  
  
  @if (auth()->user()->hasRole('kader'))
     <li class="nav-item">
         <a href="{{ route('kader.dashboard') }}" class="nav-link {{ request()->routeIs('kader.dashboard') ? 'active' : '' }}">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>Dashboard</p>
         </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('kader.UsersIndex') }}" class="nav-link {{ request()->routeIs('kader.UsersIndex') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i> 
            <p>
                Profile
            </p>
        </a>
      </li>

      <li class="nav-item">
      <a href="{{ route('kader.jadwalposyandu') }}" class="nav-link {{ request()->routeIs('kader.jadwalposyandu') ? 'active' : '' }}">
          <i class="nav-icon far fa-calendar-alt"></i>
          <p>Jadwal Posyandu</p>
      </a>
     </li>

     <li class="nav-item">
        <a href="{{ route('kader.DataAnakIndex') }}" class="nav-link {{ request()->routeIs('kader.DataAnakIndex') ? 'active' : '' }}">
          <i class="nav-icon fas fa-child"></i>  
          <p>
            Data Balita 
          </p>
        </a>
    </li>
    
    <li class="nav-item">
      <div class="sidebar-divider-full"></div> 
  </li>

    <li class="nav-item">
      <a href="{{ route('kader.DataDiagnosisIndex') }}" class="nav-link {{ request()->routeIs('kader.DataDiagnosisIndex') ? 'active' : '' }}">
        <i class="nav-icon fas fa-stethoscope"></i>
        <p>Diagnosis Stunting</p>
      </a>
    </li> 

    <li class="nav-item">
      <a href="{{ route('kader.rekapBulananIndex') }}" class="nav-link {{ request()->routeIs('kader.rekapBulananIndex') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-medical-alt"></i>
        <p>Rekap Bulanan</p>
      </a>
    </li> 
    
    <li class="nav-item">
        <a href="{{ route('kader.DistribusiBantuanIndex') }}" class="nav-link {{ request()->routeIs('kader.DistribusiBantuanIndex') ? 'active' : '' }}">
            <i class="nav-icon fas fa-truck"></i>
            <p>
                Distribusi Bantuan
            </p>
        </a>
    </li>


    <li class="nav-item">
      <div class="sidebar-divider-full"></div> 
  </li>
    @endif
        

        
        @if (auth()->user()->hasRole('ortu') )
        <li class="nav-item">
          <a href="{{ route('ortu.dashboard') }}" class="nav-link {{ request()->routeIs('ortu.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
          </a>
      </li>  
      <li class="nav-item">
        <a href="{{ route('ortu.UsersIndex') }}" class="nav-link {{ request()->routeIs('ortu.UsersIndex') ? 'active' : '' }}" >
            <i class="nav-icon fas fa-user"></i> 
            <p>
                Profile
            </p>
        </a>
    </li>
         <li class="nav-item">
          <a href="{{ route('ortu.DataAnakIndex') }}" class="nav-link {{ request()->routeIs('ortu.DataAnakIndex') ? 'active' : '' }}">
            <i class="nav-icon fas fa-child"></i>
            <p>
              Data Balita Saya
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('ortu.pertumbuhananak') }}" class="nav-link {{ request()->routeIs('ortu.pertumbuhananak') ? 'active' : '' }}">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                  Pertumbuhan Anak
              </p>
          </a>
      </li>
  
        @endif


      @if (auth()->user()->hasRole('pemdes'))
      <li class="nav-item">
          <a href="{{ route('pemdes.dashboard') }}" class="nav-link {{ request()->routeIs('pemdes.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
          </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('pemdes.UsersIndex') }}" class="nav-link {{ request()->routeIs('pemdes.UsersIndex') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i> 
            <p>
                Profile
            </p>
        </a>
    </li>

      <li class="nav-item">
        <a href="{{ route('pemdes.RekapStuntingIndex') }}" class="nav-link {{ request()->routeIs('pemdes.RekapStuntingIndex') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-injured"></i>
            <p>
                Rekap Stunting
            </p>
        </a>
    </li> 
    
    <li class="nav-item">
      <a href="{{ route('pemdes.DistribusiBantuanIndex') }}" class="nav-link {{ request()->routeIs('pemdes.DistribusiBantuanIndex') ? 'active' : '' }}">
          <i class="nav-icon fas fa-truck"></i>
          <p>
              Distribusi Bantuan
          </p>
      </a>
    </li>
    @endif
        

        
          


  

    <li class="nav-item">
      <a href="{{ route('index') }}" target="_blank" class="nav-link" onclick="setHideLoginIcon()">
          <i class="nav-icon fas fa-link"></i>
          <p>Lihat Website</p>
      </a>
  </li>
      
        
    
          {{-- Landing Page --}}
          @if (auth()->user()->hasRole('admin'))
          <li class="nav-item">
            <div class="sidebar-divider-full"></div> 
        </li>
        
        <li class="nav-item ">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <span class="badge badge-info right">7</span>
                <p>
                    Landing Page
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.header') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Header</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.about') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tentang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.CategoriMakananIndex') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Menu Makanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.CategoryArticleIndex') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kategori Artikel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('admin.ArticleIndex') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Artikel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('admin.CategoryGaleriIndex') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Galeri</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.contact') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Contact</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.SosmedIndex') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sosial Media</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
          <div class="sidebar-divider-full"></div> 
      </li>

          @endif


           
          {{-- Logout --}}
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="resetHideLoginIcon();">
                <i class="nav-icon fas fa-arrow-left"></i>
                <p>Logout</p>
            </a>
        </li>


        {{-- <li class="nav-item">
      <a href="{{ route('admin.rekapdiagnosis') }}" class="nav-link">
          <i class="nav-icon fas fa-clipboard-list"></i>
          <p>
              Rekap diagnosis
          </p>
      </a>
  </li>  --}}
        

         
         
         
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
 @yield('content')
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="https://adminlte.io">by simesti</a></strong>

    {{-- <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div> --}}
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->



<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}""></script>
<!-- ChartJS -->
<script src="{{asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{asset('lte/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{asset('lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('lte/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('lte/dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('lte/dist/js/pages/dashboard.js') }}"></script>

<script>
 document.addEventListener('DOMContentLoaded', function () {
    const loginIcon = document.getElementById('loginIcon');

    // Pastikan localStorage tidak diatur untuk pertama kali akses
    if (localStorage.getItem('hideLoginIcon') === null) {
        localStorage.setItem('hideLoginIcon', 'false'); // Inisialisasi dengan 'false'
    }

    // Periksa status penyembunyian ikon login di localStorage
    const hideLoginIcon = localStorage.getItem('hideLoginIcon') === 'true';

    // Sembunyikan ikon login jika perlu
    if (loginIcon && hideLoginIcon) {
        loginIcon.style.display = 'none';
    }
});

// Fungsi untuk menyembunyikan ikon login setelah klik "Lihat Website"
function setHideLoginIcon() {
    localStorage.setItem('hideLoginIcon', 'true'); // Tandai bahwa ikon login perlu disembunyikan
}

// Fungsi untuk menghapus status penyembunyian (opsional)
function resetHideLoginIcon() {
    localStorage.removeItem('hideLoginIcon');
}

</script>


  {{-- panggil js dinamis per halaman  --}}
  @stack('js')
{{-- datatable --}}
@yield('scripts')
</body>
</html>
