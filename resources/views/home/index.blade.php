@extends('layout.app')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<style>
  .nav-tabs {
      border-bottom: none !important;
  }

  .nav-tabs .nav-link {
      border: none !important;
      border-radius: 5px;
      font-weight: 600;
      color: #6c757d;
      transition: all 0.3s ease;
  }

  .nav-tabs .nav-link.active,
  .nav-tabs .nav-link:hover {
      background-color:#007bff;
      color: #fff !important;
  }

  .nav-tabs .nav-link.active h4,
  .nav-tabs .nav-link:hover h4 {
      color: #fff !important;
  }

  .galeri-wrapper {
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: transform 0.3s, box-shadow 0.3s;
  }

  .galeri-wrapper:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }

  .galeri-img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      display: block;
  }

  .galeri-item {
      padding: 8px;
      visibility: hidden;
  }

  .galeri-item.is-visible {
      visibility: visible;
  }

  .gambar-container, 
  [class^="gambar-container-"] {
      margin: -8px;
  }
  .grid-sizer {
      width: 33.3333%;
  }
</style>
@endpush


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

<div class="section-header text-center mb-2">
  <p style="padding-top: 30px;">
    <b>
    @php
      $judul_stunting = $abouts->title ?? 'STUNTING?';
      $kata_stunting = explode(' ', $judul_stunting);
      $kataTerakhir_stunting = array_pop($kata_stunting);
      $sisaKata_stunting = implode(' ', $kata_stunting);
    @endphp
    {{ $sisaKata_stunting }} <span class="text-warning">{{ $kataTerakhir_stunting }}</span>
  </b>
  </p>
</div>



{{-- section about --}}
<section id="about" class="about">
  
  <div class="about-card container position-relative" data-aos="fade-up">

    
    
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

  </div>
