<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- AOS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <div id="app top">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" data-aos="fade-down">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
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
                            <a class="nav-link {{ request()->is('list-toko') ? 'active-link' : '' }}"
                                href="{{ route('list-toko') }}">{{ __('Toko Kerajinan') }}</a>
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

                            @if (Route::has('register'))
                                <li class="nav-item mx-1">
                                    <a class="btn btn-outline-light text-primary"
                                        href="{{ route('register') }}">{{ __('Daftar') }}</a>
                                </li>
                            @endif
                        @else
                            <div class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">Dashboard Admin</a>
                            </div>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
            <span>copyright @ 2023</span>
        </div>
        {{-- button to top --}}
        <div class="custom-back-to-top-wrapper">
            <a href="#top" class="custom-back-to-top-link">
                <img src="{{ asset('img/arrow-up.png') }}" class="img-fluid" alt="icon">
            </a>
        </div>
    </div>
    @stack('javascript')
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
