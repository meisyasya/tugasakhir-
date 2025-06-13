<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="{{ route('admin.UsersStore') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Tambah Pengguna</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>

              <div class="modal-body">
                  <div class="form-group">
                      <label>Nama</label>
                      <input type="text" name="name" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label>NIK</label>
                      <input type="number" name="nik" class="form-control" required minlength="16" maxlength="16">
                    </div>

                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label>No Telepon</label>
                      <input type="text" name="phone" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label for="password_confirmation">Konfirmasi Password</label>
                      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label>Role</label>
                      <select name="role" class="form-control" required>
                          <option value="">-- Pilih Role --</option>
                          <option value="bidan">Bidan</option>
                          <option value="pemerintah">Pemerintah Desa</option>
                          <option value="kader">Kader</option>
                          <option value="ortu">Orang Tua</option>
                      </select>
                  </div>

                  <div class="form-group">
                    <label>Foto (optional)</label>
                    <input type="file" name="photo" class="form-control-file" onchange="previewImage(event)">
                    <img id="photo-preview" src="#" alt="Preview Foto" class="mt-2 img-thumbnail" style="display: none; max-width: 150px;">
                </div>                
              </div>

              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
          </div>
      </form>
  </div>
</div>


@push('js')
    <script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('photo-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endpush
