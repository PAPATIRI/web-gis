@extends('backend.layouts.master')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    {{-- cdn leaflet fullscreen js dan css --}}
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
@endsection
@section('container')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    {{-- <h4 class="page-title">{{ $title }}</h4> --}}
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <a href="#">
                                <i class="flaticon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">{{ $title }}</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Toko Saya</h4>
                            </div>
                            <form action="{{ route('toko.simpanToko') }}" method="post" id="formAction">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" value="{{ Auth::user()->id }}" name="fkid_user">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="toko">Nama Toko</label>
                                                <input type="text" class="form-control" id="namaToko"
                                                    placeholder="Masukan Nama Toko" name="nama_toko" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="toko">Alamat Detail Toko</label>
                                                <input type="text" class="form-control" id="alamatDetailToko"
                                                    placeholder="Masukan detail alamat" name="alamat_detail_toko" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="toko">Website</label>
                                                <div class="input-group">
                                                    <input type="text" id="websiteToko" class="form-control"
                                                        placeholder="Masukan url website toko"
                                                        aria-label="Recipient's username" aria-describedby="basic-addon2"
                                                        name="website_toko">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                            id="basic-addon2">contoh-url.com</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="toko">Kontak Person</label>
                                                <input type="number" class="form-control" id="kontakToko"
                                                    placeholder="Masukan Kontak person" name="kontak_toko" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="toko">Jam Pelayanan</label>
                                                {{-- <input type="text" class="form-control" id="jamPelayananToko" placeholder="Masukan Jam pelayanan" name="jam_pelayanan" required> --}}
                                                <div class="row w-100">
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <select class="form-control" id="jamBuka" name="jamBuka" required>
                                                            <option selected>Jam Buka</option>
                                                            @foreach ($jamPelayanan as $jamBuka)
                                                                <option value="{{ $jamBuka->jam_buka }}">
                                                                    {{ $jamBuka->jam_buka }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-0 col-md-6 mb-2">
                                                        <select class="form-control" id="jamTutup" name="jamTutup"
                                                            required>
                                                            <option selected>Jam Tutup</option>
                                                            @foreach ($jamPelayanan as $jamTutup)
                                                                <option value="{{ $jamTutup->jam_tutup }}">
                                                                    {{ $jamTutup->jam_tutup }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment">Deskripsi Toko</label>
                                                <textarea class="form-control" id="deskripsiToko" rows="5" name="deskripsi_toko" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Foto Profile Toko</label>
                                                <input type="file" class="form-control-file" id="fotoProfileToko"
                                                    name="sampul_toko">
                                            </div>
                                            <div class="form-check">
                                                <label>Status Toko</label><br />
                                                <label class="form-radio-label">
                                                    <input class="form-radio-input" type="radio" name="status_toko"
                                                        value="1" id="statusToko" required>
                                                    <span class="form-radio-sign">Buka</span>
                                                </label>
                                                <label class="form-radio-label ml-3">
                                                    <input class="form-radio-input" type="radio" name="status_toko"
                                                        value="0" id="statusToko" required>
                                                    <span class="form-radio-sign">Tutup</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="toko">Lokasi Toko</label>
                                                <input type="text" class="form-control" id="location"
                                                    placeholder="Longitude, Latitude" name="location" readonly>
                                                <small id="emailHelp2" class="form-text text-danger">*Pilih melalui
                                                    maps, klik lokasi untuk mendapatkan longituted dan latitude</small>
                                                {{-- <small id="emailHelp2" class="form-text text-danger">*Pilih melalui map (klik Lokasi Toko)</small> --}}
                                            </div>
                                            <div class="m-2" id="map"></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-action">
                                    <button class="btn btn-primary" type="submit">
                                        <span class="btn-label"><i class="fas fa-save"></i></span>
                                        Simpan
                                    </button>
                                    <button class="btn btn-danger ml-1" type="reset">
                                        <span class="btn-label"><i class="fas fa-recycle"></i></span>
                                        Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backend.layouts.footer')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            // menjalankan fungsi select2 untuk properti category_id
            $(document).ready(function() {
                $('#jamBuka').select2({
                    placeholder: 'Pilih Jam Buka'
                })
                $('#jamTutup').select2({
                    placeholder: 'Pilih Jam Tutup'
                })
            })

            $('#formAction').on('submit', function(e) {
                e.preventDefault()
                const _form = this
                const formData = new FormData(_form)
                const url = this.getAttribute('action')
                $.ajax({
                    method: 'post',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({
                            icon: res.state,
                            title: res.title,
                            text: res.message,
                        });
                        resetForm();
                    }
                })
            });

            // fungsi untuk reset form setelah submit toko baru
            function resetForm() {
                $('#jamBuka').val("");
                $('#jamTutup').val("");
                $('#namaToko').val("");
                $('#lokasiToko').val("");
                $('#websiteToko').val("");
                $('#alamatDetailToko').val("");
                $('#kontakToko').val("");
                $('#jamPelayananToko').val("");
                $('#deskripsiToko').val("");
                $('#fotoProfileToko').val("");
                $('#statusToko').val("");
            }
        </script>
    </div>
@endsection


@push('javascript')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
    <script>
        // membuat variabel untuk load attribute dan url pada map
        var map = L.map('map', {
            // Menampilkan nilai lokasi dari tabel spot
            center: [-8.499137749030071, 140.4046483416395],
            zoom: 13,
            fullscreenControl: true,
        });
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // set koordinat lokasi ke dalam curLocation yang mana nilai dari curLocation juga akan
        // digunakan untuk menampilkan marker pada map
        var curLocation = [-0.4922612112757657, 117.14561375238749];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'true',
        });
        map.addLayer(marker);

        // dan ketika marker tersebut di geser akan mendapatkan titik koordinat yaitu latitude  dan longitudenya
        // lalu menambahkan titik koordinat tersebut ke dalam tag input dengan namenya location 
        marker.on('dragend', function(event) {
            var location = marker.getLatLng();
            marker.setLatLng(location, {
                draggable: 'true',
            }).bindPopup(location).update();

            $('#location').val(location.lat + "," + location.lng).keyup()
        });

        // selain itu dengan fungsi di bawah juga bisa mendapatkan nilai latitude dan longitude
        // dengan cara klik lokasi pada map maka nilai latitude dan longitudenya juga akan
        // langsung muncul pada input text location

        var loc = document.querySelector("[name=location]");
        map.on("click", function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map);
            } else {
                marker.setLatLng(e.latlng);
            }
            loc.value = lat + "," + lng;
        });
    </script>
@endpush
