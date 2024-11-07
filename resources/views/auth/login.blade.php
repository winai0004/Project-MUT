@extends('layouts_frontend.app')
@section('content')

<style>
    .btn-color{
        background-color: #0e1c36;
        color: #fff;
    }

    .profile-image-pic{
        height: 200px;
        width: 200px;
        object-fit: cover;
    }

    .cardbody-color{
        background-color: #ebf2fa;
    }

    a{
        text-decoration: none;
    }
</style>
<main class="login-form vh-100">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">Login Form</h2>
                <div class="text-center mb-5 text-dark">Shop</div>
                <div class="card my-5">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="admin-tab" data-bs-toggle="tab" href="#admin" role="tab" aria-controls="vertical-admin"> Admin </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="member-tab" data-bs-toggle="tab" href="#member" role="tab" aria-controls="vertical-member"> Member </a>
                        </li>     
                    </ul>
                    <div class="tab-content" id="tab-content" aria-orientation="vertical">
                        <div class="tab-pane active" id="admin" role="tabpanel" aria-labelledby="vertical-admin">
                            <form class="card-body cardbody-color p-lg-5" method="POST" action="{{ route('login.custom',1) }}">
                                @csrf
                                <div class="text-center">
                                    <img src="{{ asset('storage/adminshop.png') }}" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                                         width="200px" alt="profile">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Signin</button>
                                </div>
                                {{-- <div id="emailHelp" class="form-text text-center mb-5  mt-3 text-dark">Not
                                    Registered? <a  href="{{ route('register') }}" class="text-dark fw-bold"> Create an Account</a>
                                </div> --}}
                            </form>
                        </div>  

                        <div class="tab-pane" id="member" role="tabpanel" aria-labelledby="vertical-member">
                            <form class="card-body cardbody-color p-lg-5" method="POST" action="{{ route('login.custom',2) }}">
                                @csrf
                                <div class="text-center">
                                    <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                                        width="200px" alt="profile">
                                </div> 
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Signin</button>
                                </div>
                                <div id="emailHelp" class="form-text text-center mb-5  mt-3 text-dark">Not
                                    Registered? <a  href="{{ route('register') }}" class="text-dark fw-bold"> Create an Account</a>
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    // เช็คว่ามีค่าจาก session หรือไม่
    @if(session('clearSessionStorage'))
        // เคลียร์ sessionStorage หลังจาก logout
        sessionStorage.clear(); 
    @endif
</script>
@endsection