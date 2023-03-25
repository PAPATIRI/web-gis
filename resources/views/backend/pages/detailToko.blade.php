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
                            <a href="{{ route('toko.listToko') }}">
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
                <div class="position-relative">
                    <div class="custom-map-wrapper">
                        <div id="map"></div>
                    </div>
                    <div class="custom-detail-toko-wrapper">
                        <img class="custom-detail-image"
                            src="{{ url('uploads/Foto Sampul Toko') }}/{{ $item->sampul_toko }}" alt="Card image cap">
                        <div>
                            <p class="custom-name-toko">{{ $item->nama_toko }}</p>
                            <div class="mb-3">
                                <h3 class="custom-rating-toko">
                                    <span>
                                        <i class="fa fa fa-star fa-lg text-warning"></i>
                                    </span>{{ $overalRating }}/5
                                </h3>
                            </div>
                            <div
                                class="{{ $item->status_toko == 0 ? 'bg-danger' : 'bg-success' }} d-flex align-items-center rounded py-2 px-4 text-center text-white">
                                @if ($item->status_toko == 0)
                                    <i class="fas fa-fw fa-door-closed mr-2"></i> Tutup
                                @else
                                    <i class="fas fa-fw fa-door-open mr-2"></i> Buka
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-2 py-5"></div>
                <div class="row px-4">
                    <div class="col-sm-12 col-lg-4 mb-3 rounded-lg bg-white p-4 shadow">
                        <small class="custom-label-data-toko">Nama Toko</small>
                        <p class="custom-value-data-toko">{{ $item->nama_toko }}</p>
                        <small class="custom-label-data-toko">Website</small>
                        <p class="custom-value-data-toko">{{ $item->website_toko }}</p>
                        <small class="custom-label-data-toko">Kontak</small>
                        <p class="custom-value-data-toko">{{ $item->kontak_toko }}</p>
                        <small class="custom-label-data-toko">Jam Pelayanan</small>
                        <p class="custom-value-data-toko">{{ $item->jam_buka }}-{{ $item->jam_tutup }}</p>
                        <small class="custom-label-data-toko">deskripsi</small>
                        <p class="custom-value-data-toko">{{ $item->deskripsi_toko }}</p>
                    </div>
                    <div class="col-sm-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Galeri Produk</h4>
                            </div>
                            <div class="card-body galeri">
                                <button type="button" class="btn btn-info" id="tambahProduk"><i
                                        class="fa fa-fw fa-plus"></i> Tambah Produk</button>
                                <div class="row m-1">
                                    <div class="table-responsive mt-2">
                                        {{-- @csrf --}}
                                        <table id="basic-datatables tabelProduk" class="table-hover tabelProduk table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Produk</th>
                                                    <th>Gambar Produk</th>
                                                    <th width="10px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @forelse ($galeriProduk as $produk)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $produk->nama_produk }}</td>
                                                        <td>
                                                            <div class="avatar">
                                                                <img src="{{ url('uploads/Galeri Produk/') }}/{{ $produk->gambar_produk }}"
                                                                    alt="..." class="avatar-img rounded"
                                                                    style="">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button type="button" data-toggle="tooltip"
                                                                    title="Detail Produk"
                                                                    class="btn btn-link btn-success action"
                                                                    data-original-title="Edit Task"
                                                                    data-id="{{ $produk->id }}" data-jenis="detail">
                                                                    <i class="fa fa-lg fa-eye"></i>
                                                                </button>
                                                                <button type="button" data-toggle="tooltip"
                                                                    title="Ubah Produk"
                                                                    class="btn btn-link btn-primary action"
                                                                    data-original-title="Edit Task"
                                                                    data-id="{{ $produk->id }}" data-jenis="Ubah">
                                                                    <i class="fa fa-lg fa-edit"></i>
                                                                </button>
                                                                <button type="button" data-toggle="tooltip"
                                                                    title="Hapus Produk"
                                                                    class="btn btn-link btn-danger action"
                                                                    data-original-title="Remove" id="btn-hapus"
                                                                    data-id="{{ $produk->id }}">
                                                                    <i class="fa fa-lg fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <div class="bg-warning text-dark rounded py-4 text-center">
                                                        <h3>data produk kosong</h3>
                                                    </div>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal tambah produk --}}
    <div id="modalAction" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Ambil dari blade action --}}
            <div class="modal-content">
                <form class="" id="formAction" action="{{ route('toko.simpanProduk') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title" id="myLargeModalLabel" style="color: black">
                            <strong>
                                Tambah Produk
                            </strong>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="{{ $item->id }}" name="fkid_toko">
                        {{-- {{ $item->id }} --}}
                        <div class="form-group">
                            <label for="email2">Nama Produk</label>
                            <input type="text" class="form-control" id="namaProduk" placeholder="Masukan Nama produk"
                                name="nama_produk" required>
                            {{-- <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                        </div>
                        <div class="form-group">
                            <label for="comment">Deskripsi</label>
                            <textarea class="form-control" id="comment" rows="5" name="deskripsi_produk" required>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto Produk</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1"
                                name="gambar_produk" required>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-close btn-sm" data-bs-dismiss="modal"
                            arial-label="Close"><i class="fas fa-fw fa-times"></i> Batal</button>
                        <button type="submit" class="btn btn-success btn-sm"><i class="far fa-fw fa-save"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Detail Produk --}}
    <div id="modalActionDetail" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            {{-- Ambil dari blade action --}}

        </div>
    </div>
    {{-- Modal Edit Produk --}}
    <div id="modalActionEdit" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Ambil dari blade action --}}

        </div>
    </div>
    @include('backend.layouts.footer')
    </div>
