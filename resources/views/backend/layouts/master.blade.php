@include('backend.layouts.head')

<body>
    <div class="wrapper">
        @include('backend.layouts.header')
        @include('backend.layouts.sidebar')

        <section class="content">
            @yield('container')
        </section>
    </div>
    @stack('javascript')
</body>
{{-- @include('backend.layouts.footer') --}}
