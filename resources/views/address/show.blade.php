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
</style>
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-danger">Address Show</h1>
            <h2 class="text-secondary text-center">Address Info</h2>
            <form>
                <div class="form-group">
                    <label for="name">ID</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $address->id) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('name', $address->country) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="district">District</label>
                    <input type="text" class="form-control" id="district" name="district" value="{{ old('name', $address->district) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('name', $address->city) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" id="street" name="street" value="{{ old('name', $address->street) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('name', $address->postal_code) }}" disabled>
                </div>
                <div class="form-group">
                    <a class="btn btn-success" href="/addresses">Go Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection