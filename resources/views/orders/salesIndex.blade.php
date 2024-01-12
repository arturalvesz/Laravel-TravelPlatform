@extends('layouts.app')

@section('content')
<style>
    /* Your existing CSS styling */
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

    .table-container {
        max-width: 800px;
        /* Set the maximum width as needed */
        margin: auto;
        /* Center the table */
    }

    .table {
        border-radius: 15px;
        overflow: hidden;
    }

    .table th,
    .table td {
        text-align: center;
        padding: 6px;
    }

    .table th {
        background-color: #198754;
        color: #fff;
    }

    .table a.btn-sm {
        font-size: 12px;
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-5 text-secondary">Your Experiences Sales</h1>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead">
                    <tr>
                        <th style="width: 20%">Experience Name</th>
                        <th style="width: 20%">Buyer Name</th>
                        <th style="width: 20%">Number of Tickets</th>
                        <th style="width: 20%">Price</th>
                        <th style="width: 20%">Bought at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    @foreach($order->orderExperiences as $orderExperience)
                    @php
                    $experience = $experiences->where('id', $orderExperience->experience_id)->first();
                    @endphp
                    <tr>
                        <td>{{ $experience->name }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $orderExperience->num_tickets }}</td>
                        <td>{{ $orderExperience->price }}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection