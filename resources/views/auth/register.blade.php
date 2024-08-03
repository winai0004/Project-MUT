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
                <h2 class="text-center text-dark mt-5">Register Form</h2>
                <div class="text-center mb-5 text-dark">Shop</div>
                    <div class="card my-5">
                            <form class="card-body cardbody-color p-lg-5" method="POST" action="{{ route('register.custom') }}">
                                @csrf     
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Name" id="name" class="form-control" name="name"
                                        required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control"
                                        name="email" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control"
                                        name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                           
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Sign up</button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection