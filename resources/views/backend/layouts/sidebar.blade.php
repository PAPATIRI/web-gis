	<!-- Sidebar -->
    <div class="sidebar sidebar-style-2">			
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">
                        <img src="{{ url('assetBackend/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                            <span>
                                {{ Auth::user()->name }}
                                <span class="user-level">Pemilik Toko</span>
                            </span>
                            <span class="caret"></span>
                        </a>
                        <div class="clearfix"></div>

                        <div class="collapse in" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="#profile">
                                        <span class="link-collapse">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#edit">
                                        <span class="link-collapse">Edit Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#settings">
                                        <span class="link-collapse">Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-primary">
                    @if(Request::url() == route('dashboard'))
                        <li class="nav-item active">
                    @else
                        <li class="nav-item">
                    @endif
							<a href="{{ route('dashboard') }}">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
                

                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Fitur</h4>
                    </li>

                    @if(Request::url() === route('toko.listToko')  || Request::url() === route('toko.tambahToko'))
                        <li class="nav-item active submenu">
                    @else
                        <li class="nav-item">
                    @endif
                        <a data-toggle="collapse" href="#base">
                            <i class="fas fa-store-alt"></i>
                            <p>Kelolah Toko</p>
                            <span class="caret"></span>
                        </a>
                        @if(Request::url() === route('toko.listToko') || Request::url() === route('toko.tambahToko') )
                        <div class="collapse show" id="base">
                            @else
                        <div class="collapse" id="base">
                        @endif
                            <ul class="nav nav-collapse">
                                <li class="active">
                                    <a href="{{ route('toko.listToko') }}">
                                        <span class="sub-item">Toko Saya</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                   
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->
