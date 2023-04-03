{{-- Modal Detail Produk --}}
<div class="modal-dialog modal-lg">
    {{-- Ambil dari blade action --}}
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title fs-4 fw-bold text-capitalize" id="myLargeModalLabel" style="color: black">
                {{ $data->nama_produk }}
            </h3>
            <button type="button" class="btn btn-danger btn-close btn-sm" data-bs-dismiss="modal"
                arial-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center items-center">
                <div class="custom-img-modal-wrapper">
                    <img class="card-img-top custom-img-modal"
                        src="{{ url('uploads/Galeri Produk/') }}/{{ $data->gambar_produk }}" alt="Card image cap">
                </div>
            </div>
        </div>
        <div class="mt-3 px-2 m-2">
            <hr />
            <h3 class="" style="font-size: 20px; font-weight:bold; color:#878787">
                Rp {{ number_format($data->harga_produk)  }}
            </h3>
            <p class="fs-6">{{ $data->deskripsi_produk }}</p>
        </div>
    </div>
</div>
