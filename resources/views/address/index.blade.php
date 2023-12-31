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
        max-width: 800px; /* Set the maximum width as needed */
        margin: auto; /* Center the table */
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

<div class="container">
    <h1 class="text-center mb-5 text-secondary">Addresses Index</h1>
    <a class="btn btn-secondary float-right" href="{{ route('address.create')}}">Add</a>
    <h2 class="text-secondary">Addresses</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>UserID</th>
                <th>Country</th>
                <th>District</th>
                <th>City</th>
                <th>Street</th>
                <th>Postal-Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($addresses as $address)
            <tr>
                <td>{{ $address->id }}</td>
                @if($address->user)
                <td>{{ $address->user->id }}</td>
                @else
                <td></td>
                @endif

                <td>{{ $address->country }}</td>
                <td>{{ $address->district }}</td>
                <td>{{ $address->city }}</td>
                <td>{{ $address->street }}</td>
                <td>{{ $address->postal_code }}</td>

                <td>
                    <form action=" {{ route('address.destroy', compact('address')) }} " method="POST">
                        @csrf
                        <a class="btn btn-outline-success" href="{{ route('address.show', compact('address')) }}">Show</a>
                        <a class="btn btn-outline-success" href="{{ route('address.edit', compact('address')) }}">Edit</a>
                        <button type="submit" class="btn btn-outline-success">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $addresses->links('pagination::bootstrap-5') }}
</div>
@endsection