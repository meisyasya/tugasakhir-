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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Amatic+SC:wght@400;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    @stack('css')

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



    <div class="mb-3">
      <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.799761637806!2d109.1362305759534!3d-7.596759292418054!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e656977f7e7ad03%3A0x9a3beaad6da2ec68!2sBalai%20Desa%20Bulupayung!5e0!3m2!1sid!2sid!4v1751436208717!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>" frameborder="0" allowfullscreen></https:>
    </div><!-- End Google Maps -->


    <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div>
            <h4>Alamat</h4>
            <p>
              Jalan Tambangan RT 04 RW 02 Desa Bulupayung<br>
              Kesugihan<br>
            </p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Kontak</h4>
            <p>
              <strong>Phone:</strong> 088232649021<br>
              <strong>Email:</strong>sipenting20@gmail.com<br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Jam Buka</h4>
            <p>
              <strong>Senin-Jum'at : </strong> 08.00 - 11.00<br>
              Sabtu Minggu Tutup
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Ikuti Sosmed Kami</h4>
          <div class="social-links d-flex">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Sipenting</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
    
        Designed by <a href="https://bootstrapmade.com/">meisyanggra</a>
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->
  

    <!-- Scroll Top -->
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>
<!-- jQuery (wajib sebelum plugin lain) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Plugin: ImagesLoaded, Isotope, Lightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/isotope/3.0.6/isotope.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<!-- Isotope.js -->
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<!-- imagesLoaded -->
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>



<!-- AOS -->
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<!-- Bootstrap & Main JS -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- Galeri Script -->
<script>
  $(function () {
      // Inisialisasi AOS (Animate On Scroll)
      AOS.init({
          duration: 1000,
          easing: 'ease-in-out',
          once: true
      });
  
      // Siapkan elemen grid galeri
      var $grid = $('.gambar-container');
  
      // Pastikan semua gambar dimuat sebelum inisialisasi Isotope
      $grid.imagesLoaded().always(function () {
          $grid.isotope({
              itemSelector: '.gambar-item',
              layoutMode: 'masonry',
              masonry: {
                  columnWidth: '.grid-sizer', // Gunakan grid-sizer sebagai acuan kolom
                  gutter: 16
              },
              transitionDuration: '0.6s'
          });
  
          // Layout ulang setelah inisialisasi
          $grid.isotope('layout');
      });
  
      // Filter kategori
      $('.portfolio-filter li').on('click', function () {
          $('.portfolio-filter li').removeClass('filter-active');
          $(this).addClass('filter-active');
  
          const filterValue = $(this).attr('data-filter');
          $grid.isotope({ filter: filterValue });
  
          // Layout ulang setelah filter
          $grid.isotope('layout');
      });
  
      // Inisialisasi Lightbox jika tersedia
      if (typeof lightbox !== 'undefined') {
          lightbox.option({
              resizeDuration: 200,
              wrapAround: true
          });
      }
  
      // Responsif: layout ulang saat window resize
      $(window).on('resize', function () {
          clearTimeout(window.isotopeResizeTimeout);
          window.isotopeResizeTimeout = setTimeout(function () {
              $grid.isotope('layout');
          }, 100);
      });
  });
  </script>
  

</html>
