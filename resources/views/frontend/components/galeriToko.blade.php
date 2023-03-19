<div class="d-flex justify-content-center mb-4 flex-wrap gap-2">
    @forelse ($galeriProduk as $item)
        <div class="custom-galeri-img-wrapper">
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
