@foreach ($users as $item)
    <!-- Modal Edit -->
    <div class="modal fade" id="modalUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Edit Pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('admin.UsersUpdate', $item->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="mb-3">
                            <label for="name{{ $item->id }}">Nama</label>
                            <input type="text" name="name" id="name{{ $item->id }}" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nik{{ $item->id }}">NIK</label>
                            <input type="text" name="nik" id="nik{{ $item->id }}" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $item->nik) }}">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email{{ $item->id }}">Email</label>
                            <input type="email" name="email" id="email{{ $item->id }}" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $item->email) }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone{{ $item->id }}">No. Telp</label>
                            <input type="text" name="phone" id="phone{{ $item->id }}" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $item->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role{{ $item->id }}">Role</label>
                            <select name="role" id="role{{ $item->id }}" class="form-control @error('role') is-invalid @enderror">
                                <option value="">-- Pilih Role --</option>
                                <option value="bidan" {{ $item->hasRole('bidan') ? 'selected' : '' }}>Bidan</option>
                                <option value="pemerintah" {{ $item->hasRole('pemerintah') ? 'selected' : '' }}>Pemerintah Desa</option>
                                <option value="kader" {{ $item->hasRole('kader') ? 'selected' : '' }}>Kader</option>
                                <option value="ortu" {{ $item->hasRole('ortu') ? 'selected' : '' }}>Orang Tua</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password{{ $item->id }}">Password <small>(Kosongkan jika tidak diubah)</small></label>
                            <input type="password" name="password" id="password{{ $item->id }}" class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation{{ $item->id }}">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation{{ $item->id }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="photo{{ $item->id }}">Foto</label>
                            <input type="file" name="photo" id="photo{{ $item->id }}" class="form-control @error('photo') is-invalid @enderror" accept="image/*" onchange="previewImage(event, '{{ $item->id }}')">
                            @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            {{-- Foto lama --}}
                            @if ($item->photo && Storage::disk('public')->exists($item->photo))
                                <p class="text-muted mt-2 mb-1">Foto lama:</p>
                                <img src="{{ asset('storage/' . $item->photo) }}" class="img-thumbnail mb-2" width="100" height="100" alt="Foto saat ini">
                            @endif

                            {{-- Preview baru --}}
                            <img id="photo-preview-{{ $item->id }}" class="img-thumbnail mt-2" style="display: none; max-width: 100px;" alt="Preview Foto Baru">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endforeach

@push('js')
<script>
    function previewImage(event, id) {
        const input = event.target;
        const preview = document.getElementById('photo-preview-' + id);

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
