<div class="d-flex justify-content-center galeri-toko mb-4 flex-wrap gap-2" data-aos="fade-up" data-aos-delay="300">
    @forelse ($galeriProduk as $item)
        <div class="custom-galeri-img-wrapper" id="action" type="button" data-toggle="tooltip" title="Detail Produk"
            class="btn btn-link btn-success action" data-original-title="Edit Task" data-id="{{ $item->id }}"
            data-jenis="detail">
            <img class="custom-galeri-img" src="{{ url('uploads/Galeri Produk/') }}/{{ $item->gambar_produk }}"
                alt='toko-img'>
        </div>
    @empty
        <div class="bg-warning w-100 rounded p-3">
            <p class="fs-5 fw-medium text-center">toko ini belum menambah foto-foto produknya</p>
        </div>
    @endforelse
</div>
<div class="d-flex justify-content-center">
    {!! $galeriProduk->links() !!}
</div>

{{-- Modal Detail Produk --}}
<div id="modalActionDetail" class="modal modal-xl fade" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        {{-- Ambil dari blade action --}}

    </div>
</div>
