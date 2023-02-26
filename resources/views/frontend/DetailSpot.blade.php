@extends('layouts.frontend')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <style>
        #map {
            height: 500px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Detail') }}</div>

                    <div class="card-body">
                        {{-- pada halaman DetailSpot ini kita tidak melakukan looping tapi langsung memanggil
                        variabel yang kita definisikan dari HomeController karena kita hanya akan menampilkan
                        single data saja --}}
                        <p>
                        <h4><strong>Nama Spot</strong></h4>
                        <h4>{{ $spots->name }}</h4>
                        </p>
                        <p>
                        <h4><strong>Kategori Spot</strong></h4>
                        @foreach ($spots->getCategory as $item)
                            <h4>{{ $item->name }}</h4>
                        @endforeach
                        </p>
                        <p>
                        <h4><strong>Deskripsi</strong></h4>
                        <h4>
                            <p>{{ $spots->description }}</p>
                        </h4>
                        </p>
                        <p>
                        <h4><strong>Foto Utama</strong></h4>
                        {{-- <img class="img-fluid" width="200" src="{{ asset('uploads/covers/' . $spots->cover) }}" alt="">  --}}
                        <img class="img-fluid" width="200" src="{{ $spots->getImage() }}" alt="">
                        </p>

                        <p>
                        <h4><strong>Foto Lainnya</strong></h4>
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @forelse ($spots->getImages as $key => $item)
                                    <div class="carousel-item {{ $key == null ? 'active' : '' }}">
                                        <img src="{{ $item->ListImages() }}" class="d-block w-100" alt="...">
                                    </div>
                                @empty
                                    <div class="carousel-item active">
                                        <h4>Belum Ada Gambar Lainnya</h4>
                                    </div>
                                @endforelse
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        </p>
                        <a href="{{ route('cek-rute', $spots->slug) }}" class="btn btn-primary btn-sm">Lihat Rute</a>
                        <hr>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Map</div>
                    <div class="card-body">
                        <div id="map"></div>
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

        var data{{ $spots->id }} = L.layerGroup()

        var map = L.map('map', {
            // Menampilkan nilai lokasi dari tabel spot
            center: [{{ $spots->location }}],
            zoom: 20,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: [streets, data{{ $spots->id }}]
        });

        var baseLayers = {
            "Streets": streets,
            "Satellite": satellite,
            "Dark": dark,
        };

        var overlays = {
            //"Streets": streets
            "{{ $spots->name }}": data{{ $spots->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        // Begitu Juga pada curLocation kita Menampilkan nilai lokasi dari tabel spot
        var curLocation = [{{ $spots->location }}];
        map.attributionControl.setPrefix(false);


        var marker = new L.marker(curLocation);
        map.addLayer(marker);
    </script>
@endpush
