
@extends('layout.app')

@section('title', $menu->title)

@section('content')
<section class="menu-detail py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">{{ $menu->title }}</h2>
                            <p class="text-muted mb-3">{{ $menu->created_at->format('d M Y') }}</p>
                            <img src="{{ asset('storage/' . $menu->img) }}" class="img-fluid rounded-4 shadow-sm" alt="{{ $menu->title }}" style="max-height: 400px; object-fit: cover;">
                        </div>

                        <hr class="my-4">

                        <div class="menu-description fs-5 text-dark">
                            {!! $menu->desc !!}
                        </div>

                        <div class="text-end mt-5">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                ← Kembali ke Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
