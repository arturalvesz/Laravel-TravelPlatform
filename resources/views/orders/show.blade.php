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
        margin-top: 20px;
        width: 400px;
        /* Full width within the container */
        height: 275px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.1);
        /* Grey border */
        border-radius: 24px;
        position: relative;
    }

    .total-price {
        margin-top: 20px;
        font-weight: bold;
        font-size: 20px;
        text-align: center;
    }
</style>

<div class="container mt-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-6">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

            <h2 class="text-secondary text-center">Order Info</h2>
            @foreach($order->orderExperiences as $order_experience)
            @php
            $experience = $experiences->where('id', $order_experience->experience_id)->first();
            @endphp

            <div class="card mb-3 mx-auto">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Experience</label>
                        <input type="text" class="form-control text-left" id="name" name="name" value="{{ old('name', $experience->name) }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="num_tickets">Number of tickets</label>
                        <input type="text" class="form-control text-left" id="num_tickets" name="num_tickets" value="{{ old('num_tickets', $order_experience->num_tickets)}}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control text-left" id="price" name="price" value="{{ old('price', $order_experience->price)}}" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <a class="btn btn-outline-success d-inline-block align-middle" href="{{ route('review.create', ['order_experience'=>$order_experience, 'experience'=>$experience]) }}">Create a Review</a>
            </div>

            @endforeach

            <p class="total-price">Total Price: {{ $order->totalPrice }}€</p>
            <div class="form-group text-center">
                @if(auth()->user()->usertype === 'admin')
                <a class="btn btn-success" href="/ordersIndex">Back</a>
                @else
                <a class="btn btn-success" href="/orders">Back</a>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection