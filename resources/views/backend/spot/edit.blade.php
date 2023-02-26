@extends('layouts.app')

@section('styles')
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
    {{-- Hampir sama dengan form create kita memanggil cdn untuk select2 dan leaflet kemudian kita akan 
    menulis kode untuk memunculkan peta pada bagian push('javascript') di bawah --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="" id="map"></div><br />
                        <div class="row">
                            {{-- Untuk kode ini kita akan memanggil method getImages dari model spot
                            yang mana method tersebut berelasi ke tabel ImageSpot jika pada spot yang
                            kita pilih memiliki gambar selain gambar utamanya/cover maka gambar tersebut
                            akan dimunculkan. --}}
                            @foreach ($spot->getImages as $item)
                                <div class="col-md-4 mt-2 mb-2">
                                    Gambar Lainnya :
                                    <img src="{{ $item->ListImages() }}" width="100px" alt="">

                                    {{-- form disini digunakan untuk menghapus gambar, jadi jika ada gambar yang ingin dihapus
                                    form ini akan mengarahkan ke route tersebut yang methodnya sudah kita buat juga pada SpotController --}}
                                    <form action="{{ route('delete-image', $item->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm mt-2"
                                            onclick="return confirm('delete Item ?');">Delete</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">

                    {{-- route yang mengarah ke method update pada controller SpotController
                    $spot kita ambil dari method edit pada controller SpotController --}}

                    <form action="{{ route('spot.update', $spot->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="form-group mt-2 mb-2">
                                <label for="">Spot Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ $spot->name }}">
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
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Location</label>
                                <input type="text" name="location" value="{{ $spot->location }}" id="location" readonly
                                    class="form-control">
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Cover Image</label>
                                <input type="file" name="cover"
                                    class="form-control @error('cover') is-invalid @enderror">
                                <div class="mt-2">Gambar Utama</div>
                                <img src="{{ $spot->getImage() }}" class="mt-2 mb-2" width="100px" alt="">
                                @error('cover')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Image</label>
                                <input type="file" name="images[]" multiple class="form-control" id="">
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id=""
                                    cols="30" rows="10">{{ $spot->description }}</textarea>
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
        // kode dibawah berfungsi ketika page edit di load select2 akan menampilkan nilai
        // dari tabel kategori yang berelasi ke tabel spot. Method 'getCategory' sudah kita definisikan
        // di model spot
        $(".category_id").select2()
            .val({!! json_encode($spot->getCategory()->allRelatedIds()) !!}).trigger('change');

        $(document).ready(function() {
            $('.category_id').select2({
                placeholder: 'Pilih Data Kategori'
            })
        })

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
            layers: [streets]
        });

        var baseLayers = {
            //"Grayscale": grayscale,
            "Streets": streets
        };

        var overlays = {
            "Streets": streets
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        // bagian yang berbeda dari form create dan edit ada pada bagian ini
        // jika di form create titik koordinatnya kita atur secara manual 
        // pada form edit ini titik koordinat kita ambil dari field location pada tabel spot 
        var curLocation = [{{ $spot->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'true',
        });
        map.addLayer(marker);

        marker.on('dragend', function(event) {
            var location = marker.getLatLng();
            marker.setLatLng(location, {
                draggable: 'true',
            }).bindPopup(location).update();

            $('#location').val(location.lat + "," + location.lng).keyup()
        });

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
