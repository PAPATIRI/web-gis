@extends('backend.layouts.master')
@section('container')
    <div class="main-panel">
        <div class="content">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div>
                            <h2 class="fw-bold pb-2 text-white">Dashboard</h2>
                        </div>
                        {{-- <div class="ml-md-auto py-2 py-md-0">
                        <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                        <a href="#" class="btn btn-secondary btn-round">Add Customer</a>
                    </div> --}}
                    </div>
                </div>
            </div>
            <div class="page-inner mt--5">
                <div class="row mt-2">
                    <div class="col">
                        <div class="card full-height">
                            <div class="card-body mb-4">
                                <div class="card-title">Overall statistics</div>
                                <div class="card-category">Statistik informasi secara keseluruhan toko saya.</div>
                                <div class="d-flex justify-content-around flex-wrap pb-2 pt-4">
                                    <div class="pb-md-0 px-2 pb-2 text-center">
                                        <div id="circles-1"></div>
                                        <h6 class="fw-bold mt-3 mb-0">Toko Saya</h6>
                                    </div>
                                    <div class="pb-md-0 px-2 pb-2 text-center">
                                        <div id="circles-2"></div>
                                        <h6 class="fw-bold mt-3 mb-0">Pengunjung Toko</h6>
                                    </div>
                                    <div class="pb-md-0 px-2 pb-2 text-center">
                                        <div id="circles-3"></div>
                                        <h6 class="fw-bold mt-3 mb-0">Rating Toko</h6>
                                    </div>
                                    <div class="page-inner mt--5">
                                        <div class="row mt-2">
                                            <div class="col">
                                                <div class="card full-height">
                                                    <div class="card-body mb-4">
                                                        <div class="card-title">Overall statistics</div>
                                                        <div class="card-category">Statistik informasi secara keseluruhan
                                                            toko saya.</div>
                                                        <div class="row mt-4">
                                                            <div class="col-sm-6 col-md-4">
                                                                <div class="card card-stats card-primary card-round">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <div class="icon-big text-center">
                                                                                    <i class="flaticon-store"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-7 col-stats">
                                                                                <div class="numbers">
                                                                                    <p class="card-category">Toko Saya</p>
                                                                                    <h4 class="card-title">
                                                                                        {{ $totalToko }}</h4>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-4">
                                                                <div class="card card-stats card-info card-round">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <div class="icon-big text-center">
                                                                                    <i class="flaticon-star-1"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-7 col-stats">
                                                                                <div class="numbers">
                                                                                    <p class="card-category">Rating Toko</p>
                                                                                    <h4 class="card-title">
                                                                                        {{ $overalRating }}</h4>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-4">
                                                                <div class="card card-stats card-success card-round">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <div class="icon-big text-center">
                                                                                    <i class="flaticon-box-2"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-7 col-stats">
                                                                                <div class="numbers">
                                                                                    <p class="card-category">Produk</p>
                                                                                    <h4 class="card-title">
                                                                                        {{ $overalProduk }}</h4>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.layouts.footer')
    <script>
        Circles.create({
            id: 'circles-1',
            radius: 45,
            value: 60,
            maxValue: 100,
            width: 7,
            text: 5,
            colors: ['#f1f1f1', '#F25961'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })

        Circles.create({
            id: 'circles-2',
            radius: 45,
            value: 70,
            maxValue: 100,
            width: 7,
            text: 36,
            colors: ['#f1f1f1', '#2BB930'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })

        Circles.create({
            id: 'circles-3',
            radius: 45,
            value: 40,
            maxValue: 100,
            width: 7,
            text: 12,
            colors: ['#f1f1f1', '#FF9E27'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })
    </script>
@endsection
