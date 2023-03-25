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
@endsection
<style>
    #map {
        height: 400px;
    }
</style>

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
        <div class="position-relative">
            <div class="custom-map-wrapper" data-aos="zoom-in">
                <div id="map"></div>
            </div>
            <div class="custom-data-toko-wrapper" data-aos="fade-right">
                <img class='custom-detail-image'
                    src="{{ url('uploads/Foto Sampul Toko/') }}/{{ $tokoKerajinan->sampul_toko }}" alt='toko-img'>
                <div class="w-100">
                    <p class="fs-4 fw-bold text-capitalize m-0">{{ $tokoKerajinan->nama_toko }}</p>
                    <div>
                        @if ($overalRating == 0)
                            <p class="fs-5">{{ $overalRating }}/5 <i class="far fa-star fa-lg text-secondary"></i>
                            </p>
                        @else
                            <p class="fs-5">
                                {{ $overalRating }}/5 <i class="fa fa fa-star fa-lg text-warning"></i>
                            </p>
                        @endif
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
        <div class="my-5 py-3"></div>
        <div class="container">
            <div class="row" data-aos="fade-right">
                <div class="col-sm-12 col-md-4 rounded border bg-white p-3">
                    <p class="fs-3 fw-bold text-capitalize">detail toko</p>
                    <hr class="mb-4">
                    <div class="mb-3">
                        <p class="fs-6 fw-bold text-capitalize m-0"><i class="fas fa-map-marker-alt"></i> Alamat Toko
                        </p>
                        <p class="fs-5"> {{ $tokoKerajinan->alamat_detail_toko }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-6 fw-bold text-capitalize m-0"><i class="fas fa-question-circle"></i> Deskripsi</p>
                        <p class="fs-5"> {{ $tokoKerajinan->deskripsi_toko }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-6 fw-bold text-capitalize m-0"><i class="fas fa-clock"></i> jam kerja</p>
                        <p class="fs-5"> {{ $tokoKerajinan->jam_buka }} - {{ $tokoKerajinan->jam_tutup }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-6 fw-bold text-capitalize m-0"><i class="fas fa-phone"></i> kontak</p>
                        <p class="fs-5"> {{ $tokoKerajinan->kontak_toko }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-6 fw-bold text-capitalize m-0"><i class="fas fa-globe-asia"></i> website toko</p>
                        <p class="fs-5"> {{ $tokoKerajinan->website_toko }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-6 fw-bold text-capitalize m-0"><i class="fas fa-user"></i> Pemilikk toko</p>
                        <p class="fs-5"> {{ $tokoKerajinan->pemilik->name }}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 p-3">
                    <p class="fs-3 fw-bold text-capitalize"><strong>Galeri Toko</strong></p>
                    <hr class="mb-5">
                    <div class="">
                        @include('frontend.components.galeriToko')
                    </div>
                </div>
            </div>
            <div class="mt-5" data-aos="fade-up">
                @include('frontend.components.formTambahRating')
                <div class="row justify-content-center rating-pagination mt-4 gap-3 overflow-x-scroll p-2" id="rating-data">
                    @include('frontend.components.ratingToko')
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('javascript')
    {{-- ajax pagination rating komentar toko --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('.btn-close').on('click', function() {
            $('#modalAction').modal('hide');
        })

        // Proses CRUD
        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('.galeri-toko').on('click', '#action', function() {
            let data = $(this).data()
            let id = data.id
            let jenis = data.jenis

            if (jenis == 'detail') {
                // alert('Detail'+id)
                $('#modalActionDetail').modal('show');
                $.ajax({
                    method: 'get',
                    url: `{{ url('detail-foto') }}/${id}`,
                    success: function(res) {
                        $('#modalActionDetail').find('.modal-dialog').html(res)
                        $('#modalActionDetail').modal('show');

                    }
                })
            }
        })
    </script>
    <script>
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    // getData(page);
                    getRatingData(page)
                }
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.rating-pagination .pagination a', function(event) {
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                event.preventDefault();
                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];
                getRatingData(page);
            });
        });

        function getRatingData(page) {
            $.ajax({
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html",
                })
                .done(function(data) {
                    $("#rating-data").empty().html(data);
                    location.hash = page;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('No response from server');
                });
        }
    </script>
    <script>
        // slider script
        function rangeSlide(value) {
            document.getElementById('rangeValue').innerHTML = value + ' ' +
                '<i class="fa fa fa-star fa-lg text-warning"></i>';
        }

        // map script
        var data{{ $tokoKerajinan->id }} = L.layerGroup()
        var map = L.map('map', {
            fullscreenControl: true,
            // Menampilkan nilai lokasi dari tabel toko
            center: [{{ $tokoKerajinan->lokasi_toko }}],
            zoom: 15,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: data{{ $tokoKerajinan->id }}
        });
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Begitu Juga pada curLocation kita Menampilkan nilai lokasi dari tabel toko
        var curLocation = [{{ $tokoKerajinan->lokasi_toko }}];
        map.attributionControl.setPrefix(false);


        var marker = new L.marker(curLocation);
        marker.bindPopup(
            "<div class='my-2 d-flex justify-content-between'><p class='fs-6 fw-medium text-center'>ini lokasi toko kami silahkan datang berkunjung 😊</p><a href='{{ route('cek-rute', $tokoKerajinan->id) }}' class='visually-hidden btn btn-primary text-white btn'>Lihat Rute</a>"
        ).openPopup();
        map.addLayer(marker);
    </script>
@endpush
