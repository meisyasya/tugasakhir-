@extends('layout.main')

@section('title')
   Sosial Media
@endsection

@section('judul')
   Sosial Media
@endsection

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
  .select2 {
    width: 100% !important;
  }
  .select2-selection--single {
    height: 38px !important;
    padding-top: 5px !important;
    padding-bottom: 5px !important;
  }
  .select2-selection__rendered {
    line-height: 28px !important;
  }
}
</style>

    
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Sosial Media</h1>
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
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.SosmedStore') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <a href="{{ route('admin.SosmedIndex') }}" class="btn btn-primary mb-3">Kembali</a>

                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Form Sosial Media</h3>
                      </div>

                      <div class="card-body">
                          {{-- Nama --}}
                        <div class="form-group">
                            <label for="exampleInputJudul">Nama </label>
                            <input type="text" class="form-control" id="exampleInputJudul" name="name" placeholder="Enter Nama" value="{{ old('name') }}">
                            @error('name')
                              <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Icon Class Dropdown --}}
                        <div class="form-group">
                          <label for="exampleInputIconClass">Icon Class</label>
                          <select class="form-control select2" id="exampleInputIconClass" name="icon_class">
                              <option value="" disabled {{ old('icon_class') ? '' : 'selected' }}>Pilih Icon di sini</option>
                              <option value="fab fa-facebook" {{ old('icon_class') == 'fab fa-facebook' ? 'selected' : '' }}>Facebook</option>
                              <option value="fab fa-instagram" {{ old('icon_class') == 'fab fa-instagram' ? 'selected' : '' }}>Instagram</option>
                              <option value="fab fa-youtube" {{ old('icon_class') == 'fab fa-youtube' ? 'selected' : '' }}>YouTube</option>
                              <option value="fab fa-whatsapp" {{ old('icon_class') == 'fab fa-whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                              <option value="fab fa-tiktok" {{ old('icon_class') == 'fab fa-tiktok' ? 'selected' : '' }}>TikTok</option>
                              <option value="fab fa-telegram" {{ old('icon_class') == 'fab fa-telegram' ? 'selected' : '' }}>Telegram</option>
                          </select>
                          @error('icon_class')
                              <small style="color: red">{{ $message }}</small>
                          @enderror
                        </div>                        

                        {{-- URL --}}
                        <div class="form-group">
                            <label for="exampleInputJudul">URL </label>
                            <input type="url" class="form-control" id="exampleInputJudul" name="url" placeholder="Enter URL" value="{{ old('url') }}">
                            @error('url')
                              <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                      </div>

                      <div class="card-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
            </form>
        </div>
      </section>
  </div>


  @push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
       $('#exampleInputIconClass').select2({
           width: '100%',  // Pastikan lebar dropdown sesuai dengan lebar kolom
           dropdownAutoWidth: true,
           templateResult: formatIcon,
           templateSelection: formatIcon
       });
 
       function formatIcon (icon) {
           if (!icon.id) {
               return icon.text;
           }
           var $icon = $( 
               '<span><i class="' + icon.element.value + '"></i> ' + icon.text + '</span>'
           );
           return $icon;
       }
   });
 </script>
 

      
  @endpush
@endsection
