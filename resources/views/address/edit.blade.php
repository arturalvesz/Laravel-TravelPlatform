@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-danger">Address Edit</h1>
            <h2 class="text-secondary text-center">Address Info</h2>
            <form method="post" action="{{ route('address.update', compact('address')) }}">
                @csrf
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $address->country) }}">

                </div>
                <div class="form-group">
                    <label for="district">District</label>
                    <input type="text" class="form-control" id="district" name="district" value="{{ old('district', $address->district) }}">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $address->city) }}">
                </div>
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" id="street" name="street" value="{{ old('street', $address->street) }}">
                </div>
                <div class="form-group">
                    <label for="postal_code">Street</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}">
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection