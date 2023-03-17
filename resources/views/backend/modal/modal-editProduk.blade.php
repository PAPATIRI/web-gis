<div class="modal-content">
    <form class="" id="formActionEdit" method="POST">
        @csrf
        @method('put')
        <div class="modal-header">
            <h3 class="modal-title" id="myLargeModalLabel" style="color: black">
                <strong>
                 Ubah Produk
               </strong>
            </h3>
        </div>
        <div class="modal-body"> 
            <input type="hidden" value="{{ $data->id }}" name="id_produk">
            {{-- {{ $item->id }} --}}
            <div class="form-group">
                <label for="email2">Nama Produk</label>
                <input type="text" class="form-control" id="namaProduk" placeholder="Masukan Nama produk" name="nama_produk" required value="{{ $data->nama_produk }}">
                {{-- <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
            </div> 
            <div class="form-group">
                <label for="comment">Deskripsi</label>
                <textarea class="form-control" id="comment" rows="5" name="deskripsi_produk" required>{{ $data->deskripsi_produk }}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Foto Produk</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="gambar_produk" >
            </div>
        </div>
        <div class="modal-footer mt-2">
            <button type="button" class="btn btn-danger btn-close btn-sm btn-close" data-bs-dismiss="modal" arial-label="Close"><i class="fas fa-fw fa-times"></i> Batal</button>
            <button type="submit" class="btn btn-success btn-sm" id="update"><i class="far fa-fw fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
    <script>
        
        $('.btn-close').on('click' ,function(){
                $('#modalActionEdit').modal('hide');
        })

        $('#formActionEdit').on('submit', function(e){
                    e.preventDefault()
                    const _form = this
                    const formData = new FormData(_form)
                    const url = this.getAttribute('action')
                        $.ajax({
                            method  : 'post',
                            url     : `{{ url('update-produk') }}`,
                            headers : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data    : formData,
                            processData : false,
                            contentType : false,
                            success : function(res){
                                $('#modalActionEdit').modal('hide');
                                Swal.fire({
                                    icon: res.state,
                                    title: res.title,
                                    text: res.message,
                                    }).then(function(){
                                        location.reload();
                                    })  
                            }
                        })
                });
    </script>
