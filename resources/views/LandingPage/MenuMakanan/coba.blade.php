<div class="col-md-6">
    {{-- Tombol Tambah Article --}}
    <a href="" class="btn btn-success mb-3" >Tambah Menu Makanan</a>
    
    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger my-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tampilkan pesan sukses --}}
    {{-- @if (session('success'))
        <div class="alert alert-success my-3">
            {{ session('success') }}
        </div>
    @endif --}}

    {{--  sweet alert--}}
    <div class="swal" data-swal="{{ session('success') }}"></div>

    {{-- Tabel Data --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Menu Makanan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-hover table-bordered" id="dataTable">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Publish Date</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</div>