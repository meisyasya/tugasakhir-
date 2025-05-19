@foreach ($categories as $item)
    <!-- Modal -->
    <div class="modal fade" id="modalDelete{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Hapus Kategori Galeri</h1> <!-- ID label sesuai dengan modal -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('admin.CategoryGaleriDelete', $item->id) }}" method="post"> <!-- Perbaikan route -->
                        @method('DELETE')
                        @csrf
                        <div class="mb-3">
                           <p>
                            Apakah Anda Yakin Mengapus Category dengan Nama <b>{{ $item->name }}</b>?
                           </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endforeach
