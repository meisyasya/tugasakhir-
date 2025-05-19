@foreach ($categories as $item)
    <!-- Modal -->
    <div class="modal fade" id="modalUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Edit Kategori Artikel</h1> <!-- ID label sesuai dengan modal -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('admin.CategoryArticleUpdate', $item->id) }}" method="post"> <!-- Perbaikan route -->
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="name{{ $item->id }}">Nama</label>
                            <input type="text" name="name" id="name{{ $item->id }}" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}"> <!-- Sesuaikan ID input -->
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
