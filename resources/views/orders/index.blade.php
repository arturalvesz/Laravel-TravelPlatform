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
    <h1 class="text-center mb-5 text-secondary">Orders</h1>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead">
                    <tr>
                        @if(auth()->user()->user_type === 'admin')
                        <th style="width: 10%">ID</th>
                        @endif
                        <th style="width: 10%">Status</th>
                        <th style="width: 10%">Total Price</th>
                        <th style="width: 10%">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        @if(auth()->user()->user_type === 'admin')
                        <td>{{ $order->id }}</td>
                        @endif
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->totalPrice }}</td>
                        <td>
                            <a class="btn btn-outline-success btn-sm" href="{{ route('orders.show', compact('order')) }}">Show</a>
                            @if($order->status === 'paid')
                            <a class="btn btn-outline-success btn-sm" href="{{ route('pdf.download', ['order' => $order->id ]) }}" target="_blank" rel="noopener">PDF</a>
                            @endif
                        </td>
                    </tr>
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