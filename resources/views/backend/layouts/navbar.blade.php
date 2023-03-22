<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        @if (Auth::user()->foto_profile === null)
                            <img src="{{ url('img/Avatar.png') }}" alt="..." class="avatar-img rounded-circle">
                        @else
                            <img src="{{ url('uploads/Foto Profile User') }}/{{ Auth::user()->foto_profile }}"
                                alt="..." class="avatar-img rounded-circle">
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    @if (Auth::user()->foto_profile === null)
                                        <img src="{{ url('img/Avatar.png') }}" alt="..."
                                            class="avatar-img rounded-circle">
                                    @else
                                        <img src="{{ url('uploads/Foto Profile User') }}/{{ Auth::user()->foto_profile }}"
                                            alt="..." class="avatar-img rounded-circle">
                                    @endif
                                </div>
                                <div class="u-text">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                    {{-- <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a> --}}
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- End Navbar -->
