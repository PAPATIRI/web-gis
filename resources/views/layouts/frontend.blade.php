<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'web-gis') }}</title>

    {{-- cdn css leaflet  --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    {{-- cdn js leaflet --}}
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    {{-- cdn leaflet fullscreen js dan css --}}
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
        rel='stylesheet' />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- icons -->
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
    {{-- SWEET ALERT & AOS --}}
    <link href="{{ url('assetBackend/js/plugin/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Styles -->
    @yield('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style-list-toko.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app top">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    {{-- {{ config('app.name') }} --}}
                    web-gis
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    {{-- left Side of Navbar --}}
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active-link' : '' }}"
                                href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('toko') ? 'active-link' : '' }}"
                                href="{{ route('toko') }}">{{ __('Toko Kerajinan') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            </div>
                        </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item mx-1">
                                    <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Masuk') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        {{-- footer --}}
        <div class="footer">
            2023 dibuat dengan penuh <i class="fa fa-heart heart text-danger mx-2"></i></a>
        </div>
        {{-- button to top --}}
        <div class="custom-back-to-top-wrapper">
            <a href="#top" class="custom-back-to-top-link">
                <img src="{{ asset('img/arrow-up.png') }}" class="img-fluid" alt="icon">
            </a>
        </div>
    </div>
    @stack('javascript')
    {{-- SWEET ALERT & AOS --}}
    <script src="{{ url('assetBackend/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
        const btnScrollToTop = document.querySelector('.custom-back-to-top-wrapper')
        window.addEventListener('scroll', () => {
            btnScrollToTop.style.display = window.scrollY > 40 ? 'block' : 'none'

        })
    </script>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            })
        }, 3000)
    </script>
</body>

</html>
