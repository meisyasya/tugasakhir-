@extends('layout.app')


<style>
  .section-header {
    background-color: linear-gradient(to right, #828ce9, #2d22c5);; /* contoh netral */}
.hero-gradient {
  
  background: linear-gradient(to right, #a8edea, #fed6e3);

}
.animated-text {
    position: relative;
    animation: slide 2s infinite alternate; /* Animasi */
}

@keyframes slide {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-10px); /* Naik */
    }
}




/* CSS untuk bagian About */
.about {
    background-color: #f7f8fc;
    padding: 40px 0;
}

.about .section-header p {
    font-family: 'Comic Sans MS', cursive, sans-serif;
    font-size: 32px;
    color: #4d4d4d;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
}

.about .section-header p span {
    color: #8fbdef;
    font-size: 36px;
    font-weight: bold;
    text-transform: uppercase;
    animation: bounce 1s infinite alternate;
}

.about .content p {
    font-family: 'Arial', sans-serif;
    font-size: 18px;
    color: #5f6368;
    line-height: 1.8;
    text-align: justify;
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.about .content p:hover {
    background-color: #069de3;
    color: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
}

/* Efek animasi untuk kata terakhir */
@keyframes bounce {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0);
    }
}

/* Efek untuk tombol atau link jika ada */
.about .btn {
    background-color: #0e3b4c;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 30px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.about .btn:hover {
    background-color: #625897;
}