</section>





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
        <ul class="nav nav-tabs d-flex justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
          <li class="nav-item mx-2">
            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#articles-all">
              <h5 class="font-weight-bold text-dark">All</h5>
            </a>
          </li>
          @foreach ($categories as $item)
            <li class="nav-item mx-2">
              <a class="nav-link" data-bs-toggle="tab" data-bs-target="#articles-{{ $item->slug }}">
                <h5 class="font-weight-bold text-dark">{{ $item->name }}</h5>
              </a>
            </li>
          @endforeach
        </ul>
    
        {{-- Tab Content --}}
        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
    
          {{-- Semua Artikel --}}
          <div class="tab-pane fade show active" id="articles-all" role="tabpanel">
            <div class="row gy-4">
              @forelse ($articles as $article)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                  <div class="card shadow-sm border-0 rounded h-100">
                    <a href="{{ route('article.show', $article->slug) }}" class="d-block overflow-hidden rounded-top">
                      <img src="{{ $article->img ? asset('storage/uploads/articles/' . $article->img) : asset('images/placeholder.png') }}"
                           alt="{{ $article->title }}"
                           class="img-fluid"
                           style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="card-body text-center">
                      <span class="badge bg-warning text-dark mb-2">{{ $article->category->name ?? 'Kategori' }}</span>
                      <h4 class="fw-bold">{{ $article->title }}</h4>
                      <p class="description text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($article->desc), 100, '...') }}</p>
                      <a href="{{ route('article.show', $article->slug) }}" class="text-primary fw-semibold">Baca Selengkapnya →</a>
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
            <div class="tab-pane fade" id="articles-{{ $category->slug }}" role="tabpanel">
              <div class="row gy-4">
                @php
                  $articlesByCategory = $articles->where('category_id', $category->id);
                @endphp
                @forelse ($articlesByCategory as $article)
                  <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card shadow-sm border-0 rounded h-100">
                      <a href="{{ route('article.show', $article->slug) }}" class="d-block overflow-hidden rounded-top">
                        <img src="{{ $article->img ? asset('storage/uploads/articles/' . $article->img) : asset('images/placeholder.png') }}"
                             alt="{{ $article->title }}"
                             class="img-fluid"
                             style="height: 200px; object-fit: cover;">
                      </a>
                      <div class="card-body text-center">
                        <span class="badge bg-warning text-dark mb-2">{{ $category->name }}</span>
                        <h4 class="fw-bold">{{ $article->title }}</h4>
                        <p class="description text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($article->desc), 100, '...') }}</p>
                        <a href="{{ route('article.show', $article->slug) }}" class="text-primary fw-semibold">Baca Selengkapnya →</a>
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
    <div class="about-us mt-5 mb-5">
      <div class="container">
          {{-- Section Header --}}
          <div class="section-header text-center mb-4">
              <p>Galeri <span class="text-warning">Posyandu</span> Anak</p>
          </div>
  
          {{-- FILTER KATEGORI --}}
          <div class="row mt-4">
              <div class="col-md-12 d-flex justify-content-center">
                  <ul class="list-unstyled d-flex flex-wrap portfolio-filter">
                      <li data-filter="*" class="py-2 px-4 filter-active">All</li>
                      @foreach ($categorigaleri as $item)
                          <li data-filter=".filter-{{ $item->id }}" class="py-2 px-4">
                              {{ $item->name }}
                          </li>
                      @endforeach
                  </ul>
              </div>
          </div>
  
          {{-- GALERI MASONRY --}}
          <div class="row mt-4">
              <div class="col-md-12">
                  <div class="gambar-container" data-aos="zoom-in-up">
                      <div class="grid-sizer"></div>
  
                      @foreach ($galeris as $dokumentasi)
                          <div class="gambar-item filter-{{ $dokumentasi->category_id }}">
                              <a href="{{ asset('storage/' . $dokumentasi->img) }}"
                                 data-lightbox="galeri"
                                 data-title="{{ $dokumentasi->name }}">
                                  <img src="{{ asset('storage/' . $dokumentasi->img) }}"
                                       alt="{{ $dokumentasi->name }}"
                                       class="img-fluid w-100 rounded-2"
                                       style="object-fit: cover;">
                              </a>
                          </div>
                      @endforeach
                  </div>
              </div>
          </div>
      </div>
  </div>
  
  
  @push('css')
  <style>
  /* ================================
     FILTER KATEGORI (PORTFOLIO MENU)
     ================================ */
  .portfolio-filter li {
      cursor: pointer;
      border: 1px solid transparent;
      margin: 5px; /* Jarak antar tombol filter */
      border-radius: 6px;
      transition: 0.3s ease;
      padding: 8px 15px;
      font-size: 0.95rem;
      white-space: nowrap;
  }
  
  .portfolio-filter li.filter-active {
      background-color: #007bff;
      color: white;
      border-color: #007bff;
  }
  
  /* ========================
     KONTENER GRID ISOTOPE
     ======================== */
  .gambar-container {
      position: relative;
      margin-left: auto;
      margin-right: auto;
  }
  
  /* ======================
     GRID SIZER & ITEM
     ====================== */
  .grid-sizer,
  .gambar-item {
      width: 33.333%; /* Default: 3 kolom di desktop */
  }
  
  .gambar-item {
      padding: 8px;
      box-sizing: border-box;
      text-align: center;
  }
  
  /* ======================
     RESPONSIVE BREAKPOINTS
     ====================== */
  
  /* Desktop ≥ 992px: 3 kolom */
  @media (min-width: 992px) {
      .grid-sizer,
      .gambar-item {
          width: 28%;
      }
  }
  
  /* Tablet ≥ 768px & < 992px: 2 kolom */
  @media (min-width: 768px) and (max-width: 991.98px) {
      .grid-sizer,
      .gambar-item {
          width: 50%;
      }
  }
  
  /* Mobile < 768px: 1 kolom */
  @media (max-width: 767.98px) {
      .grid-sizer,
      .gambar-item {
          width: 100%;
      }
  }
  
  /* ===========================
     GAMBAR DI DALAM GRID ITEM
     =========================== */
  .gambar-item img {
      display: block;
      max-width: 100%;
      height: auto;
  }
  </style>
  @endpush
  



  @endsection