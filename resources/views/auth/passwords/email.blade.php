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
</style>

<div class="container mt-4 text-center">
    <div class="row gx-lg-5">
        <div class="card" style="width: 38rem;">
            <div class="display-3 fw-bold">
                <img src="{{ url('/assetBackend/img/loginLogo.png') }}" width="200px" class="text-center" />
            </div>
            <hr class="">
                <div class="tab-content">
                    <div class="tab-pane fade show active m-4" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                    {{-- <div class="text-center mb-4">
          <p><strong>FORM LOGIN</strong></p>
        </div> --}}
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- <div class="row mb-3">
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    </div>
                </div> --}}
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                        <div class="form-outline mb-4">
                            <input  id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="font-size:15pt;"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <label class="form-label" for="loginName">Email</label>
                        </div>
              
                {{-- <div class="row mb-0"> --}}
                    {{-- <div class="col-md-6 offset-md-4"> --}}
                        <button type="submit" class="btn btn-primary">
                            {{ __('Kirim Link Reset Password') }}
                        </button>
                    {{-- </div> --}}
                {{-- </div> --}}
            </form>
        </div>
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

    eyeicon.onclick = function(){
        if(password.type == "password"){
            password.type = "text";
            eyeicon.src = "{{ url('/assetBackend/icon/eye-solid.svg') }}"
        }else{
            password.type = "password";
            eyeicon.src = "{{ url('/assetBackend/icon/eye-slash-solid.svg') }}"
        }
    }

</script>