@extends('layout.app')

@section('title', $article->title) {{-- Menggunakan $article untuk judul halaman --}}

@section('content')
<section class="menu-detail py-5 bg-light"> {{-- Mengadopsi kelas section dari detail makanan --}}
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10"> {{-- Menggunakan lebar kolom yang sama dengan detail makanan --}}
                <div class="card shadow-lg border-0 rounded-4"> {{-- Menggunakan gaya card dari detail makanan --}}
                    <div class="card-body p-5"> {{-- Padding yang sama dengan detail makanan --}}
                        <div class="text-center mb-4"> {{-- Bagian judul dan info artikel --}}
                            <h2 class="fw-bold text-primary">{{ $article->title }}</h2> {{-- Menggunakan $article dan warna primer --}}
                            <p class="text-muted mb-3">
                                {{ \Carbon\Carbon::parse($article->publish_date)->format('d F Y') }} | {{-- Tanggal publikasi dari artikel --}}
                                <span class="badge bg-primary">{{ $article->category->name ?? 'Tanpa Kategori' }}</span> {{-- Kategori artikel --}}
                            </p>
                            <p class="text-muted">Penulis: {{ $article->user->name ?? 'Admin' }} • Dilihat: {{ $article->views }}x</p> {{-- Info penulis dan views --}}
                            @if ($article->img)
                                <img src="{{ asset('storage/uploads/articles/' . $article->img) }}" {{-- Path gambar artikel --}}
                                    alt="{{ $article->title }}"
                                    class="img-fluid rounded-4 shadow-sm" {{-- Kelas gambar dari detail makanan --}}
                                    style="max-height: 400px; object-fit: cover;"> {{-- Style gambar dari detail makanan --}}
                            @else
                                <img src="{{ asset('images/placeholder.png') }}"
                                    alt="Placeholder"
                                    class="img-fluid rounded-4 shadow-sm"
                                    style="max-height: 400px; object-fit: cover;">
                            @endif
                        </div>

                        <hr class="my-4"> {{-- Garis pemisah dari detail makanan --}}

                        <div class="menu-description fs-5 text-dark"> {{-- Menggunakan kelas deskripsi dari detail makanan --}}
                            {!! $article->desc !!} {{-- Konten deskripsi artikel --}}
                        </div>

                        <div class="text-end mt-5"> {{-- Tombol kembali di kanan bawah --}}
                            <a href="{{ url()->previous() }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                ← Kembali ke Artikel {{-- Menggunakan gaya tombol dari detail makanan --}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection