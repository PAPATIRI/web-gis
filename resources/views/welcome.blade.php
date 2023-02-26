@extends('layouts.frontend')

@section('styles')
    {{-- cdn css leaflet  --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    {{-- cdn js leaflet --}}
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    {{-- cdn leaflet fullscreen js dan css --}}
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

    {{-- cdn leaflet search --}}
    <link rel="stylesheet" href="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.css">
    <script src="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.js"></script>
    <style>
        #map {
            height: 500px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <blockquote>
                    <strong>
                        ** Silahkan login untuk menambahkan data spot <br>
                        ** Untuk menggunakan fungsi cek rute pada spot pastikan berikan izin atau
                        permission pada browser yang di gunakan untuk mengakses lokasi sekarang.
                        Jika menggunakan browser smartphone pastikan gps dalam keadaan hidup.
                    </strong>
                </blockquote>
                <div id="map"></div>
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
            fullscreenControl: {
                pseudoFullscreen: false
            },

            // Titik koordinat peta indonesia
            // untuk source code menampilkan peta pada halaman welcome ini masih sama seperti pada
            // halaman backend di file view spot, create.blade. Tapi pada halaman ini kita akan memunculkan 
            // marker dari masing-masing spot yang sudah ditambahkan dan ketika marker itu di klik akan memunculkan 
            // popup yang berisikan informasi dari spot tersebut dan juga tombol untuk melihat
            // rute dari lokasi kita ke lokasi spot yang kita pilih serta tombol detail untuk detail lengkap 
            // dari spot yang dipilih

            center: [-3.196071254860089, 135.50952252328696],
            zoom: 7,
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

        // disini kita melakukan looping dari controller HomeController tepatnya dari method index
        // kemudian hasil dari looping tersebut kita masukkan kedalam function marker untuk memunculkan marker dari tiap-tiap
        // spot dan option bindPopoup.Jadi ketika salah satu amrker yang ada di klik akan memunculkan popup berupa informasi spot,
        // tombol cek rute dan tombol detail spot.

        @foreach ($spots as $item)
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

        // pada variable datas kita akan mendefinisikannya sebagai data array yang mana isian arraynya kita ambil dari
        // looping dari $spots dan variable datas ini akan kita loop lagi dalam perulangan for di bawah
        var datas = [
            @foreach ($spots as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach

        ];

        // pada koding ini kita menambahkan control pencarian data        
        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer);
        var controlSearch = new L.Control.Search({
            position: 'topleft',
            layer: markersLayer,
            initial: false,
            zoom: 17,
            markerLocation: true
        })


        //menambahkan variabel controlsearch pada addControl
        map.addControl(controlSearch);

        // looping variabel datas
        for (i in datas) {
            // lalu hasil loopingan tersebut kita definisikan ke dalam variabel baru,
            // title dan loc selanjutnya kita masukkan ke dalam variabel marker dan marker ini
            // yang akan kita pakai dalam option markersLayer

            // jadi ketika kkta melakukan pencarian data spot, nama dari spot tersebut akan muncul kemudian 
            // jika kita klik nama tersebut akan langsung di arahkan ke spot tersebut dan juga menampilkan marker dari spot itu
            // beserta popup yang berisi informasi spot.

            var title = datas[i].title,
                loc = datas[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);

            // melakukan looping data untuk memunculkan popup dari spot yang dipilih
            @foreach ($spots as $item)
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

        }
        L.control.layers(baseLayers, overlays).addTo(map);
    </script>
@endpush
