<!-- Modal -->
<div class="modal fade" id="modalCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h1 class="modal-title fs-5" id="modalLabel">Tambah Kategori Makanan</h1> <!-- Updated the id to match aria-labelledby -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form action="{{ route('admin.CategoryMakananStore') }}" method="post">

                @csrf
                <div class="mb-3">
                    <label for="name">Nama</label>
                    {{-- kalo eror warna merah --}}
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}

                        </div>
                        
                    @enderror
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
          
        </div>
      </div>
    </div>
</div>
