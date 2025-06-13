@extends('layout.app')
@section('title', $menu->title)

@section('content')
<section class="py-5">
  <div class="container" data-aos="fade-up">
    {{-- Judul --}}
    <div class="mb-4 text-center">
      <h2 class="fw-bold text-dark">{{ $menu->title }}</h2>
      <p class="text-muted">{{ \Carbon\Carbon::parse($menu->publish_date)->format('d F Y') }} |
        <span class="badge bg-primary">{{ $menu->Category->name ?? 'Tanpa Kategori' }}</span>
      </p>
      <p class="text-muted">Penulis: {{ $menu->User->name ?? 'Admin' }} • Dilihat: {{ $menu->views }}x</p>
    </div>

    {{-- Gambar --}}
    @if ($menu->img)
      <div class="text-center mb-4">
        <img src="{{ asset('storage/uploads/articles/' . $menu->img) }}"
             alt="{{ $menu->title }}"
             class="img-fluid rounded"
             style="max-height: 450px; object-fit: cover;">
      </div>
    @endif

    {{-- Isi Konten --}}
    <div class="article-content">
      {!! $menu->desc !!}
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-5 text-center">
      <a href="{{ route('home.artikel') }}" class="btn btn-secondary">← Kembali ke Daftar Artikel</a>
    </div>
  </div>
</section>
@endsection