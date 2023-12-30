@extends('layouts.app')
@section('content')

<style>
    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        margin-top: 50px;
        margin-bottom: 30px;
        max-width: 700px;
        /* Adjust the max-width as needed */
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection