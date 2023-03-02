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
                <div id="carouselExampleCaptions" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('img/tas-kulit.jpg') }}" class="d-block w-100" alt="...">
                            <div class="overlay"></div>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Mudah Mencari Oleh-oleh Kerajinan Tangan</h5>
                                <p>temukan oleh-oleh kerajinan tangan khas merauke di sini</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/aneka-kerajinan.webp') }}" class="d-block w-100" alt="...">
                            <div class="overlay"></div>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Pilihan Produk Beragam</h5>
                                <p>pilihan produk yang beragam dari berbagai toko yang tersebar di seluruh Merauke</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/aneka-kerajinan2.jpg') }}" class="d-block w-100" alt="...">
                            <div class="overlay"></div>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Cepat Mendapatkan Barang Incaran Kamu</h5>
                                <p>cek lokasi toko kerajinan tangan terdekat dari lokasi kamu saat ini juga</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
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


        // looping variabel datas
        for (i in datas) {
            //     // lalu hasil loopingan tersebut kita definisikan ke dalam variabel baru,
            //     // title dan loc selanjutnya kita masukkan ke dalam variabel marker dan marker ini
            //     // yang akan kita pakai dalam option markersLayer

            //     // jadi ketika kkta melakukan pencarian data spot, nama dari spot tersebut akan muncul kemudian 
            //     // jika kita klik nama tersebut akan langsung di arahkan ke spot tersebut dan juga menampilkan marker dari spot itu
            //     // beserta popup yang berisi informasi spot.

            var title = datas[i].title,
                loc = datas[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            // markersLayer.addLayer(marker);

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