/* Background tambahan untuk desain ceria */
.about .container {
    background: linear-gradient(135deg, #828ce9, #473afb);
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.about img {
    border: 5px solid #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-radius: 15px;
}

/* Pindahkan ke luar seperti ini */
.about-card {
  background: #fff;
  border-radius: 20px;
  padding: 40px;
  position: relative;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.about-card::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 30px;
  background: repeating-linear-gradient(
    -45deg,
    #fff 0px,
    #fff 10px,
    #e30613 10px,
    #e30613 20px
  );
}






</style>

{{-- jadwal posyandu --}}
<style>
  .card {
    border: none;
    border-radius: 15px;
    transition: 0.3s ease;
    background: linear-gradient(145deg, #ffffff, #f4f6f9);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
  }

  .card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0d6efd;
  }

  .card-text {
    color: #444;
    font-size: 0.95rem;
    margin-bottom: 6px;
  }

  @media (max-width: 767px) {
    .card-title {
      font-size: 1.1rem;
    }

    .card-text {
      font-size: 0.9rem;
    }
  }
</style>

{{-- menu makanan --}}
<style>
  .menu-img {
    object-fit: cover;
    height: 200px;
    width: 100%;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .card {
    transition: 0.3s ease;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }

  .badge {
    font-size: 0.75rem;
  }

  .ingredients {
    font-size: 0.9rem;
    color: #666;
  }

  .card h4 {
    font-family: 'Poppins', sans-serif;
    color: #333;
  }
</style>

@section('content')
  


{{-- untuk header --}}
<section id="hero" class="hero d-flex align-items-center hero-gradient">
  <div class="container">
      <div class="row justify-content-between gy-5">
          <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
              <h2 class="animated-text" data-aos="fade-up">{{ $headers->title ?? 'Data belum tersedia' }}</h2>
              <p class="animated-text" data-aos="fade-up" data-aos-delay="100">{{ $headers->description ?? 'Data belum tersedia' }}</p>
              <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
              </div> 
          </div>
          <div class="col-lg-7 position-relative about-img">
            @if (!empty($headers->image) && $headers->image !== 'logo.png')
            <img src="{{ asset('storage/header/' . $headers->image) }}" alt="header Image"
            class="img-fluid rounded mx-auto d-block w-100 h-auto">
           @else
            <p class="text-muted text-center">Foto belum tersedia</p>
            @endif        

        </div>              
      </div>
  </div>
</section>
{{-- end header --}}



{{-- section about --}}
<section id="about" class="about">
  <div class="about-card container position-relative" data-aos="fade-up">

    <div class="section-header">
      <h2>
        @php
        $judul = $abouts->title ?? 'Data belum tersedia';
        $kata = explode(' ', $judul);
        $kataTerakhir = array_pop($kata);
        $sisaKata = implode(' ', $kata);
      @endphp
      </h2>
      <p>
        {{ $sisaKata }} <span style="color: #e30613;">{{ $kataTerakhir }}</span>
      </p>   

    <div class="row align-items-center">
      <!-- Teks -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
        <div class="content ps-3 ps-lg-5">
          <p style="text-align: justify;">
            {{ $abouts->description ?? 'Data belum tersedia' }}
          </p>
        </div>
      </div>

      <!-- Gambar -->
      @if (isset($abouts->image) && $abouts->image !== 'logo.png')
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <img src="{{ asset('storage/about/' . $abouts->image) }}"
     alt="About"
     class="img-fluid mx-auto d-block"
     style="max-width: 500px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">


         </div>
      @endif
    </div>
  </div>
</section>
<!-- End About Section -->



{{-- jadwal posyandu --}}

<section id="jadwal" class="jadwal py-5" style="background-color: #f4f6f9;">
  <div class="container">
    <div class="section-header text-center mb-2">
      <p>Jadwal <span class="text-warning">Posyandu</span></p>
  </div>
    <div class="row g-4">
      @forelse($jadwal as $item)
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column justify-content-center">
              <h5 class="card-title">{{ $item->nama }}</h5>
              <p class="card-text">
                <i class="bi bi-calendar-event"></i>
                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
              </p>
              <p class="card-text">
                <i class="bi bi-geo-alt"></i>
                {{ $item->lokasi }}
              </p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <p class="text-center text-muted">Belum ada jadwal posyandu yang tersedia.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>


{{-- end jadwal posyandu --}}


    <!-- ======= Menu Makanan Section ======= -->
    <section id="menu" class="menu py-5" style="background-color: #f8f9fa;">
      <div class="container" data-aos="fade-up">
    
        {{-- Section Header --}}
        <div class="section-header text-center mb-2">
          <h2 class="text-primary">Menu</h2>
          <p>Makanan <span class="text-warning">Sehat</span></p>
        </div>
    
        {{-- Navigation Tabs --}}
        <ul class="nav nav-tabs d-flex justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
          <li class="nav-item mx-2">
            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-all">
              <h4 class="font-weight-bold text-dark">All</h4>
            </a>
          </li>
          @foreach ($kategori_makanan as $item)
            <li class="nav-item mx-2">
              <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-{{ $item->slug }}">
                <h4 class="font-weight-bold text-dark">{{ $item->name }}</h4>
              </a>
            </li>
          @endforeach
        </ul>
    
        {{-- Tab Content --}}
        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
    
          {{-- All Menu --}}
          <div class="tab-pane fade active show" id="menu-all">
            <div class="row gy-4">
              {{-- All Menu --}}
<div class="tab-pane fade active show" id="menu-all">
  <div class="row gy-4">
    @forelse ($menumakanan as $item)
      <div class="col-lg-4 col-md-6 menu-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="card shadow-sm border-0 rounded h-100">
          <div class="glightbox">
            <img src="{{ $item->img ? asset('storage/' . $item->img) : asset('images/placeholder.png') }}"
                 class="menu-img img-fluid rounded-top"
                 alt="{{ $item->title }}"
                 style="height: 200px; object-fit: cover;">
          </div>
          <div class="card-body text-center">
            <span class="badge bg-warning text-dark mb-2">{{ $item->category->name ?? 'Kategori' }}</span>
            <h4 class="fw-bold">{{ $item->title }}</h4>

            <p class="ingredients text-muted small">{!! Str::words($item->desc, 15, '...') !!}</p>
            <a href="{{ route('menu.show', $item->slug) }}" class="text-primary fw-semibold">Lihat Selengkapnya →</a>
          </div>
        </div>
      </div>
    @empty
      <p class="text-muted text-center">Belum ada menu tersedia.</p>
    @endforelse
  </div>
</div>

            </div>
          </div>
    
          {{-- Per Kategori --}}
          @foreach ($kategori_makanan as $item)
            <div class="tab-pane fade" id="menu-{{ $item->slug }}">
              <div class="row gy-4">
                @forelse ($menumakanan->where('category_id', $item->id) as $menu)
                  <div class="col-lg-4 col-md-6 menu-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card shadow-sm border-0 rounded h-100">
                      <div class="glightbox">
                        <img src="{{ $menu->img ? asset('storage/' . $menu->img) : asset('images/placeholder.png') }}"
                             class="menu-img img-fluid rounded-top"
                             alt="{{ $menu->title }}"
                             style="height: 200px; object-fit: cover;">
                      </div>
                      <div class="card-body text-center">
                        <span class="badge bg-warning text-dark mb-2">{{ $item->name }}</span>
                        <h4 class="fw-bold">{{ $menu->title }}</h4>
                      
                        <p class="ingredients text-muted small">{!! Str::words($menu->desc, 15, '...') !!}</p>
                        <a href="/p/{{ $menu->slug }}" class="text-primary text-decoration-none fw-semibold">Lihat selengkapnya →</a>
                      </div>
                    </div>
                  </div>
                @empty
                  <p class="text-muted text-center">Belum ada menu untuk kategori ini.</p>
                @endforelse
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    
    


    {{-- end menu makanan --}}



          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

  


    {{-- arikel --}}
    <section id="events" class="events py-5" style="background-color: #f8f9fa;">
      <div class="container" data-aos="fade-up">
    
        {{-- Section Header --}}
        <div class="section-header text-center mb-4">
          <h2 class="text-primary">ARTIKEL</h2>
          <p>Info <span class="text-warning">Stunting</span> Anak</p>
        </div>
    
        {{-- Navigation Tabs --}}
        <ul class="nav nav-tabs d-flex justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200" role="tablist">
          <li class="nav-item mx-2" role="presentation">
            <button class="nav-link active" id="tab-all" data-bs-toggle="tab" data-bs-target="#articles-all" type="button" role="tab" aria-controls="articles-all" aria-selected="true">
              <h4 class="font-weight-bold text-dark">Semua</h4>
            </button>
          </li>
          @foreach ($categories as $category)
            <li class="nav-item mx-2" role="presentation">
              <button class="nav-link" id="tab-{{ $category->slug }}" data-bs-toggle="tab" data-bs-target="#articles-{{ $category->slug }}" type="button" role="tab" aria-controls="articles-{{ $category->slug }}" aria-selected="false">
                <h4 class="font-weight-bold text-dark">{{ $category->name }}</h4>
              </button>
            </li>
          @endforeach
        </ul>
    
        {{-- Tab Content --}}
        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
    
          {{-- Semua Artikel --}}
          <div class="tab-pane fade show active" id="articles-all" role="tabpanel" aria-labelledby="tab-all">
            <div class="row gy-4">
              @forelse ($articles as $article)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                  <div class="card shadow-sm border-0 rounded h-100">
                    {{-- {{ route('article.show', $article->slug) }} --}}
                    <a href="" class="d-block overflow-hidden rounded-top">
                      <img src="{{ $article->img ? asset('storage/uploads/articles/' . $article->img) : asset('images/placeholder.png') }}"
                           alt="{{ $article->title }}"
                           class="img-fluid"
                           style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="card-body text-center">
                      <span class="badge bg-warning text-dark mb-2">{{ $article->category->name ?? 'Kategori' }}</span>
                      <h4 class="fw-bold">{{ $article->title }}</h4>
                      <p class="description text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($article->desc), 100, '...') }}</p>
                      {{-- {{ route('article.show', $article->slug) }} --}}
                      <a href="" class="text-primary fw-semibold">Baca Selengkapnya →</a>
                    </div>
                  </div>
                </div>
              @empty
                <p class="text-muted text-center">Belum ada artikel tersedia.</p>
              @endforelse
            </div>
          </div>
    
          {{-- Artikel per Kategori --}}
          @foreach ($categories as $category)
            <div class="tab-pane fade" id="articles-{{ $category->slug }}" role="tabpanel" aria-labelledby="tab-{{ $category->slug }}">
              <div class="row gy-4">
                @php
                  $articlesByCategory = $articles->where('category_id', $category->id);
                @endphp
    
                @forelse ($articlesByCategory as $article)
                  <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card shadow-sm border-0 rounded h-100">
                      {{-- {{ route('article.show', $article->slug) }} --}}
                      <a href="" class="d-block overflow-hidden rounded-top">
                        <img src="{{ $article->img ? asset('storage/uploads/articles/' . $article->img) : asset('images/placeholder.png') }}"
                             alt="{{ $article->title }}"
                             class="img-fluid"
                             style="height: 200px; object-fit: cover;">
                      </a>
                      <div class="card-body text-center">
                        <span class="badge bg-warning text-dark mb-2">{{ $category->name }}</span>
                        <h4 class="fw-bold">{{ $article->title }}</h4>
                        <p class="description text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($article->desc), 100, '...') }}</p>
                        <a href="" class="text-primary fw-semibold">Baca Selengkapnya →</a>
                        {{-- {{ route('article.show', $article->slug) }} --}}
                      </div>
                    </div>
                  </div>
                @empty
                  <p class="text-muted text-center">Belum ada artikel untuk kategori ini.</p>
                @endforelse
              </div>
            </div>
          @endforeach
    
        </div>
    
      </div>
    </section>
    
    {{-- end artikel --}}

    
  
    <!-- ======= Gallery Section ======= -->
   <!-- Galeri Section -->
<div class="about-us mt-5">
  <div class="container">
      <div class="title-container">
          <h2 class="text-center fw-bold">GALERI</h2>
      </div>

      <!-- Filter Kategori -->
      <div class="row mt-4">
          <div class="col-md-12 d-flex justify-content-center">
              <ul class="list-unstyled d-flex portfolio-filter flex-wrap gap-2">
                  <li data-filter="*" class="py-2 px-4 filter-active">Semua</li>
                  @foreach ($galeri_categories as $category)
                      <li data-filter=".filter-{{ $category->id }}" class="py-2 px-4 btn-secondary">{{ $category->name }}</li>
                  @endforeach
              </ul>                
          </div>
      </div>

      <!-- Galeri Gambar -->
      <div class="row mt-5">
          <div class="col-md-12">
              <div class="row gambar-container" data-aos="zoom-in-up">
                  @forelse ($galeris as $item)
                      <div class="col-md-4 col-sm-6 mb-4 gambar-item filter-{{ $item->category_id }}" data-aos="fade-up">
                          <a href="{{ asset('storage/' . $item->img) }}" 
                             data-lightbox="galeri-{{ $item->category_id }}" 
                             data-title="{{ $item->title ?? 'Gambar Posyandu' }}">
                              <img src="{{ asset('storage/' . $item->img) }}" 
                                   alt="{{ $item->title ?? 'Gambar Posyandu' }}" 
                                   class="img-fluid rounded shadow">
                          </a>
                      </div>
                  @empty
                      <p class="text-center text-muted">Belum ada gambar tersedia.</p>
                  @endforelse
              </div>
          </div>
      </div>
  </div>
</div>

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<style>
  .portfolio-filter li {
      cursor: pointer;
      border-radius: 5px;
  }

  .filter-active {
      background-color: #00b347;
      color: #fff !important;
  }

  .btn-secondary {
      background-color: #f0f0f0;
      color: #000;
  }

  .gambar-item img {
      transition: transform 0.3s ease;
  }

  .gambar-item img:hover {
      transform: scale(1.05);
  }
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/isotope-layout/3.0.6/isotope.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
  $(window).on('load', function () {
      var $grid = $('.gambar-container').isotope({
          itemSelector: '.gambar-item',
          layoutMode: 'fitRows'
      });

      $('.gambar-container').imagesLoaded().progress(function () {
          $grid.isotope('layout');
      });

      $('.portfolio-filter li').on('click', function () {
          $('.portfolio-filter li').removeClass('filter-active');
          $(this).addClass('filter-active');

          var filterValue = $(this).attr('data-filter');
          $grid.isotope({ filter: filterValue });
      });
  });
</script>
@endpush

    <!-- End Gallery Section -->

    
        <div class="mb-3">
          <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d33133.89860455798!2d109.08408036657883!3d-7.6087472915351935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e656b29dc084053%3A0x7d0f41d9ab2cf615!2sUPTD%20Puskesmas%20Kesugihan%20I!5e0!3m2!1sid!2sid!4v1701047598463!5m2!1sid!2sid" frameborder="0" allowfullscreen></iframe>
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

  @endsection