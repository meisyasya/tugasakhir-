@extends('layout.main')

@section('title')
    Dashboard
@endsection

@section('judul')
    Dashboard
@endsection

<style>
/* Styling umum untuk small-box */
.small-box {
    border-radius: 10px; /* Membuat sudut lebih bulat */
    transition: all 0.3s ease; /* Efek transisi pada hover */
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan lembut pada kotak */
    position: relative;
}

/* Hover effect untuk memperbesar dan memberikan bayangan */
.small-box:hover {
    transform: translateY(-5px); /* Mengangkat kotak sedikit */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar */
}

/* Styling ikon di dalam small-box */
.small-box .icon {
    font-size: 40px;
    opacity: 0.8;
    transition: opacity 0.3s ease; /* Transisi halus pada opacity */
}

/* Hover effect pada ikon */
.small-box:hover .icon {
    opacity: 1; /* Mengubah opacity saat hover untuk memperjelas ikon */
}

/* Warna background untuk box yang aktif */
.small-box.active {
    background-color: #ff80b2 !important; /* Warna background pink cerah */
}

/* Styling footer box */
.small-box-footer {
    color: white;
    font-weight: bold;
    text-decoration: none; /* Menghilangkan garis bawah */
    transition: color 0.3s ease;
}

/* Efek hover pada footer box */
.small-box-footer:hover {
    color: #f5f5f5 !important; /* Perubahan warna saat hover */
}

/* Styling untuk teks dalam kotak */
.small-box .inner {
    color: white;
}

/* Responsivitas untuk perangkat kecil */
@media (max-width: 768px) {
    .small-box {
        font-size: 14px; /* Menurunkan ukuran font di perangkat kecil */
        padding: 15px;
    }

    .small-box .inner h3 {
        font-size: 18px; /* Ukuran font h3 lebih kecil */
    }

    .small-box .inner p {
        font-size: 14px; /* Ukuran font p lebih kecil */
    }

    .small-box-footer {
        font-size: 14px; /* Ukuran font footer lebih kecil */
    }
}


/* Ensure text color for the "Info lebih lanjut" link is white */
#more-users {
    color: white !important; /* Ensure it overrides any other styles */
}

/* Optional: Change the color of the arrow icon to white as well */
#more-users i {
    color: white;
}

/* Change text color on hover as well */
#more-users:hover {
    color: #f5f5f5 !important; /* Slight change on hover */
}


</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   
    <!-- /.content -->
</div>
@endsection
