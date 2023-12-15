@extends('layouts.app')

@section('content')

<style>
    body {
        margin: 0;
        padding: 0;
        overflow-y: scroll;
        scrollbar-width: thin;
        scrollbar-color: transparent transparent;
        -ms-overflow-style: none;
    }

    body::-webkit-scrollbar {
        width: 0px;
    }

    body::-webkit-scrollbar-thumb {
        background-color: transparent;
    }

    body::-webkit-scrollbar-track {
        background-color: transparent;
    }

    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 24px;
        margin-bottom: -20px;
        margin-top: 50px;
        max-width: 700px; /* Adjust the max-width as needed */
        margin-left: auto;
        margin-right: auto;
    }
    .card2 {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 24px;
        margin-bottom: 20px;
        margin-top: 50px;
        max-width: 700px; /* Adjust the max-width as needed */
        margin-left: auto;
        margin-right: auto;
    }

    .card-body {
        padding: 20px;
    }
    .card-body2 {
        padding: 20px;
    }

    .rounded-image {
        border-radius: 50%;
        margin-right: 20px;
        margin-bottom: 20px;
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .btn-submit {
        margin-top: 20px;
    }

    .title {
        margin-bottom: 20px;
        margin-top: -20px;
    }

    .title1 {
        margin-bottom: 20px;
        margin-top: -5px;
    }

    .content {
        margin-top: 20px;
    }

    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        animation: fadeInUp 0.5s ease-out;
        background-color: #ffffff;
        color: #198754;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fadeOut {
        opacity: 1;
        transition: opacity 1s ease-out;
    }

    .custom-alert {
        background-color: #ffffff;
        color: #198754;
    }

    .form-control:focus {
        outline-color: #ffffff;
        border-color: #ffffff;
        box-shadow: 0 0 10px #198754;
    }
</style>


<div class="container">

    @if (session('success'))
    <div class="alert alert-success custom-alert fadeOut" role="alert" id="fade-out-alert">
        {{ session('success') }}
    </div>
    <script>
        // Automatically hide the alert after 3 seconds
        setTimeout(function() {
            var fadeOutAlert = document.getElementById('fade-out-alert');
            fadeOutAlert.style.opacity = 0;
        }, 2000);
    </script>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Photo Form Card -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-secondary title1">Change Profile Photo</h2>
                    @if ($photo)
                    <img src="{{ asset('storage/images/' . $photo->path) }}" alt="Profile Photo" class="rounded-image img img-fluid" width="150" height="150">
                    @php
                    $photoroute = "profile.updatePhoto";
                    @endphp
                    @else
                    <img src="{{ asset('path/to/default/photo.jpg') }}" alt="Default Photo" class="rounded-image mb-4" width="150">
                    @php
                    $photoroute = 'profile.storePhoto';
                    @endphp
                    @endif

                    <form action="{{ route($photoroute) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}" />
                        <div class="form-group">
                            <input type="file" name="image" id="image" required class="form-control">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                    </form>
                </div>
            </div>

            <!-- User Information Card -->
            <div class="card">
                <div class="card-body content">
                    <h2 class="text-secondary title">Edit User Information</h2>
                    <form method="POST" action="{{ route('profile.updateUser') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input id="current_password" type="password" class="form-control" name="current_password" required autocomplete="current-password">
                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="new-password">
                            @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password">
                            @error('new_password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-success">Update</button>
                    </form>
                </div>
            </div>
            
            <!-- Address Form Card -->
            <div class="card2">
                <div class="card-body2 content">
                    <h2 class="text-secondary title">Edit Address Information</h2>

                    @if (empty($address))
                    @php
                    $addressroute = "profile.storeAddress";
                    @endphp
                    @else
                    @php
                    $addressroute = "profile.updateAddress";
                    @endphp
                    @endif

                    <form method="post" action="{{ route($addressroute) }}">
                        @csrf
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country', optional($address)->country) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="district">District</label>
                            <input type="text" class="form-control" id="district" name="district" value="{{ old('district', optional($address)->district) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', optional($address)->city) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ old('street', optional($address)->street) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', optional($address)->postal_code) }}" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection