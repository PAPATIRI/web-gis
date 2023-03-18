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
            {{-- pada halaman DetailSpot ini kita tidak melakukan looping tapi langsung memanggil
                        variabel yang kita definisikan dari HomeController karena kita hanya akan menampilkan
                        single data saja --}}
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="mb-4">
                        <p class="custom-label-detail">Alamat Toko</p>
                        <p class="custom-data-detail"> {{ $tokoKerajinan->alamat_detail_toko }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="custom-label-detail">Deskripsi</p>
                        <p class="custom-data-detail"> {{ $tokoKerajinan->deskripsi_toko }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="custom-label-detail">jam kerja</p>
                        <p class="custom-data-detail"> {{ $tokoKerajinan->jam_buka }} - {{ $tokoKerajinan->jam_tutup }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="custom-label-detail">kontak</p>
                        <p class="custom-data-detail"> {{ $tokoKerajinan->kontak_toko }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="custom-label-detail">website toko</p>
                        <p class="custom-data-detail"> {{ $tokoKerajinan->website_toko }}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">

                    <p class="custom-label-detail"><strong>Galeri Toko</strong></p>
                    <div class="row gap-4">
                        {{-- @forelse ($galeriProduk as $item)
                            <img src="{{ url('uploads/Foto Sampul Toko/') }}/{{ $galeriProduk->nama_toko }}"
                                alt='toko-img'>
                        @empty
                            <div class="alert alert-warning">
                                <p>toko ini belum menambahkan produknya</p>
                            </div>
                        @endforelse --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('javascript')
    <script>
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
