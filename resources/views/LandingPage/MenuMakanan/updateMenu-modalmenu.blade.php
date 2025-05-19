@foreach ($menumakanan as $item)
<!-- Modal Update Menu Makanan -->
<div class="modal fade" id="modalUpdateMenu{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Edit Menu Makanan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.MenuMakananUpdate', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="title{{ $item->id }}">Judul</label>
                                <input type="text" name="title" id="title{{ $item->id }}" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $item->title) }}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="category_id{{ $item->id }}">Kategori</label>
                                <select name="category_id" id="category_id{{ $item->id }}" class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="" hidden>-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="img{{ $item->id }}">Gambar (Max 2MB)</label>
                        <input type="file" name="img" id="img{{ $item->id }}" class="form-control @error('img') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'img-preview-update-{{ $item->id }}')">
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $item->img) }}" id="img-preview-update-{{ $item->id }}" alt="Preview" class="img-thumbnail" width="100px">
                        </div>
                        @error('img')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="desc{{ $item->id }}">Deskripsi</label>
                        <textarea name="desc" id="desc{{ $item->id }}" class="form-control @error('desc') is-invalid @enderror" rows="4">{{ old('desc', $item->desc) }}</textarea>
                        @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
