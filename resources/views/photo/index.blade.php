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
        <h1 class="text-center mb-5 text-secondary">Photos Index</h1>
        <a class="btn btn-secondary float-right" href="{{ route('photo.create')}}">Add</a>
        <h2 class="text-secondary">Photos</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Path</th>
                    <th>UserID</th>
                    <th>ExperienceID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($photos as $photo)
                    <tr>
                        <td>{{ $photo->id }}</td>
                        <td>{{ $photo->name }}</td>
                        <td>{{ $photo->path }}</td>
                        <td>{{ $photo->user_id }}</td>
                        <td>{{ $photo->experience_id }}</td>
                        <td>
                            <form action=" {{ route('photo.destroy', compact('photo')) }} " method="POST">
                                @csrf
                                <a class="btn btn-outline-success" href="{{ route('photo.show', compact('photo')) }}">Show</a>
                                <a class="btn  btn-outline-success" href="{{ route('photo.edit', compact('photo')) }}">Edit</a>
                                <button type="submit" class="btn btn-outline-success">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
@endsection


