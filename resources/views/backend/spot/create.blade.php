@extends('layouts.app')

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
            height: 500px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        {{-- untuk memunculkan map kita menggunakan tag div yang memiliki id map --}}
                        <div class="" id="map"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('spot.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">{{ $title }}</div>

                        <div class="card-body">
                            <div class="form-group mt-2 mb-2">
                                <label for="">Spot Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Spot Category</label>
                                <select name="category_id"
                                    class="category_id form-control @error('category_id') is-invalid @enderror"
                                    id="category_id">
                                    <option value="">Pilih Kategori</option>
                                    {{-- melakukan looping data category yang sbelumnya sudah kita panggil 
                                    dari controller spot pada method create. Dan kita juga name pada class 
                                    select yaitu category_id supaya bisa memuat fungsi select2 --}}
                                    @forelse ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @empty
                                        <option value="">Kategori tidak ditemukan</option>
                                    @endforelse
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Location</label>
                                <input type="text" name="location" id="location" readonly class="form-control">
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Cover Image</label>
                                <input type="file" name="cover"
                                    class="form-control @error('cover') is-invalid @enderror" id="">
                                @error('cover')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Image</label>
                                {{-- menambahkan opsi multiple dan menambahkan kurung siku pada properti name
                                untuk menampung beberapa data gambar --}}
                                <input type="file" name="images[]" multiple class="form-control" id="">
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id=""
                                    cols="30" rows="10"></textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group float-end mt-2 mb-2">
                                <button type="submit" class="btn btn-info">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // menjalankan fungsi select2 untuk properti category_id
        $(document).ready(function() {
            $('.category_id').select2({
                placeholder: 'Pilih Data Kategori'
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
