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
        <h1 class="text-center mb-5 text-secondary">Categories Index</h1>
        @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
        <a class="btn btn-secondary float-right" href="{{ route('category.create')}}">Add</a>
        <h2 class="text-secondary">Categories</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <form action=" {{ route('category.destroy', compact('category')) }} " method="POST">
                                @csrf
                                <a class="btn btn-outline-success" href="{{ route('category.show', compact('category')) }}">Show</a>
                                <a class="btn btn-outline-success" href="{{ route('category.edit', compact('category')) }}">Edit</a>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
@endsection


