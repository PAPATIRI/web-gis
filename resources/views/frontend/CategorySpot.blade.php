@extends('layouts.frontend')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    <style>
        #map {
            height: 500px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Kategori {{ $category->name }}

                    </div>
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

        var map = L.map('map', {
            center: [-3.196071254860089, 135.50952252328696],
            zoom: 7,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: [streets]
        });

        var baseLayers = {
            "Grayscale": dark,
            "Satellite": satellite,
            "Streets": streets
        };

        var overlays = {
            "Streets": streets,
            "Grayscale": dark,
            "Satellite": satellite,
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        // Struktur koding pada halaman CategorySpot masih sama yang membedakan hanya
        // pemanggilan data dari HomeController. Di bawah kita melakukan looping untuk menampilkan
        // data spot dan markernya sesuai dengan kategori yang kita pilih 
        @foreach ($spot as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->name }}</div>" +
                    @foreach ($item->getCategory as $itemCategory)
                        "<div class='my-2'><strong>Kategori Spot:</strong> <br>{{ $itemCategory->name }}</div>" +
                    @endforeach
                    "<div class='my-2'><a href='{{ route('cek-rute', $item->slug) }}' class='btn btn-outline-primary btn-sm'>Lihat Rute</a> <a href='{{ route('detail.show', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Spot</a></div>" +
                    "<div class='my-2'></div>"

                ).addTo(map);
        @endforeach
    </script>
@endpush
