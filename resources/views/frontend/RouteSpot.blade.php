@extends('layouts.frontend')

@section('styles')
    {{-- untuk cdn yang di load pada view RouteSpot ini selain cdn dari leaflet js dan leflet fullscreen
    kita juga me-load cdn leaflet routing machine untuk menampilkan rute dari lokasi kita ke lokasi spot
    yang kita pilih --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>

    <style>
        #map {
            height: 500px
        }
    </style>
@endsection

@section('content')
    <div class="container" style="height:100vh">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item nav-home">
                    <a href="{{ route('toko') }}" style="text-decoration:none" class="d-flex align-items-center gap-2">
                        <i class="flaticon-home"></i>
                        list toko
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">rute ke {{ $tokoKerajinan->nama_toko }}</li>
            </ol>
        </nav>
        <div class="justify-content-center">
            <div class="rounded-3 border bg-white p-3 shadow">
                <p class="fs-5 text-capitalize">lokasi anda saat ini menuju toko <span
                        class="fw-bold">{{ $tokoKerajinan->nama_toko }}</span></p>
                <div class="custom-map-wrapper">
                    <div id="map" style="height: 720px;"></div>
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


        // untuk mendapatkan lokasi user kita akan menggunakan navigator object dari html5
        // seperti di bawah
        if (!navigator.geolocation) {
            console.log("Browser doesn't support");
        } else {
            console.log(navigator.geolocation.getCurrentPosition(getPosition));
        }

        var data{{ $tokoKerajinan->id }} = L.layerGroup();

        // fungsi ini untuk menampilkan map secara penuh pada browser
        var map = L.map('map', {
            center: [{{ $tokoKerajinan->lokasi_toko }}],
            fullscreenControl: {
                pseudoFullscreen: false
            },
            zoom: 10,
            layers: [streets, data{{ $tokoKerajinan->id }}]
        });

        // mengatur baselayer
        var baseLayers = {
            "Streets": streets,
            "Satellite": satellite,
            "Dark": dark,
        };

        // mengatur overlayers
        var overlays = {
            "{{ $tokoKerajinan->name }}": data{{ $tokoKerajinan->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);
        L.marker([{{ $tokoKerajinan->lokasi_toko }}]).bindPopup(
            "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $tokoKerajinan->name }}</div>" +
            "<div class='my-2'><a href='{{ route('detail.show', $tokoKerajinan->slug) }}' class='btn btn-outline-info btn-sm'>Detail Spot</a></div>"
        ).addTo(map);


        // Untuk bagian ini kita akan membuat function untuk mendapatkan lokasi koordinat user 
        // membuat variabel marker, circle,latPos (latitude position user),longPos(longitude position user)
        var marker, circle, latPos, longPos

        function getPosition(position) {
            // console.log("ini latitudenya", position.coords.latitude);
            // console.log("ini longitudenya", position.coords.longitude);

            // pada var latPos, longPos dan accuracy kita akan mengambil nilai latitude longitude dan accuracy
            // dengan sintaks position.coords di bawah kemudian memasukkannya pada variabel yang sudah di definisikan

            var latPos = position.coords.latitude
            var longPos = position.coords.longitude
            var accuracy = position.coords.accuracy

            if (marker) {
                map.removeLayer(circle)
            }

            // Kemudian membuat marker dan circle dari masing-masing nilai dari variabel latPos dan longPos
            // yang sudah kita definisikan diatas
            marker = L.marker([latPos, longPos])
            circle = L.circle([latPos, longPos]), {
                radius: accuracy
            }

            // membuat featureGrooup sehinggankita bisa menambahkan beberapa opsi pada layer
            // seperti di bawah kita menambahkan marker, circle, dan popup untuk di tampilkan pada peta
            var featureGroup = L.featureGroup([marker, circle])
                .bindPopup("<div class='text-center'><strong><h4>Lokasi Kamu Disini</h4></strong></div>")
                .addTo(map)
            map.fitBounds(featureGroup.getBounds())

            // Setelah itu buat routing control untuk memuat waypoint (latitude dan longitude) 
            // yang pertama waypoint dari lokasi kita dan yang kedua waypoint lokasi tujuan
            // yang mana nilainya kita dapatkan dari $tokoKerajinan->lokasi_toko

            L.Routing.control({
                waypoints: [
                    L.latLng(latPos, longPos),
                    L.latLng({{ $tokoKerajinan->lokasi_toko }}),
                ],
                // mengatur warna dan ukuran garis penghubung antara lokasi user dan tujuan
                lineOptions: {
                    styles: [{
                        color: 'green',
                        opacity: 1,
                        weight: 3
                    }]
                },
                createMarker: function() {
                    return null
                }
            }).addTo(map);

        }
    </script>
@endpush
