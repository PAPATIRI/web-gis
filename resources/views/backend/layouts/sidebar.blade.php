	<!-- Sidebar -->
    <div class="sidebar sidebar-style-2">			
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">
                        <img src="{{ url('uploads/Foto Profile User')}}/{{Auth::user()->foto_profile }}" alt="..." class="avatar-img rounded-circle">
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
                                    <a href="#" id="profile">
                                        <span class="link-collapse">Profile Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" id="edit">
                                        <span class="link-collapse">Edit Profile</span>
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

     {{-- Modal Detail Profile --}}
     <div id="modalActionProfile" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Ambil dari blade action --}}
            <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myLargeModalLabel" style="color: black">
                            <strong>
                             Profile Saya
                           </strong>
                        </h3>
                    </div>
                    <div class="modal-body"> 
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="email2">Nama Akun</label>
                                {{-- <input type="email" class="form-control" id="email2" placeholder="Enter Email"> --}}
                                <h2><strong>{{ Auth::user()->name }}</strong></h2>
                            </div>
                            <div class="form-group mt-2">
                                <label for="email2">Email</label>
                                {{-- <input type="email" class="form-control" id="email2" placeholder="Enter Email"> --}}
                                <h2><strong>{{ Auth::user()->email }}</strong></h2>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="avatar-xxl mt-2">
                                <img src="{{ url('uploads/Foto Profile User')}}/{{Auth::user()->foto_profile }}" alt="image profile" class="avatar-img rounded">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-close btn-sm" data-bs-dismiss="modal" arial-label="Close"><i class="fas fa-fw fa-times"></i> Tutup</button>
                    </div>
            </div>
        </div>
    </div>


     {{-- Modal Ubah Profile --}}
     <div id="modalActionEditProfile" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Ambil dari blade action --}}
            <div class="modal-content">
                <form class="" id="formActionoioi" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title" id="myLargeModalLabel" style="color: black">
                            <strong>
                             Edit Profile Saya
                           </strong>
                        </h3>
                    </div>
                    <div class="modal-body"> 
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email2">Nama Akun</label>
                                <input type="email" class="form-control" id="email2" placeholder="" value="{{ Auth::user()->name }}" name="nama">
                                {{-- <h2><strong>{{ Auth::user()->name }}</strong></h2> --}}
                            </div>
                            <div class="form-group mt-2">
                                <label for="email2">Email</label>
                                <input type="email" class="form-control" id="email2" placeholder="" value="{{ Auth::user()->email }}" name="email">
                                {{-- <h2><strong>{{ Auth::user()->email }}</strong></h2> --}}
                            </div>

                            <div class="form-group mt-2">
                                <div class="row">
                                    <div class="col">
                                        <label for="email2">Foto Profile</label>
                                        <input type="file" class="form-control" id="email2" placeholder="" name="foto_profile">
                                    </div>
                                    <div class="col">
                                        <div class="avatar-xxl">
                                            <img src="{{ url('uploads/Foto Profile User')}}/{{Auth::user()->foto_profile }}" alt="image profile" class="avatar-img rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-close btn-sm" data-bs-dismiss="modal" arial-label="Close"><i class="fas fa-fw fa-times"></i> Tutup</button>
                        <button type="submit" class="btn btn-success btn-close btn-sm" data-bs-dismiss="modal" arial-label="Close"><i class="fas fa-fw fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ url('assetBackend/js/core/jquery.min.js')}}"></script>
    <script>
           $('#profile').on('click' ,function(){
                $('#modalActionProfile').modal('show');
            })

           $('#edit').on('click' ,function(){
                $('#modalActionEditProfile').modal('show');
            })
            
            $('.btn-close').on('click' ,function(){
                $('#modalActionProfile').modal('hide');
                $('#modalActionEditProfile').modal('hide');
            })
    </script>