@extends('layouts.app')

@section('content')
<style>
    .card {
        margin-top: 100px;
        width: 350px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 20px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
    }

    .form-control:focus {
        outline-color: #ffffff;
        border-color: #ffffff;
        box-shadow: 0 0 10px #198754;
    }

    body {
        margin: 0;
        padding: 0;
        background: url('/defImages/bg1.jpg') no-repeat center fixed;
        background-size: cover;
    }

    .link,
    .btn-link {
        color: #198754 !important;
        text-decoration: none;
        font-weight: bold;
    }

    .register-card {
        margin-top: 25px;
        height: 75px;
    }

    .register-text {
        margin-bottom: -10px;
        /* Adjust the margin as needed */
    }

    .close-btn {
        position: absolute;
        font-size: 2.5rem; /* Adjust the font size as needed */
        cursor: pointer;
        color: #000000; /* Set the color to black */
        display: flex;
        justify-content: center;
        align-items: center;
        top: 10px;
        left: 10px; 
    }

    .btn-success {
        margin-top: 0px;
        margin-bottom: -10px;
    }
    
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backgrounds = [
            '/defImages/bg1.jpg',
            '/defImages/bg2.jpg',
            '/defImages/bg5.jpeg',
        ];
        let currentBackground = 0;

        function changeBackground() {
            document.body.style.backgroundImage = `url('${backgrounds[currentBackground]}')`;
            currentBackground = (currentBackground + 1) % backgrounds.length;
        }

        setInterval(changeBackground, 10000); // Change background every 60 seconds
    });
</script>

<div class="container">
    <a href="{{ route('homepage') }}" class="close-btn" aria-label="Close">
        <!-- Adjust the close button as needed -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </a>
    <div class="row justify-content-center">
        <div class="col-md-6 mx-auto">
            <div class="card ">
                <div class="card-body text-center">
                    <h2 class="text-secondary title mb-4">Login</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-0 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot my password') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="card register-card">
                <div class="card-body text-center">
                    <p class="register-text">Don't have an account?</p>
                    <a class="btn btn-link" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection