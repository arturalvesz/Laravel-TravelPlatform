<!-- cart.blade.php -->

@extends('layouts.app') {{-- Assuming you have a layout named app.blade.php --}}

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

    #cart-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-top: 50px;
    }

    .cart-container {
        margin-top: 20px;
    }

    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        margin-top: 20px;
        margin-bottom: 30px;
        width: 500px;
        /* Adjust the max-width as needed */
        margin-left: auto;
        margin-right: auto;
    }

    .card-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: left;
    }

    .total-price {
        margin-top: 20px;
        font-weight: bold;
        font-size: 20px;
        text-align: right;
    }

    #btn1 {
        font-size: 12px;
        border-radius: 24px;
    }

    .card-title {
        font-weight: bold;
    }

    .plain-link {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Use the default text color */
        cursor: pointer;
        /* Show pointer cursor on hover to indicate clickability */
    }
</style>

<div id="cart-page">
    <h1>Your Experiences Cart</h1>

    <div class="cart-container">
        @php
        $cartTotalPrice = 0; // Initialize total price variable
        @endphp

        @if (count($cart) > 0)
        @foreach ($cart as $item)
        <div class="card">
            <div class="card-body">
                <div>
                    @php
                    $experience = \App\Models\Experience::find($item['experience_id']);
                    $experienceName = $experience ? $experience->name : 'Experience Not Found';
                    @endphp
                    <h5 class="card-title">
                        <a href="{{ route('experience.show', ['experience' => $item['experience_id']]) }}" class="plain-link">
                            {{ $experienceName }}
                        </a>
                    </h5>
                    <p class="card-text">
                        Number of Entries: {{ $item['num_tickets'] }}<br>
                        Date: {{ $item['selected_date'] }}<br>
                        Entry time: {{ $item['selected_timeframe'] }}
                    </p>
                </div>
                <div>
                    <p style="color: #000; font-weight: bold;">Price: {{ $item['price'] }}€</p>
                    {{-- Add the "Eliminate" button --}}
                    <form action="{{ route('cart.remove') }}" method="post">
                        @csrf
                        <input type="hidden" name="experience_id" value="{{ $item['experience_id'] }}">
                        <input type="hidden" name="selected_timeframe" value="{{ $item['selected_timeframe'] }}">
                        <button type="submit" class="btn btn-outline-success" id="btn1">Eliminate</button>
                    </form>
                </div>
            </div>
        </div>

        @php
        $cartTotalPrice += $item['price']; // Add the current item's price to total
        @endphp
        @endforeach

        <p class="total-price">Total Price: {{ $cartTotalPrice }}€</p>
        <form action="{{route('checkout')}}" method="POST">
            @csrf
            <button>Checkout</button>
        </form>
        @else
        @if(session('cart_empty_message'))
        <div class="alert alert-warning">
            {{ session('cart_empty_message') }}
        </div>
        @endif
        <p class="empty-cart-message">Your shopping cart is empty.</p>
        @endif {{-- Add this line to close the @if directive --}}

    </div>
</div>
@endsection