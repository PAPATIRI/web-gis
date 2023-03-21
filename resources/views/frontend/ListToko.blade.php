@extends('layouts.frontend')

@section('styles')
    <style>
        #map {
            height: 450px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="custom-map-wrapper" data-aos="zoom-in">
            <div id="map"></div>
        </div>
        <div class="row justify-content-center mt-5 gap-3">
            @forelse ($tokoKerajinan as $item)
                <div class="col-sm-12 col-md-6 col-lg-3 card pb-2" data-aos="fade-up" data-anchor-delay="400">
                    <div class="custom-img-map-wrapper">
                        <img src='{{ url('uploads/Foto Sampul Toko/') }}/{{ $item->sampul_toko }}' alt="toko-img"
                            class='card-img-top custom-img-map'>
                        <div class="custom-card-title-wrapper">
                            <h5 class="card-title">{{ $item->nama_toko }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $item->deskripsi_toko }}</p>
                    </div>
                    <a href="{{ route('detailtoko', $item->id) }}" class="btn btn-primary mx-3">Selengkapnya</a>
                </div>
            @empty
                <div class="alert alert-danger">
                    upss, data masih kosong nih
                </div>
            @endforelse
            <div class="d-flex justify-content-center">
                {!! $tokoKerajinan->links() !!}
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        var description = document.getElementsByClassName('card-text');
        var title = document.getElementsByClassName('card-title')

        function truncate(words, maxlength, typeText) {
            if (typeText === 'title') {
                return `<p>${words.slice(0, maxlength)}</p>`;
            }
            return `<p>${words.slice(0, maxlength)}...</p>`;
        }
        // memperpendek title toko di card
        for (var i = 0; i < title.length; i++) {
            title[i].innerHTML = truncate(title[i].textContent, 30, 'title');
        }

        // memperpendek text dari deskripsi di card toko
        for (var i = 0; i < description.length; i++) {
            description[i].innerHTML = truncate(description[i].textContent, 100, 'description')
        }
    </script>
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

            // Titik koordinat peta merauke
            // untuk source code menampilkan peta pada halaman welcome ini masih sama seperti pada
            // halaman backend di file view spot, create.blade. Tapi pada halaman ini kita akan memunculkan 
            // marker dari masing-masing spot yang sudah ditambahkan dan ketika marker itu di klik akan memunculkan 
            // popup yang berisikan informasi dari spot tersebut dan juga tombol untuk melihat
            // rute dari lokasi kita ke lokasi spot yang kita pilih serta tombol detail untuk detail lengkap 
            // dari spot yang dipilih

            center: [-8.499137749030071, 140.4046483416395],
            zoom: 13,
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

        // disini kita melakukan looping dari controller ListTokoController tepatnya dari method index
        // kemudian hasil dari looping tersebut kita masukkan kedalam function marker untuk memunculkan marker dari tiap-tiap
        // spot dan option bindPopoup.Jadi ketika salah satu amrker yang ada di klik akan memunculkan popup berupa informasi spot,
        // tombol cek rute dan tombol detail spot.


        // pada variable datas kita akan mendefinisikannya sebagai data array yang mana isian arraynya kita ambil dari
        // looping dari $spots dan variable datas ini akan kita loop lagi dalam perulangan for di bawah
        var datas = [
            @foreach ($tokoKerajinan as $key => $value)
                {
                    "loc": [{{ $value->lokasi_toko }}],
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
            @foreach ($tokoKerajinan as $item)
                L.marker([{{ $item->lokasi_toko }}])
                    .bindPopup(
                        "<img src='{{ url('uploads/Foto Sampul Toko/') }}/{{ $item->sampul_toko }}' alt='toko-img' class='custom-img-map'>" +
                        "<div class='my-2'><strong>Nama Toko:</strong> <br>{{ $item->nama_toko }}</div>" +


                        "<div class='my-2 d-flex justify-content-between'><a href='{{ route('cek-rute', $item->id) }}' class='btn btn-outline-light btn-sm'>Lihat Rute</a> <a href='{{ route('detailtoko', $item->id) }}' class='btn btn-primary btn-sm text-light'>Detail Toko</a></div>" +
                        "<div class='my-2'></div>"

                    ).addTo(map);
            @endforeach

        }
        L.control.layers(baseLayers, overlays).addTo(map);
    </script>
@endpush
