@extends('backend.layouts.master')
@section('container')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                {{-- <h4 class="page-title">{{ $title }}</h4> --}}
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">{{ $title  }}</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detail Toko, <strong>{{ $item->nama_toko }}</strong></h4>
                        </div>
                        {{-- <form action="#" method="post"> --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px;">Nama Toko</small>
                                        <label for="email2" style="font-size: 20px"><h3 style="font-weight:bold">{{ $item->nama_toko }}</h3></label>
                                    </div>
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Website</small>
                                        <label for="email2" style="font-size: 20px"><h3 style="font-weight:bold">{{ $item->website_toko }}</h3></label>
                                    </div>
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Kontak Person</small>
                                        <label for="email2" style="font-size: 20px"><h3 style="font-weight:bold">{{ $item->kontak_toko }}</h3></label>
                                    </div>
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Jam Pelayanan</small>
                                        <label for="email2" style="font-size: 20px"><h3 style="font-weight:bold">{{ $item->jam_buka }} - {{ $item->jam_tutup }}</h3></label>
                                    </div>
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Deskripsi Toko</small>
                                        <label for="email2" style="font-size: 20px"></label>{{ $item->deskripsi_toko }}</label>
                                    </div>
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Status Toko</small>
                                        <label for="email2">
                                            <button class="btn btn-{{ $item->status_toko==0 ? 'danger' : 'success' }} btn-xs mt-1">
                                                
                                                @if ($item->status_toko == 0)
                                                    <i class="fas fa-fw fa-door-closed"></i> Tutup
                                                    @else
                                                    <i class="fas fa-fw fa-door-open"></i> Buka
                                                @endif
                                            </button>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Foto Profile Toko</small>
                                        <img class="card-img-top mt-2" src="{{ url('uploads/Foto Sampul Toko') }}/{{ $item->sampul_toko }}" alt="Card image cap">
                                    </div>
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Alamat Toko</small>
                                        <img class="card-img-top mt-2" src="/assetBackend/img/backgroundLogin.jpg" alt="Card image cap">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <small id="emailHelp2" class="form-text text-danger" style="font-size: 14px">Rating Toko</small>
                                        <span class="btn-label" style="font-size: 40px;font-weight:bold"><i class="fas fa-star mt-4" style="color:rgb(255, 153, 0); font-size:3rem"></i> {{ $overalRating }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Galeri Produk</h4>
                        </div>
                        <div class="card-body galeri">
                            <button type="button" class="btn btn-info" id="tambahProduk"><i class="fa fa-fw fa-plus"></i> Tambah Produk</button>
                            <div class="row">
                                @foreach ($galeriProduk as $produk)
                                <div class ="col-md-3 mt-4">
                                    <div class="card card-post card-round">
                                        <input type="hidden" value="{{ $produk->id }}" id="id" class="id">
                                        <img class="card-img-top" src="{{ url('uploads/Galeri Produk/')}}/{{$produk->gambar_produk }}" alt="Card image cap">
                                        <div class="card-body">
                                            <div class="separator-solid"></div>
                                            <h5 class="card-title" style="font-size: 18px; font-weight:bold; color:#17a2b8">
                                                {{ $produk->nama_produk }}
                                            </h5>
                                            <p class="card-text">{{ $produk->deskripsi_produk }}</p>
                                            <button type="button"class="btn btn-primary btn-sm btn-ubah"><i class="fas fa-fw fa-pen-square"></i> Ubah</button>
                                            <button type="button"class="btn btn-danger btn-sm btn-hapus" id="btn-hapus" data-id="{{ $item->id }}"><i class="fas fa-fw fa-trash"></i> Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add toko --}}
    <div id="modalAction" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Ambil dari blade action --}}
            <div class="modal-content">
                <form class="" id="formAction" action="{{ route('toko.simpanProduk') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title" id="myLargeModalLabel" style="color: black">
                            <strong>
                             Tambah Produk
                           </strong>
                        </h3>
                    </div>
                    <div class="modal-body"> 
                        <input type="hidden" value="{{ $item->id }}" name="fkid_toko">
                        {{-- {{ $item->id }} --}}
                        <div class="form-group">
                            <label for="email2">Nama Produk</label>
                            <input type="text" class="form-control" id="namaProduk" placeholder="Masukan Nama produk" name="nama_produk" required>
                            {{-- <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                        </div> 
                        <div class="form-group">
                            <label for="comment">Deskripsi</label>
                            <textarea class="form-control" id="comment" rows="5" name="deskripsi_produk" required>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto Produk</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="gambar_produk" required>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-close btn-sm" data-bs-dismiss="modal" arial-label="Close"><i class="fas fa-fw fa-times"></i> Batal</button>
                        <button type="submit" class="btn btn-success btn-sm"><i class="far fa-fw fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backend.layouts.footer')
        <script>
             $('.btn-close').on('click' ,function(){
                $('#modalAction').modal('hide');
            })
             $('#tambahProduk').on('click' ,function(){
                $('#modalAction').modal('show');
            })

             $('.btn-ubah').on('click' ,function(){
                $('#modalAction').modal('show');
            })
            
            //  $('.btn-hapus').on('click' ,function(){
                // $('#modalAction').modal('show');
                $('.galeri').on('click','.btn-hapus',function(){
                let data    = $(this).data()
                let id      = data.id
                // let id      = $('.id').val();
                console.log(id);
                Swal.fire({
                title: "Anda Yakin ?",
                text: "Data produk akan di hapus !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Yakin"
                    }).then(result => {
                        if (result.value) {
                        $.ajax({
                            method  : 'DELETE',
                            url     : `{{ url('hapus-foto-produk') }}/${id}`,
                            headers : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function(res){
                                // window.LaravelDataTables["produk-table"].ajax.reload();
                                // $('#totalProduk').load(window.location.href + " #totalProduk")
                            }
                        })
                        }   
                    });
            })

            // Proses simpan galeri baru
            $('#formAction').on('submit', function(e){
                e.preventDefault()
                const _form = this
                const formData = new FormData(_form)
                const url = this.getAttribute('action')
                    $.ajax({
                        method  : 'post',
                        url     : url,
                        headers : {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data    : formData,
                        processData : false,
                        contentType : false,
                        success : function(res){
                            $('#modalAction').modal('hide');
                            var content = {};
                            var from ='top';
                            var align = 'right';
                            var state = res.state;
                            content.message = res.message;
                            content.title = res.title;
                            content.icon = 'fas fa-check';
                                $.notify(content,{
                                        type: state,
                                        placement: {
                                            from: from,
                                            align: align
                                        },
                                        time: 1,
                                        delay: 1,
                                });
                            // resetForm();
                            $('.reloadPageGaleri').load(window.location.href + " .reloadPageGaleri")
                        }
                    })
            });
        </script>
    </div>
@endsection
