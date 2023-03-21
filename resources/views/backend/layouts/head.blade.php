<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('assetBackend/img/icon.ico') }}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Fonts and icons -->
    <script src="{{ url('assetBackend/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['../assetBackend/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ url('assetBackend/css/custom-style.css') }}">
    <link rel="stylesheet" href="{{ url('assetBackend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assetBackend/css/atlantis.min.css') }}">
    <link href="{{ url('assetBackend/js/plugin/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    @yield('styles')
    {{-- <link rel="stylesheet" href="{{ url('assetBackend/css/loader.css')}}"> --}}
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <!-- CSS Just for demo purpose, don't include it in your project -->
    {{-- <link rel="stylesheet" href="{{ url('assetBackend/css/demo.css')}}"> --}}

</head>
