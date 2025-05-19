@foreach ($galeris as $item)
    <!-- Modal -->
    <div class="modal fade" id="modalDeleteMenu{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Hapus Foto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.GaleriDelete', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <p>
                            Apakah Anda yakin ingin menghapus Foto dengan judul <b>{{ $item->title }}</b>?
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
@endforeach
