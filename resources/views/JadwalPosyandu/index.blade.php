@extends('layout.main')

@push('css')
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

    .content-wrapper {
        background: #f4f6f9;
        padding: 40px 20px;
        border-radius: 15px;
    }

    .alert {
        border-radius: 8px;
        font-size: 0.95rem;
    }

    .card-header h3 {
        font-weight: 600;
        color: #333;
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
@endpush

@section('title', 'Jadwal Posyandu')
@section('judul', 'Jadwal Posyandu')

@section('content')
<div class="content-wrapper">
    <div class="content-header mb-4">
        <div class="container-fluid">
            <h1 class="m-0 text-center text-primary fw-bold">Jadwal Posyandu</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger my-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success my-3">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                @foreach ($jadwal as $item)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text"><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</p>
                            <p class="card-text"><i class="bi bi-geo-alt"></i> {{ $item->lokasi }}</p>
                            
                            <a href="{{ route('admin.jadwalposyanduedit', $item->id) }}" class="btn btn-sm btn-outline-primary mt-3">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        
            </div>
        </div>
    </section>
</div>
@endsection
