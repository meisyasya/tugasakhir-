<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sipenting</title>
    <meta content="Situs informasi penting mengenai kesehatan dan makanan bergizi." name="description">
    <meta content="kesehatan, makanan sehat, gizi, germas, artikel kesehatan" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logo1.jpg" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Amatic+SC:wght@400;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Yummy
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
  </head>

  <body>

    <!-- ======= Navbar ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="container d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center me-auto me-lg-0">
          <img src="{{ asset('assets/img/germas.jpg') }}" class="img-fluid" alt="Logo Germas">
          
        </a>

        <nav id="navbar" class="navbar">
          <ul>
            <li><a href="#hero">Home</a></li>
            <li><a href="#about">Jadwal Posyandu</a></li>
            <li><a href="#menu">Menu Makanan</a></li>
            <li><a href="#events">Artikel</a></li>
            <li><a href="#gallery">Galeri</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
          </ul>
        </nav><!-- .navbar -->

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

      </div>
    </header>
    <!-- End Navbar -->

    <!-- ======= Konten Utama ======= -->
    <main>
      @yield('content')
    </main>

    <!-- Scroll Top -->
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

  </body>
</html>