@endsection
@push('javascript')
    <script>
        $('.btn-close').on('click', function() {
            $('#modalAction').modal('hide');
        })
        $('#tambahProduk').on('click', function() {
            $('#modalAction').modal('show');
            store();
        })

        $('.btn-ubah').on('click', function() {
            $('#modalAction').modal('show');
        })

        // Proses CRUD
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('.tabelProduk').on('click', '.action', function() {
            let data = $(this).data()
            let id = data.id
            let jenis = data.jenis

            if (jenis == 'detail') {
                // alert('Detail'+id)
                $('#modalActionDetail').modal('show');
                $.ajax({
                    method: 'get',
                    url: `{{ url('detail-produk') }}/${id}`,
                    success: function(res) {
                        $('#modalActionDetail').find('.modal-dialog').html(res)
                        $('#modalActionDetail').modal('show');

                    }
                })
            } else if (jenis == 'Ubah') {
                $.ajax({
                    method: 'get',
                    url: `{{ url('edit-produk') }}/${id}`,
                    success: function(res) {
                        $('#modalActionEdit').find('.modal-dialog').html(res)
                        $('#modalActionEdit').modal('show');
                        // store();

                    }
                })
            } else {
                Swal.fire({
                    title: "Anda Yakin ?",
                    text: "Produk akan dihapus",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Batal",
                    confirmButtonText: "Hapus"
                }).then(result => {
                    if (result.value) {
                        $.ajax({
                            method: 'DELETE',
                            url: `{{ url('hapus-foto-produk') }}/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: res.state,
                                    title: res.title,
                                    text: res.message,
                                }).then(function() {
                                    location.reload();
                                })
                            }
                        })
                    }
                });
                return
            }

        })

        // Proses simpan galeri baru
        function store() {
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
                        $('#modalAction').modal('hide');
                        Swal.fire({
                            icon: res.state,
                            title: res.title,
                            text: res.message,
                        }).then(function() {
                            location.reload();
                        })
                    }
                })
            });
        }
    </script>
    </div>
    <script>
        var data{{ $item->id }} = L.layerGroup()
        var map = L.map('map', {
            // Menampilkan nilai lokasi dari tabel spot
            center: [{{ $item->lokasi_toko }}],
            zoom: 17,
            fullscreenControl: true,
            layers: data{{ $item->id }}
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Begitu Juga pada curLocation kita Menampilkan nilai lokasi dari tabel spot
        var curLocation = [{{ $item->lokasi_toko }}];
        // map.attributionControl.setPrefix(false);


        var marker = new L.marker(curLocation);
        marker.bindPopup("<p style='font-size:18px'><b>hay pak bos!!</b><br>lokasi toko kamu di sini 😊. </p>").openPopup();
        var popup = L.popup()
            .setLatLng([{{ $item->lokasi_toko }}])
            .setContent("<p style='font-size:18px'><b>halo pak bos!!</b><br>lokasi toko kamu di sini 😊. </p>")
            .openOn(map);
        map.addLayer(marker);
    </script>
@endpush
