@extends('layouts.frontend')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    {{-- cdn leaflet fullscreen js dan css --}}
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    <style>
        #map {
            height: 400px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item nav-home">
                    <a href="{{ route('toko') }}" style="text-decoration:none" class="d-flex align-items-center gap-2">
                        <i class="flaticon-home"></i>
                        list toko
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $tokoKerajinan->nama_toko }}</li>
            </ol>
        </nav>
        <div class="custom-detail-header mb-5">
            <div class="custom-map-wrapper">
                <div id="map"></div>
            </div>
            <div class="custom-detail-image-wrapper">
                <img src="{{ url('uploads/Foto Sampul Toko/') }}/{{ $tokoKerajinan->sampul_toko }}" alt='toko-img'
                    class='custom-detail-image'>
                <div>
                    <p class="custom-label-detail mb-4">{{ $tokoKerajinan->nama_toko }}</p>
                    <div class="d-flex mb-3 gap-1">
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-warning"></i>
                        <i class="fa fa fa-star fa-lg text-dark"></i>
                        <i class="fa fa fa-star fa-lg text-dark"></i>
                    </div>
                    <button class="btn btn-{{ $tokoKerajinan->status_toko == 0 ? 'danger' : 'success' }} btn-xs mt-1">
                        @if ($tokoKerajinan->status_toko == 0)
                            <i class="fas fa-fw fa-door-closed"></i> Tutup
                        @else
                            <i class="fas fa-fw fa-door-open"></i> Buka
                        @endif
                    </button>
                </div>
            </div>
        </div>
        <div class="py-5"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 rounded border bg-white p-3">
                    <p class="fs-3 fw-bold text-capitalize">detail toko</p>
                    <hr class="mb-4">
                    <div class="mb-3">
                        <p class="fs-5 fw-bold text-capitalize m-0">Alamat Toko</p>
                        <p class="fs-5"> {{ $tokoKerajinan->alamat_detail_toko }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-5 fw-bold text-capitalize m-0">Deskripsi</p>
                        <p class="fs-5"> {{ $tokoKerajinan->deskripsi_toko }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-5 fw-bold text-capitalize m-0">jam kerja</p>
                        <p class="fs-5"> {{ $tokoKerajinan->jam_buka }} - {{ $tokoKerajinan->jam_tutup }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-5 fw-bold text-capitalize m-0">kontak</p>
                        <p class="fs-5"> {{ $tokoKerajinan->kontak_toko }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-5 fw-bold text-capitalize m-0">website toko</p>
                        <p class="fs-5"> {{ $tokoKerajinan->website_toko }}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 p-3">
                    <p class="fs-3 fw-bold text-capitalize"><strong>Galeri Toko</strong></p>
                    <hr class="mb-5">
                    <div class="d-flex justify-content-center flex-wrap gap-2">
                        {{-- @dump($galeriProduk) --}}
                        @forelse ($galeriProduk as $item)
                            <div class="custom-galeri-img-wrapper">
                                <img class="custom-galeri-img"
                                    src="{{ url('uploads/Galeri Produk/') }}/{{ $item->gambar_produk }}" alt='toko-img'>
                            </div>
                        @empty
                            <div class="alert alert-warning w-100">
                                <p class="fs-5 fw-medium text-center">toko ini belum menambah foto-foto produknya</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <p class="fs-3 fw-bold text-capitalize">review</p>
                <hr class="mb-4">
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i
                        class="fa fa-regular fa-plus"></i> tambah
                    review</button>
                <div class="collapse" id="collapseExample">
                    <div class="w-100 rounded border bg-white p-3 shadow-sm">
                        <form>
                            <div class="mb-3">
                                <label for="rating" class="form-label fs-5 fw-medium">rating toko</label>
                                <div>
                                    <p id="rangeValue" class="fs-5 fw-bold text-primary">0</p>
                                    <Input class="range" type="range" name="rating" value="5" min="0"
                                        max="10" onChange="rangeSlide(this.value)"
                                        onmousemove="rangeSlide(this.value)"></Input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="review" class="form-label fs-5 fw-medium">komentar anda</label>
                                <textarea placeholder="tambahkan review anda" class="form-control" id="review" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary fs-5 fw-md"
                                    style="width:250px">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-center mt-4 gap-3 overflow-x-scroll p-2">
                    <div class="col-sm-12 col-md-6 col-lg-4 card rounded p-4">
                        <p class="fs-5 fw-bold">supri</p>
                        <div class="d-flex mb-3 gap-1">
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                        </div>
                        <p class="fs-6">toko nya lengkap sekali, harga dan kualitasnya sangat worth to buy sih disini,
                            penjualnya juga ramah ramah dan bisa tawar menamwar kalo beli grosir</p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 card rounded p-4">
                        <p class="fs-5 fw-bold">supri</p>
                        <div class="d-flex mb-3 gap-1">
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                        </div>
                        <p class="fs-6">toko nya lengkap sekali, harga dan kualitasnya sangat worth to buy sih disini</p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 card rounded p-4">
                        <p class="fs-5 fw-bold">supri</p>
                        <div class="d-flex mb-3 gap-1">
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                        </div>
                        <p class="fs-6">toko nya lengkap sekali, harga dan kualitasnya sangat worth to buy sih disini</p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 card rounded p-4">
                        <p class="fs-5 fw-bold">supri</p>
                        <div class="d-flex mb-3 gap-1">
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                        </div>
                        <p class="fs-6">toko nya lengkap sekali, harga dan kualitasnya sangat worth to buy sih disini</p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 card rounded p-4">
                        <p class="fs-5 fw-bold">supri</p>
                        <div class="d-flex mb-3 gap-1">
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-warning"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                            <i class="fa fa fa-star fa-sm text-dark"></i>
                        </div>
                        <p class="fs-6">toko nya lengkap sekali, harga dan kualitasnya sangat worth to buy sih disini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('javascript')
    <script>
        // slider script
        function rangeSlide(value) {
            document.getElementById('rangeValue').innerHTML = value;
        }

        // map script
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v10',
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

        var data{{ $tokoKerajinan->id }} = L.layerGroup()

        var map = L.map('map', {
            fullscreenControl: {
                pseudoFullscreen: false
            },
            // Menampilkan nilai lokasi dari tabel toko
            center: [{{ $tokoKerajinan->lokasi_toko }}],
            zoom: 15,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: [streets, data{{ $tokoKerajinan->id }}]
        });

        var baseLayers = {
            "Streets": streets,
            "Satellite": satellite,
            "Dark": dark,
        };

        var overlays = {
            //"Streets": streets
            "{{ $tokoKerajinan->name }}": data{{ $tokoKerajinan->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        // Begitu Juga pada curLocation kita Menampilkan nilai lokasi dari tabel toko
        var curLocation = [{{ $tokoKerajinan->lokasi_toko }}];
        map.attributionControl.setPrefix(false);


        var marker = new L.marker(curLocation);
        map.addLayer(marker);
    </script>
@endpush