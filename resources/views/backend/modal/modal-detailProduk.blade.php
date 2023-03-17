<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title" id="myLargeModalLabel" style="color: black">
            <strong>
             Detail Produk
           </strong>
        </h3>
    </div>
    <div class="modal-body m-2"> 
        <img class="card-img-top" src="{{ url('uploads/Galeri Produk/')}}/{{$data->gambar_produk }}" alt="Card image cap">
            <div class="mt-2">
                <div class="separator-solid"></div>
                <h3 class="card-title" style="font-size: 20px; font-weight:bold; color:#17a2b8">
                    {{ $data->nama_produk }}
                </h3>
                <p class="card-text">{{ $data->deskripsi_produk }}</p>
            </div>
    </div>
    <div class="modal-footer mt-2">
        <button type="button" class="btn btn-danger btn-close btn-sm" data-bs-dismiss="modal" arial-label="Close"><i class="fas fa-fw fa-times"></i> Tutup</button>
        {{-- <button type="submit" class="btn btn-success btn-sm"><i class="far fa-fw fa-save"></i> Simpan</button> --}}
    </div>
</div>
    <script>
        $('.btn-close').on('click' ,function(){
                $('#modalActionDetail').modal('hide');
            })
    </script>
