@extends('layouts.frontend')

@section('styles')
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
                {{-- jumbotron section --}}
                <div class="custom-jumbotron" data-aos="zoom-in">
                    <div class="custom-jumbotron-text-wrapper">
                        <h2>temukan kerajinan tangan berkualitas khas merauke untuk oleh-oleh keluarga anda</h2>
                    </div>
                    <img src="{{ asset('img/aneka-kerajinan.webp') }}" class="img-fluid rounded" alt="...">
                    <div class="custom-overlay"></div>
                </div>
                {{-- end of jumbotron section --}}
                {{-- search CTA section --}}
                <div class="row custom-section-wrapper mb-5">
                    <div class="col-sm-12 col-md-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
                        <div class="custom-section-img-wrapper">
                            <img src="{{ asset('img/searching.png') }}" class="img-fluid rounded" alt="...">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 d-flex items-center" data-aos="fade-left" data-aos-delay="300">
                        <div class="d-flex flex-column justify-content-center custom-search-section-wrapper">
                            <h2 class="custom-section-title">cari oleh-oleh dengan mudah</h2>
                            <p class="custom-section-desc">toko kerajinan tangan khas di merauke tersebar di
                                seluruh
                                merauke. kamu dapat menemukan
                                dengan
                                mudah dengan memanfaatkan fitur GIS (Geographic Information System) di sini</p>
                            <a href="{{ route('toko') }}" class="btn btn-success">Cari Sekarang</a>
                        </div>
                    </div>
                </div>
                {{-- end of search CTA section --}}
                {{-- rating section --}}
                <div class="row custom-section-wrapper mb-5 mb-5">
                    <div class="col-sm-12 order-sm-2 order-md-1 col-md-6 d-flex custom-order-xs-2 items-center"
                        data-aos="fade-right" data-aos-delay="300">
                        <div class="d-flex flex-column justify-content-center custom-rating-section-wrapper">
                            <h2 class="custom-section-title">toko produk dengan rating terbaik</h2>
                            <p class="custom-section-desc">tidak perlu khawatir dengan kualitas produk yang ditawarkan toko.
                                lihat rating yang telah diberikan pelanggan sebelum kamu untuk menambah keyakinan kamu atas
                                produk incaranmu</p>
                        </div>
                    </div>
                    <div class="col-sm-12 order-sm-1 order-md-2 col-md-6 d-flex align-items-center custom-order-xs-1"
                        data-aos="fade-left">
                        <div class="custom-section-img-wrapper">
                            <img src="{{ asset('img/rating.png') }}" class="img-fluid rounded" alt="...">
                        </div>
                    </div>
                </div>
                {{-- seller CTA section --}}
                <div class="row custom-section-wrapper mb-5">
                    <div class="col-sm-12 col-md-6 d-flex align-items-center" data-aos="fade-right">
                        <div class="custom-section-img-wrapper">
                            <img src="{{ asset('img/get-money.png') }}" class="img-fluid rounded" alt="...">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 d-flex items-center" data-aos="fade-left" data-aos-delay="300">
                        <div class="d-flex flex-column justify-content-center custom-search-section-wrapper">
                            <h2 class="custom-section-title">Tingkatkan Penjualan Toko kamu sekarang!</h2>
                            <p class="custom-section-desc">kamu mempunyai toko yang menjual kerajinan tangan? jangan ragu
                                untun daftarkan tokomu agar lebih dikenal oleh konsumen secara luas dan tingkatkan hasil
                                penjualanmu
                            </p>
                            <a href="{{ route('login') }}" class="btn btn-success">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
                {{-- end of seller CTA section --}}
                {{-- map section --}}
                <div class="custom-section-wrapper">
                    <h2 class="custom-map-section-title" data-aos="fade-up">toko kerajinan tangan merauke tersebar di
                        seluruh kota loh!</h2>
                    <p class="custom-section-desc px-md-4 text-center" data-aos="fade-up" data-anchor-delay="500">lebih
                        mudah mencari toko oleh-oleh
                        kerajinan tangan
                        khas
                        Merauke dengan
                        fitur GIS di situs ini. untuk para pemilik toko, ayo daftarkan toko kamu sekarang juga!</p>
                    <div class="custom-map-wrapper" data-aos="zoom-in" data-anchor-delay="1000">
                        <div id="map"></div>
                    </div>
                </div>
                {{-- end of map section --}}
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

        // disini kita melakukan looping dari controller HomeController tepatnya dari method index
        // kemudian hasil dari looping tersebut kita masukkan kedalam function marker untuk memunculkan marker dari tiap-tiap
        // spot dan option bindPopoup.Jadi ketika salah satu amrker yang ada di klik akan memunculkan popup berupa informasi spot,
        // tombol cek rute dan tombol detail spot.

        // @foreach ($tokoKerajinan as $item)
        //     L.marker([{{ $item->lokasi_toko }}])
        //         .bindPopup(
        //             "<img src='{{ url('uploads/Foto Sampul Toko/') }}/{{ $item->sampul_toko }}' alt='...' class='custom-img-map'>" +
        //             "<div class='my-2'><strong>Nama Toko:</strong> <br>{{ $item->nama_toko }}</div>" +

        //             "<div class='my-2 d-flex justify-content-between'><a href='{{ route('cek-rute', $item->slug) }}' class='btn btn-outline-light btn-sm'>Lihat Rute</a> <a href='{{ route('detail.show', $item->slug) }}' class='btn btn-primary btn-sm text-light'>Detail Spot</a></div>" +
        //             "<div class='my-2'></div>"

        //         ).addTo(map);
        // @endforeach

        // pada variable datas kita akan mendefinisikannya sebagai data array yang mana isian arraynya kita ambil dari
        // looping dari $spots dan variable datas ini akan kita loop lagi dalam perulangan for di bawah
        var datas = [
            @foreach ($tokoKerajinan as $key => $value)
                {
                    "loc": [{{ $value->lokasi_toko }}],
                    "title": '{!! $value->nama_toko !!}'
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
                        "<div class='mt-2 mb-3'><strong>Nama Toko:</strong> <br>{{ $item->nama_toko }}</div>" +

                        "<div class='my-2 d-flex justify-content-between'><a href='{{ route('cek-rute', $item->slug) }}' class='btn btn-outline-light btn-sm'>Lihat Rute</a> <a href='{{ route('detail.show', $item->slug) }}' class='btn btn-primary btn-sm text-light'>Detail Spot</a></div>" +
                        "<div class='my-2'></div>"

                    ).addTo(map);
            @endforeach

        }
        L.control.layers(baseLayers, overlays).addTo(map);
    </script>
@endpush
