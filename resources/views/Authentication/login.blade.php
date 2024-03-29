<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />
<style>
    .card {
        margin: 0 auto;
        /* Added */
        float: none;
        /* Added */
        margin-bottom: 10px;
        /* Added */
    }

    body {
        /* background: url('https://source.unsplash.com/twukN12EN7c/1920x1080') no-repeat center center fixed; */
        background: url('/assetBackend/img/backgroundLogin.jpg');
        background-position: center;
        height: auto;
        width: 100%;
        object-fit: cover;
    }

    .input-box img{
        width: 30px;
        cursor: pointer;
        margin-top: 39px;
        margin-right: 10px;

    }

    .input-box2 img{
        width: 30px;
        cursor: pointer;
        margin-top: 15px;
        margin-right: 10px;

    }

    .input-box3 img{
        width: 30px;
        cursor: pointer;
        margin-top: 15px;
        margin-right: 10px;

    }
</style>

<div class="container mt-4 text-center">
    <div class="row gx-lg-5">
        <div class="card" style="width: 38rem;">
            <div class="display-3 fw-bold">
                <img src="{{ url('/assetBackend/img/loginLogo.png') }}" width="200px" class="text-center" />
            </div>
            <!-- Pills navs -->
            <ul class="nav nav-pills nav-justified m-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-login" data-mdb-toggle="pill" href="#pills-login" role="tab"
                        aria-controls="pills-login" aria-selected="true"><strong>Login</strong></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-register" data-mdb-toggle="pill" href="#pills-register" role="tab"
                        aria-controls="pills-register" aria-selected="false"><strong>Registrasi</strong></a>
                </li>
            </ul>
            <hr class="">
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content">
                <div class="tab-pane fade show active m-4" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                    {{-- <div class="text-center mb-4">
          <p><strong>FORM LOGIN</strong></p>
        </div> --}}
                    <form action="{{ route('login') }}" method="POST">
                        <!-- Email input -->
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-outline mb-4">
                                    <input type="email" id="loginName"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                    name="email" autocomplete="off" style="font-size:15pt;"
                                    required />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    <label class="form-label" for="loginName">Email atau Username</label>
                                </div>
                            </div>
                        </div>

                        <!-- Password input -->
                        <div class="row mb-4">
                            <div class="col-11">
                                <div class="form-outline mb-4 mt-4 ">
                                    <input type="password" id="loginPassword" class="form-control form-control-lg mt-4" name="password" style="font-size:15pt;" required>
                                    <label class="form-label" for="loginPassword">Password</label>
                                </div>
                            </div>
                            <div class="col-1 input-box">
                                <img src="{{ url('/assetBackend/icon/eye-slash-solid.svg') }}" id="eyeicon">
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Masuk <i
                                        class="fas fa-fw fa-sign-in-alt"></i></button>
                            </div>
                            <div class="col">
                                <button type="reset" class="btn btn-danger btn-lg btn-block mb-4">Reset <i
                                        class="fas fas-fw fa-recycle"></i></button>
                            </div>
                        </div>
                         <!-- Reset Passowrd -->
                        {{-- <div class="text-center">
                            <p> <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a></p>
                        </div> --}}
                    </form>
                </div>

                {{-- //Registrasi form --}}
                <div class="tab-pane fade m-4" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="registerName" class="form-control form-control-lg" name="name"
                                style="font-size:15pt;" required />
                            <label class="form-label" for="registerName">Nama</label>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="registerEmail" class="form-control form-control-lg" name="email" style="font-size:15pt;" required />
                            <label class="form-label" for="registerEmail">Email</label>
                        </div>
                        
                        <!-- Password input -->
                        <div class="row">
                            <div class="col-11">
                                <div class="form-outline mb-4">
                                    <input type="password" id="registerPassword" class="form-control form-control-lg" name="password" style="font-size:15pt;" required />
                                    <label class="form-label" for="registerEmail">Password</label>
                                </div>
                            </div>
                            <div class="col-1 input-box2">
                                <img src="{{ url('/assetBackend/icon/eye-slash-solid.svg') }}" id="eyeicon1">
                            </div>
                        </div>
                        
                        <!-- Repeat Password input -->
                        <div class="row">
                            <div class="col-11">
                                <div class="form-outline mb-4">
                                    <input type="password" id="registerRepeatPassword" class="form-control form-control-lg" name="password_confirmation" style="font-size:15pt;" required />
                                    <label class="form-label" for="registerRepeatPassword">Ulangi Password</label>
                                </div>
                            </div>
                            <div class="col-1 input-box3">
                                <img src="{{ url('/assetBackend/icon/eye-slash-solid.svg') }}" id="eyeicon2">
                            </div>
                        </div>
                        <!-- Submit button -->
                        <!-- Submit button -->
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-lg btn-block mb-4">Registrasi <i
                                        class="fas fa-fw fa-sign-in-alt"></i></button>
                            </div>
                            <div class="col">
                                <button type="reset" class="btn btn-danger btn-lg btn-block mb-4">Reset <i
                                        class="fas fa-fw fa-recycle"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Pills content -->
        </div>
        {{-- </div> --}}
    </div>
    {{-- </div>
  <!-- Jumbotron -->
</section> --}}
    <!-- Section: Design Block -->
    <!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
<script src="{{ url('assetBackend/js/core/jquery.min.js') }}"></script>

<script>
    let eyeicon = document.getElementById("eyeicon");
    let password = document.getElementById("loginPassword");
    let eyeicon1 = document.getElementById("eyeicon1");
    let eyeicon2 = document.getElementById("eyeicon2");
    let passwordRegister        = document.getElementById("registerPassword");
    let passwordRepeatRegister  = document.getElementById("registerRepeatPassword");

    eyeicon.onclick = function(){
        if(password.type == "password"){
            password.type = "text";
            eyeicon.src = "{{ url('/assetBackend/icon/eye-solid.svg') }}"
        }else{
            password.type = "password";
            eyeicon.src = "{{ url('/assetBackend/icon/eye-slash-solid.svg') }}"
        }
    }

    eyeicon1.onclick = function(){
        if(passwordRegister.type == "password"){
            passwordRegister.type = "text";
            eyeicon1.src = "{{ url('/assetBackend/icon/eye-solid.svg') }}"
        }else{
            passwordRegister.type = "password";
            eyeicon1.src = "{{ url('/assetBackend/icon/eye-slash-solid.svg') }}"
        }
    }

    eyeicon2.onclick = function(){
        if(passwordRepeatRegister.type == "password"){
            passwordRepeatRegister.type = "text";
            eyeicon2.src = "{{ url('/assetBackend/icon/eye-solid.svg') }}"
        }else{
            passwordRepeatRegister.type = "password";
            eyeicon2.src = "{{ url('/assetBackend/icon/eye-slash-solid.svg') }}"
        }
    }

</script>