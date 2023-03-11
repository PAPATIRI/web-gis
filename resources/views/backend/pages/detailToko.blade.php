@extends('backend.layouts.master')
@section('styles')
    {{-- pada section styles kita menambahkan style css untuk menampilkan plugin leaflet dan select2 untuk select option kategori spot --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <style>
        #map {
            height: 100px
        }
    </style>
@endsection
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



@push('javascript')
  
    {{-- <script src="{{ url('assetBackend/js/core/jquery.3.2.1.min.js')}}"></script> --}}
    {{-- <script src="{{ url('assetBackend/js/core/jquery.min.js')}}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // menjalankan fungsi select2 untuk properti category_id
        $(document).ready(function() {
            $('.category_id').select2({
                placeholder: 'Pilih Data Kategori'
            })

            $('#tambahProduk').on('click' ,function(){
                // console.log('Test');
                alert('Test');
                // alert('Test')
            })

        })

        // membuat variabel untuk load attribute dan url pada map
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        // membuat var satellite, dark, dan streets agar layer map kita punya beberapa opsi tampilan yang bisa kita ubah 
        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            streets = L.tileLayer(mbUrl, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            });

        // mendefinisikan var map. Menambahkan opsi seperti center untuk menentukan latitude dan longitude,
        // mengantur zoom map saat di load dan memuat layer yang di inginkan.
        // Untuk nilai dari latitude longitude bisa disesuaikan dengan lokasi yang di inginkan 
        // nilai latitude dan longitude bisa di ambil dari google map
        var map = L.map('map', {
            // center: [-0.4922612112757657, 117.14561375238749],
            center: [-3.196071254860089, 135.50952252328696],
            zoom: 7,
            layers: [streets]
        });

        // set baselayer yang ingin digunakan
        var baseLayers = {
            //"Grayscale": grayscale,
            "Streets": streets
        };

        // set overlayer yang ingin digunakan
        var overlays = {
            "Streets": streets
        };

        // menambahkan baselayer dan overlays tadi ke dalam control dan di tampilkan ke tag map
        L.control.layers(baseLayers, overlays).addTo(map);


        // set koordinat lokasi ke dalam curLocation yang mana nilai dari curLocation juga akan
        // digunakan untuk menampilkan marker pada map
        var curLocation = [-0.4922612112757657, 117.14561375238749];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'true',
        });
        map.addLayer(marker);

        // dan ketika marker tersebut di geser akan mendapatkan titik koordinat yaitu latitude  dan longitudenya
        // lalu menambahkan titik koordinat tersebut ke dalam tag input dengan namenya location 
        marker.on('dragend', function(event) {
            var location = marker.getLatLng();
            marker.setLatLng(location, {
                draggable: 'true',
            }).bindPopup(location).update();

            $('#location').val(location.lat + "," + location.lng).keyup()
        });

        // selain itu dengan fungsi di bawah juga bisa mendapatkan nilai latitude dan longitude
        // dengan cara klik lokasi pada map maka nilai latitude dan longitudenya juga akan
        // langsung muncul pada input text location

        var loc = document.querySelector("[name=location]");
        map.on("click", function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map);
            } else {
                marker.setLatLng(e.latlng);
            }
            loc.value = lat + "," + lng;
        });
    </script>
@endpush
