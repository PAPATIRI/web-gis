@extends('backend.layouts.master')
@section('styles')
    {{-- pada section styles kita menambahkan style css untuk menampilkan plugin leaflet dan select2 untuk select option kategori spot --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <style>
        #map {
            height: 100px
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
                        <a href="#">{{ $title  }}</a>
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
                            <div class="row">
                                <div class="col-4">
                                    <input type="hidden" value="{{Auth::user()->id }}" name="fkid_user">
                                    <div class="form-group">
                                        <label for="toko">Nama Toko</label>
                                        <input type="text" class="form-control" id="namaToko" placeholder="Masukan Nama Toko" name="nama_toko" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="toko">Lokasi Toko</label>
                                        <input type="text" class="form-control" id="lokasiToko" placeholder="" readonly name="lokasi_toko">
                                        <small id="emailHelp2" class="form-text text-danger">*Pilih melalui map (klik Lokasi Toko)</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="toko">Website</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Masukan website" aria-label="Recipient's username" aria-describedby="basic-addon2" name="website_toko">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">@example.com</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="toko">Kontak Person</label>
                                        <input type="number" class="form-control" id="kontakToko" placeholder="Masukan Kontak person" name="kontak_toko" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="toko">Jam Pelayanan</label>
                                        {{-- <input type="text" class="form-control" id="jamPelayananToko" placeholder="Masukan Jam pelayanan" name="jam_pelayanan" required> --}}
                                        <div class="row">
                                            <div class="col-5">
                                                <select class="form-control" id="jamBuka" name="jamBuka" required>
                                                    <option selected>Jam Buka</option>
                                                    @foreach ($jamPelayanan as $jamBuka)
                                                        <option value="{{$jamBuka->jam_buka}}">{{ $jamBuka->jam_buka }}</option>  
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-2">
                                                    <h5 class="mt-2 text-center"> <hr> </h5>
                                            </div>
                                            <div class="col-5">
                                                <select class="form-control" id="jamTutup" name="jamTutup" required>
                                                    <option selected>Jam Tutup</option>
                                                    @foreach ($jamPelayanan as $jamTutup)
                                                        <option value="{{$jamTutup->jam_tutup}}">{{ $jamTutup->jam_tutup }}</option>  
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
                                        <input type="file" class="form-control-file" id="fotoProfileToko" name="sampul_toko">
                                    </div>
                                    <div class="form-check">
                                        <label>Status Toko</label><br/>
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="status_toko" value="1" id="statusToko" required>
                                            <span class="form-radio-sign">Buka</span>
                                        </label>
                                        <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="status_toko" value="0" id="statusToko" required>
                                            <span class="form-radio-sign">Tutup</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="" id="map"></div>
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
    <script>
         $('#formAction').on('submit', function(e){
                e.preventDefault()
                const _form = this
                const formData = new FormData(_form)
                const url = this.getAttribute('action')
                    $.ajax({
                        method  : 'post',
                        url     : url,
                        headers : {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data    : formData,
                        processData : false,
                        contentType : false,
                        success : function(res){

                            var content = {};
                            var from ='top';
                            var align = 'right';
                            var state = res.state;
                            content.message = res.message;
                            content.title = res.title;
                            content.icon = 'fas fa-check';
                                $.notify(content,{
                                        type: state,
                                        placement: {
                                            from: from,
                                            align: align
                                        },
                                        time: 1,
                                        delay: 1,
                                });
                            resetForm();
                        }
                    })
            });

            // fungsi untuk reset form setelah submit toko baru
            function resetForm(){
                $('#jamBuka').val("");
                $('#jamTutup').val("");
                $('#namaToko').val("");
                $('#lokasiToko').val("");
                $('#websiteToko').val("");
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

        // membuat variabel untuk load attribute dan url pada map
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        // membuat var satellite, dark, dan streets agar layer map kita punya beberapa opsi tampilan yang bisa kita ubah 
        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v11',
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

        // mendefinisikan var map. Menambahkan opsi seperti center untuk menentukan latitude dan longitude,
        // mengantur zoom map saat di load dan memuat layer yang di inginkan.
        // Untuk nilai dari latitude longitude bisa disesuaikan dengan lokasi yang di inginkan 
        // nilai latitude dan longitude bisa di ambil dari google map
        var map = L.map('map', {
            // center: [-0.4922612112757657, 117.14561375238749],
            center: [-3.196071254860089, 135.50952252328696],
            zoom: 7,
            layers: [streets]
        });

        // set baselayer yang ingin digunakan
        var baseLayers = {
            //"Grayscale": grayscale,
            "Streets": streets
        };

        // set overlayer yang ingin digunakan
        var overlays = {
            "Streets": streets
        };

        // menambahkan baselayer dan overlays tadi ke dalam control dan di tampilkan ke tag map
        L.control.layers(baseLayers, overlays).addTo(map);


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
